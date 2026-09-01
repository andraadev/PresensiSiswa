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
        Schema::create('counselings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('user')->cascadeOnDelete();

            $table->date('action_date');
            $table->enum('action_type', [
                'Konseling Individu',
                'Panggilan Orang Tua',
                'Kunjungan Rumah',
                'Peringatan Lisan'
            ]);

            $table->text('problem_notes');
            $table->text('agreement_result');

            $table->enum('status', [
                'Belum Ditangani',
                'Sedang Dipantau',
                'Selesai'
            ])->default('Sedang Dipantau');

            $table->index(['student_id', 'status']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselings');
    }
};
