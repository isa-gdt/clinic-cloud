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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            $table->string('text');
            $table->enum('status', ['pending', 'in_progress', 'completed'])
                ->default('pending');
            $table->timestamps();

            $table->index(['created_by','status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
