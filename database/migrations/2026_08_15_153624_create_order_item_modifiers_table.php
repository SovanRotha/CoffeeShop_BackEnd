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
        Schema::create('order_item_modifiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')
                ->constrained('order_items')
                ->cascadeOnDelete();

            $table->foreignId('modifier_id')
                ->constrained('modifiers')
                ->restrictOnDelete();

            $table->foreignId('modifier_option_id')
                ->constrained('modifier_options')
                ->restrictOnDelete();

            $table->decimal('quantity', 10, 2)
                ->nullable();

            $table->decimal('price_adjustment', 12, 2)
                ->default(0);

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_modifiers');
    }
};
