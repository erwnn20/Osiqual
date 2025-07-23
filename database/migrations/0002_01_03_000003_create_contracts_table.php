<?php

use App\Models\Company;
use App\Models\Contract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->foreignIdFor(Company::class)
                ->constrained()
                ->restrictOnDelete();
            $table->foreignIdFor(Contract::class, 'parent_contract_id')
                ->nullable()
                ->default(null)
                ->constrained()
                ->nullOnDelete();
            $table->date('start_date');
            $table->date('end_date')->nullable()->default(null);
            $table->foreignIdFor(Contract\ContractType::class, 'type_id')
                ->constrained()
                ->restrictOnUpdate()
                ->restrictOnDelete();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
