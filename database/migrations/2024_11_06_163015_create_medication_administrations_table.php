<?php

namespace App\Http\Controllers;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicationAdministrationsTable extends Migration
{
    public function up()
    {
        Schema::create('medication_administrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('newborn_id')->constrained('newborns')->onDelete('cascade'); // Foreign key linking to newborns table
            $table->string('medication_type'); // Medication type (updated to match your store method)
            $table->string('dose'); // Medication dose (updated to match your store method)
            $table->string('administration_time'); // Administration time (updated to match your store method)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medication_administrations');
    }
}