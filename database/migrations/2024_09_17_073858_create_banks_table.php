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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->stirng('name');
            $table->integer('num_offices');
            $table->integer('num_atms');
            $table->integer('num_employees');
            $table->integer('num_clients');
            $table->integer('rating');
            $table->decimal('amount', 20, 2);
            $table->decimal('percentage_rate', 20, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};