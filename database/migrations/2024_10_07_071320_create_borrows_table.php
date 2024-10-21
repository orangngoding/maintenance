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
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('item_id')->constrained();
            $table->string('borrow_name');
            $table->date('borrow_start');
            $table->date('borrow_finish')->nullable();
            // $table->enum('borrow_status', [
            //     'pending', 'active', 'finish',
            // ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
