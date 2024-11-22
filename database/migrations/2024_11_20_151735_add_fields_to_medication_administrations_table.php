<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToMedicationAdministrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('medication_administrations', function (Blueprint $table) {
            $table->unsignedInteger('newborn_id')->default(0);
            $table->string('medication_name'); // Name of the medication
            // $table->string('medication_type'); // Type of medication
            $table->string('frequency'); // Frequency of administration
            $table->string('route'); // Route of administration (oral, IV, etc.)
            $table->datetime('administration_time'); // Time of administration
            $table->string('dose'); // Dosage in mg or ml
            $table->string('diagnosis')->nullable(); // Diagnosis or reason for medication
            $table->text('instructions')->nullable(); // Special instructions
            $table->string('administered_by'); // Medical personnel administering the medication
            $table->string('birth_weight')->nullable(); // Birth weight of the newborn (optional)
            $table->string('gestational_age')->nullable(); // Gestational age in weeks (optional)
            $table->unsignedInteger('done')->default(0); // Status column, default false 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('medication_administrations');
    }
}
