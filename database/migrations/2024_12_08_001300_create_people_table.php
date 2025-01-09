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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // 人物名
            $table->foreignId('company_id')->nullable()->constrained('companies'); // 所属する会社
            $table->string('contact')->nullable(); // 連絡先
            $table->string('status')->default('active'); // ステータス
            $table->text('remarks')->nullable();  // 備考
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
