<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewbornsTable extends Migration
{
    public function up()
    {
        Schema::create('newborns', function (Blueprint $table) {
            $table->id();
            $table->string('newborn_name');
            $table->date('newborn_dob');
            $table->string('gender');
            $table->decimal('birth_weight', 5, 2);
            $table->string('blood_type')->nullable();
            $table->string('health_conditions')->nullable();

            // Add foreign key to reference the mother
            $table->unsignedBigInteger('mother_id');  
            $table->foreign('mother_id')->references('id')->on('mothers')->onDelete('cascade');

            $table->string('mother_name')->nullable();
            $table->string('mother_religion')->nullable();

            // Optional father information
            $table->string('father_name')->nullable();
            $table->string('father_religion')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('newborns');
    }
}
