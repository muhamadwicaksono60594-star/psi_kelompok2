<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PendaftaranSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Daftar jurusan relevan dengan bidang Radar Kediri
        $jurusanList = [
            'Ilmu Komunikasi',
            'Jurnalistik',
            'Desain Grafis',
            'Multimedia',
            'Teknik Komputer dan Jaringan',
            'Sistem Informasi',
            'Manajemen Media',
            'Teknologi Informasi',
            'Broadcasting',
            'Public Relations',
        ];

        // 🔹 Daftar instansi acak
        $instansiList = [
            'Universitas Brawijaya',
            'Universitas Negeri Malang',
            'Politeknik Kediri',
            'Universitas Nusantara PGRI Kediri',
            'SMK Negeri 1 Kediri',
            'SMK Telkom Malang',
            'Universitas Airlangga',
            'Universitas Muhammadiyah Malang',
            'Institut Teknologi Sepuluh Nopember',
            'Universitas Islam Kadiri'
        ];

        // 🔹 Status dan Jenis
        $statusList = ['menunggu', 'diterima', 'ditolak'];

        // 🔹 Generate 50 data acak untuk tahun 2024–2025
        for ($i = 0; $i < 50; $i++) {
            $tahun = rand(2024, 2025);
            $createdAt = Carbon::create($tahun, rand(1, 12), rand(1, 28));

            $nama = fake()->name();
            $email = Str::slug($nama) . '@example.com';
            $instansi = $instansiList[array_rand($instansiList)];
            $jurusan = $jurusanList[array_rand($jurusanList)];
            $nim = rand(21000000, 24000000);
            $telepon = '08' . rand(1000000000, 9999999999);
            $status = $statusList[array_rand($statusList)];
            $alamat = fake()->address();

            // 🔹 Buat akun user jika belum ada
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $nama,
                    'password' => Hash::make('password'),
                    'jenjang' => str_contains($instansi, 'SMK') ? 'Siswa' : 'Mahasiswa',
                    'role' => 'user',
                ]
            );

            // 🔹 Tambahkan data pendaftaran
            Pendaftaran::create([
                'user_id' => $user->id,
                'nama' => $nama,
                'asal_instansi' => $instansi,
                'jurusan' => $jurusan,
                'nim_nis' => $nim,
                'no_telepon' => $telepon,
                'alamat' => $alamat,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Seeder pendaftar acak 2024–2025 berhasil ditambahkan tanpa menghapus data manual!');
    }
}
