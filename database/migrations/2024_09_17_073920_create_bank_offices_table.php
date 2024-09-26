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
        Schema::create('bank_offices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('status');
            $table->boolean('can_place_bank_atm');
            $table->boolean('can_top_up');
            $table->boolean('can_withdraw');
            $table->boolean('can_credit');
            $table->unsignedBigInteger('bank_id');
            $table->decimal('amount', 20, 3);
            $table->decimal('rent_cost', 20, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_offices');
    }
};
