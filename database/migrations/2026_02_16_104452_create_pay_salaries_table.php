<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pay_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            
            // --- Payroll Cycle Configuration ---
            // Options: 'weekly', 'bi-monthly', 'monthly'
            $table->string('pay_type')->default('monthly'); 
            
            // Period Tracking
            $table->string('salary_month'); 
            $table->year('salary_year');
            
            // Start and End dates of the specific pay period
            // Example: Weekly might be June 1 to June 7
            // Example: Bi-monthly might be June 1 to June 15
            $table->date('period_start');
            $table->date('period_end');

            // --- Financials ---
            $table->decimal('basic_salary', 12, 2)->default(0.00);
            $table->decimal('advance_salary', 12, 2)->default(0.00);
            $table->decimal('allowance', 12, 2)->default(0.00);
            $table->decimal('deduction', 12, 2)->default(0.00);
            $table->decimal('paid_amount', 12, 2)->default(0.00); // The final "Take Home" pay
            $table->decimal('due_salary', 12, 2)->default(0.00);
            
            // --- Audit & Status ---
            $table->date('payment_date')->nullable();
            $table->string('payment_method')->nullable(); 
            $table->string('transaction_id')->nullable();
            $table->string('status')->default('pending'); // pending, paid, partial
            
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['employee_id', 'period_start', 'period_end']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pay_salaries');
    }
};