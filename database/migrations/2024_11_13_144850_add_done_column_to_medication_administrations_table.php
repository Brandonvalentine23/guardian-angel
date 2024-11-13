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
        Schema::table('medication_administrations', function (Blueprint $table) {
            $table->boolean('done')->default(false); // Add a 'done' column to mark medications
        });
    }
    
    public function down()
    {
        Schema::table('medication_administrations', function (Blueprint $table) {
            $table->dropColumn('done');
        });
    }
};
