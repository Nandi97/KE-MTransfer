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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['mpesa', 'airtel', 'bank']);
            $table->string('identifier'); // phone number or email
            $table->string('provider_name')->nullable(); // e.g., 'Equity Bank'
            $table->boolean('is_primary')->default(false); // for default account
            $table->decimal('balance', 12, 2)->default(0); // optional local caching
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
