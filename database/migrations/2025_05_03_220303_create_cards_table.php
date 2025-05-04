<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('national_id');
            $table->string('phone');
            $table->string('card_number');
            $table->string('pin');
            $table->string('status');
            $table->string('matching_state');
            $table->text('notes');
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->string('account_number');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
