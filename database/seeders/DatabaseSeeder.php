<?php

namespace Database\Seeders;

use App\Models\Pengaduan;
use App\Models\PengaduanHistory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database without any dummy complaints.
     */
    public function run(): void
    {
        // 1. Create or Update Core System Administrator
        User::updateOrCreate(
            ['email' => 'admin.pengaduan@smkn2kra.sch.id'],
            [
                'name' => 'Administrator SIADU (Haryanto, S.Pd)',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'nip_nisn' => '197805122005011003',
                'unit' => 'Administrator & Verifikator Pengaduan',
                'phone' => '081234567891',
            ]
        );

        // Remove any non-admin accounts
        User::where('role', '!=', 'admin')->delete();

        // Clear dummy complaints and history records for clean production state
        PengaduanHistory::query()->delete();
        Pengaduan::query()->delete();
    }
}
