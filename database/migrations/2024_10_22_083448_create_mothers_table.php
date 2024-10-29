<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('mothers', function (Blueprint $table) {
        $table->id();
        $table->string('identity_card_number')->unique();
        $table->string('mother_name');
        $table->enum('sex', ['female', 'male']);
        $table->date('mother_dob');
        $table->string('phone_number');
        $table->string('email')->nullable();
        $table->string('marital_status')->nullable();
        $table->boolean('minor_status')->default(false);
        $table->enum('blood_type', ['A', 'B', 'AB', 'O'])->nullable();
        $table->string('allergies')->nullable();
        $table->text('pregnancy_history')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mothers');
    }
};
