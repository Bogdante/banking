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
        Schema::create('credit_accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id');
            $table->string('bank_name');
            $table->timestamp('start_credit');
            $table->timestamp('end_credit');
            $table->integer('month_credit');
            $table->decimal('credit_sum', 20, 3);
            $table->decimal('month_pay', 20, 3);
            $table->decimal('percentage_rate', 20, 3);
            $table->bigInteger('employee_id');
            $table->bigInteger('payment_account_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_accounts');
    }
};
