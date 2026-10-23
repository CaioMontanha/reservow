<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('passeios', function (Blueprint $table) { $table->id(); $table->string('nome'); $table->string('slug')->unique(); $table->unsignedSmallInteger('capacidade_padrao'); $table->unsignedInteger('preco_centavos')->default(0); $table->boolean('ativo')->default(true); $table->timestamps(); });
        Schema::create('saidas', function (Blueprint $table) { $table->id(); $table->foreignId('passeio_id')->constrained()->cascadeOnDelete(); $table->date('data'); $table->time('horario'); $table->unsignedSmallInteger('vagas_total'); $table->unique(['passeio_id', 'data', 'horario']); });
        Schema::create('reservas', function (Blueprint $table) { $table->id(); $table->foreignId('saida_id')->constrained()->cascadeOnDelete(); $table->string('codigo', 8)->unique(); $table->string('nome_cliente'); $table->string('telefone', 30); $table->unsignedTinyInteger('pessoas'); $table->enum('status', ['pendente', 'confirmada', 'cancelada'])->default('pendente'); $table->timestamp('confirmada_em')->nullable(); $table->timestamp('cancelada_em')->nullable(); $table->timestamps(); $table->index(['saida_id', 'status']); });
    }
    public function down(): void { Schema::dropIfExists('reservas'); Schema::dropIfExists('saidas'); Schema::dropIfExists('passeios'); }
};
