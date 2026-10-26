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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number', 50)->unique()->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            // Kategori & Jenis Pelapor
            $table->string('kategori', 100)->index();
            $table->string('kategori_definitif', 100)->nullable();
            $table->string('jenis_pelapor', 50); // Siswa, Guru, Tenaga kependidikan, Orang tua/wali
            $table->string('nama_pelapor', 150);
            $table->string('kontak', 50)->nullable();
            $table->boolean('is_anonim')->default(false);

            // Detail Aduan
            $table->string('judul', 255);
            $table->string('lokasi', 255)->nullable();
            $table->text('uraian');
            $table->string('urgensi_pelapor', 50)->default('Normal'); // Normal, Mendesak, Ada risiko keselamatan
            $table->string('urgensi_admin', 50)->nullable();
            $table->string('bukti_pelapor')->nullable();

            // Status Alur
            // Status: masuk -> terverifikasi -> dalam_proses -> menunggu_konfirmasi -> selesai (or ditolak)
            $table->string('status', 40)->default('masuk')->index();

            // Penugasan Unit & Petugas
            $table->string('unit_tujuan', 150)->nullable()->index();
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_petugas', 150)->nullable();
            $table->dateTime('deadline')->nullable();
            $table->text('catatan_admin')->nullable();

            // Pengerjaan Petugas & Hasil
            $table->text('catatan_petugas')->nullable();
            $table->string('suku_cadang', 255)->nullable();
            $table->string('bukti_petugas')->nullable();

            // Penutupan Resmi Admin
            $table->text('admin_close_feedback')->nullable();

            // Kepuasan Pelapor (Review)
            $table->unsignedTinyInteger('rating')->nullable(); // 1 - 5
            $table->text('ulasan_pelapor')->nullable();

            // Timestamp Tanggal Kejadian & Selesai
            $table->dateTime('tanggal_lapor')->useCurrent()->index();
            $table->dateTime('tanggal_selesai')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
