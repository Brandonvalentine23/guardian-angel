<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMotherIdNullableInNewbornsTable extends Migration
{
    public function up()
    {
        Schema::table('newborns', function (Blueprint $table) {
            $table->unsignedBigInteger('mother_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('newborns', function (Blueprint $table) {
            $table->unsignedBigInteger('mother_id')->nullable(false)->change();
        });
    }
}