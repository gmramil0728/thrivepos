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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique(); // Professional tracking
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); 
            $table->text('details');
            $table->decimal('amount', 15, 2); // Correct way to store money
            $table->date('date'); // Use actual date type
            $table->string('month'); // For quick filtering
            $table->string('year');  // For quick filtering
            $table->string('receipt')->nullable(); // Upload receipt images
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
