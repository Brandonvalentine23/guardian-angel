<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRfidUidToNewbornsTable extends Migration
{
    public function up()
    {
        Schema::table('newborns', function (Blueprint $table) {
            $table->string('rfid_uid')->nullable(); // Add the RFID UID column
        });
    }

    public function down()
    {
        Schema::table('newborns', function (Blueprint $table) {
            $table->dropColumn('rfid_uid'); // Remove the column if the migration is rolled back
        });
    }
}