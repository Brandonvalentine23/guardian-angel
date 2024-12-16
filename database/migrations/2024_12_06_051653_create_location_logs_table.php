<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('location_log', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->string('location'); // Location name
            $table->timestamp('logged_at'); // Timestamp of the log
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_log');
    }
};
