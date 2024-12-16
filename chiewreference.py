# Imports
import json
import network
import time
import socket
import _thread
from machine import Pin, SPI
from mfrc522 import MFRC522

# Wi-Fi Configuration
WIFI_SSID = "Beat"
WIFI_PASSWORD = "hishamfarah11"

# Laravel Backend URL
BACKEND_URL = "http://192.168.0.14:8000/api/location-log"

# Initialize RFID readers for two different SPI configurations
reader_server = MFRC522(spi_id=0, sck=2, miso=4, mosi=3, cs=1, rst=0)
reader_tracking = MFRC522(spi_id=1, sck=10, miso=12, mosi=11, cs=5, rst=6)

# Connect to Wi-Fi
wlan = network.WLAN(network.STA_IF)
wlan.active(True)
wlan.connect(WIFI_SSID, WIFI_PASSWORD)

# Wait until the Wi-Fi is connected
while not wlan.isconnected():
    pass

print("Connected to WiFi, IP Address:", wlan.ifconfig()[0])

def check_status():
    """Check the status of Raspberry Pi Pico and RFID readers."""
    pico_status = "ON"  # Always ON if code is running
    
    # Check RFID reader statuses by sending dummy requests
    try:
        (server_status, _) = reader_server.request(reader_server.REQIDL)
        (tracking_status, _) = reader_tracking.request(reader_tracking.REQIDL)
        
        rfid_server_status = "ON" if server_status == reader_server.OK else "OFF"
        rfid_tracking_status = "ON" if tracking_status == reader_tracking.OK else "OFF"
    except Exception as e:
        print("RFID status check error:", str(e))
        rfid_server_status = rfid_tracking_status = "OFF"
    
    return {
        "pico": pico_status, 
        "rfid_server": rfid_server_status, 
        "rfid_tracking": rfid_tracking_status
    }

def log_rfid(uid):
    """Send the RFID UID to the Laravel backend with enhanced error handling"""
    try:
        # Detailed logging of function entry
        print(f"Logging RFID UID: {uid}")
        print(f"Backend URL: {BACKEND_URL}")
        
        # Import urequests at function level to ensure it's available
        import urequests
        
        # Prepare payload
        payload = {"uid": uid}
        headers = {"Content-Type": "application/json"}

        try:
            # Send POST request
            response = urequests.post(BACKEND_URL, json=payload, headers=headers)
            print(f"Response status code: {response.status_code}")
            
            # # Check response status
            # if response.status_code == 200:
            #     print(f"Successfully logged UID: {uid}")
            #     try:
            #         # Optional: parse and log response content if needed
            #         response_data = response.json()
            #         print(f"Server Response: {response_data}")
            #     except ValueError:
            #         print("Received response, but could not parse JSON")
            # else:
            #     print(f"Failed to log UID. Status code: {response.status_code}")
            #     print(f"Response Text: {response.text}")
            
            # # Always close the response to free resources
            response.close()

            print("Request closed")
        
        except Exception as network_error:
            # Catch-all for any other network-related errors
            print(f"Network Error: {network_error}")
            print(f"Error Type: {type(network_error).__name__}")
    
    except Exception as unexpected_error:
        # Catch any unexpected errors in the entire function
        print(f"Unexpected Error in log_rfid: {unexpected_error}")
        
        # Optional: import sys to get more detailed traceback
        import sys
        sys.print_exception(unexpected_error)

def rfid_tracking_thread():
    """Thread for continuously tracking RFID tags."""
    while True:
        try:
            # Reset the reader before each scan
            reader_tracking.init()

            # Scan with tracking RFID reader
            status, tag_type = reader_tracking.request(reader_tracking.REQIDL)

            if status == 0:  # Successful scan
                status, uid = reader_tracking.anticoll(reader_tracking.PICC_ANTICOLL1)

                if status == 0:
                    uid_str = ''.join([str(i) for i in uid])
                    print(f"Detected RFID UID for Tracking: {uid_str}")

                    # Log to backend
                    log_rfid(uid_str)

        except Exception as e:
            print(f"RFID Tracking Error: {e}")

        time.sleep(1)  # Avoid overwhelming the system with rapid scans

# Start the RFID tracking thread
_thread.start_new_thread(rfid_tracking_thread, ())

# Set up a simple HTTP server
addr = socket.getaddrinfo("0.0.0.0", 80)[0][-1]
s = socket.socket()
s.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)  # Reuse the address
s.bind(addr)
s.listen(1)

print("Listening on", addr)

try:
    # Main HTTP server loop
    while True:
        cl, addr = s.accept()
        print("Connection from", addr)
        
        try:
            # Receive the HTTP request
            request = cl.recv(1024).decode('utf-8')
            print("Request:", request)
            
            if "/status" in request:
                # Check the status of Pico and RFID readers
                status = check_status()
                response = json.dumps(status)
                cl.send("HTTP/1.1 200 OK\r\nContent-Type: application/json\r\nAccess-Control-Allow-Origin: *\r\n\r\n")
                cl.send(response)
            else:
                # Reset the RFID reader before scanning
                reader_server.init()
                
                # Scan with server RFID reader
                status, tag_type = reader_server.request(reader_server.REQIDL)

                if status == 0:
                    status, uid = reader_server.anticoll(reader_server.PICC_ANTICOLL1)
                    if status == 0:
                        uid_str = "".join([str(i) for i in uid])
                        print("RFID UID:", uid_str)
                        response = json.dumps({"uid": uid_str})
                        cl.send("HTTP/1.1 200 OK\r\nContent-Type: application/json\r\nAccess-Control-Allow-Origin: *\r\n\r\n")
                        cl.send(response)
                    else:
                        cl.send("HTTP/1.1 500 Internal Server Error\r\nContent-Type: text/plain\r\nAccess-Control-Allow-Origin: *\r\n\r\n")
                        cl.send("Failed to read RFID UID.")
                else:
                    cl.send("HTTP/1.1 404 Not Found\r\nContent-Type: text/plain\r\nAccess-Control-Allow-Origin: *\r\n\r\n")
                    cl.send("No RFID UID detected.")
        except Exception as e:
            print("Error processing request:", e)
            cl.send("HTTP/1.1 500 Internal Server Error\r\nContent-Type: text/plain\r\nAccess-Control-Allow-Origin: *\r\n\r\n")
            cl.send("An error occurred while processing the request.")
        finally:
            cl.close()
except KeyboardInterrupt:
    print("Shutting down the server...")
finally:
    s.close()

