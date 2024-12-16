<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware_statuses', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('device')->unique(); // Unique identifier for the device (e.g., "Main Door A")
            $table->string('ip_address'); // IP address of the device
            $table->string('reader_status'); // Status of the RFID reader (e.g., "Operational", "Not Responding")
            $table->timestamp('last_heartbeat')->nullable(); // Last time the device sent a heartbeat
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hardware_statuses');
    }
}