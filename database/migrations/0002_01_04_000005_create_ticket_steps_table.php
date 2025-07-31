<?php

use App\Models\Ticket;
use App\Models\User;
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
        Schema::create('ticket_steps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(Ticket::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(User::class , 'technician_id')
                ->constrained()
                ->restrictOnDelete();
            $table->longText('description')->nullable();
            $table->timestamp('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_steps');
    }
};
