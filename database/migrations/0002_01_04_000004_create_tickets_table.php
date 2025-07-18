<?php

use App\Models\Company;
use App\Models\Contract;
use App\Models\Ticket\TicketCriticality;
use App\Models\Ticket\TicketPriority;
use App\Models\Ticket\TicketStatus;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignIdFor(User::class, 'technician_id')
                ->nullable()
                ->default(null)
                ->constrained()
                ->nullOnDelete();
            $table->foreignIdFor(User::class, 'client_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignIdFor(Company::class)
                ->constrained()
                ->restrictOnDelete();
            $table->foreignIdFor(Contract::class)
                ->constrained()
                ->restrictOnDelete();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->unsignedInteger('duration')->default(0);
            $table->foreignIdFor(TicketStatus::class, 'status_id')
                ->constrained()
                ->restrictOnDelete();
            $table->foreignIdFor(TicketPriority::class, 'priority_id')
                ->constrained()
                ->restrictOnDelete();
            $table->foreignIdFor(TicketCriticality::class, 'criticality_id')
                ->constrained()
                ->restrictOnDelete();
            $table->timestamp('creation_date');
            $table->timestamp('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
