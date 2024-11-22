<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNewbornTable extends Migration
{
    public function up()
    {
        Schema::table('newborns', function (Blueprint $table) {
            $table->dropColumn(['mother_religion', 'father_name', 'father_religion']);
            $table->string('gestational_age')->nullable(); // Add new field for gestational age
            $table->string('birth_notes')->nullable(); // Add new field for special birth notes or context
        });
    }

    public function down()
    {
        Schema::table('newborns', function (Blueprint $table) {
            $table->string('mother_religion')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_religion')->nullable();
            $table->dropColumn(['gestational_age', 'birth_notes']);
        });
    }
}