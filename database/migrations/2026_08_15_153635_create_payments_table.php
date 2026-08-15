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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->enum('method', [
                'CASH',
                'CARD',
                'KHQR',
            ]);

            $table->decimal('amount', 12, 2);

            $table->enum('status', [
                'PENDING',
                'PAID',
                'FAILED',
                'REFUNDED',
            ])->default('PENDING');

            $table->string('transaction_reference')
                ->nullable();

            $table->timestamp('paid_at')
                ->nullable();

            // $table->jsonb('metadata')
            //     ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
