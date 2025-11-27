<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pendaftaran;
use App\Models\Indent;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $statusList = ['menunggu', 'diterima', 'ditolak'];
        $instansiList = [
            'SMK Telkom Malang',
            'SMKN 8 Malang',
            'Universitas Brawijaya',
            'Universitas Negeri Malang',
            'Politeknik Negeri Malang',
            'Universitas Islam Malang',
            'Universitas Muhammadiyah Malang',
            'SMK Negeri 1 Surabaya',
            'Institut Teknologi Sepuluh Nopember'
        ];

        $jurusanList = [
            'Teknik Informatika',
            'Rekayasa Perangkat Lunak',
            'Sistem Informasi',
            'Manajemen Informatika',
            'Teknik Komputer dan Jaringan',
            'Desain Komunikasi Visual',
            'Administrasi Perkantoran',
        ];

        // Generate data untuk tahun 2024 dan 2025
        foreach ([2024, 2025] as $tahun) {

            // ===== Data untuk tabel pendaftaran (lowongan) =====
            for ($i = 1; $i <= 80; $i++) {
                $tanggalMulai = Carbon::create($tahun, rand(1, 12), rand(1, 25));
                $tanggalSelesai = (clone $tanggalMulai)->addWeeks(rand(1, 8));

                Pendaftaran::create([
                    'nama' => $faker->name(),
                    'alamat' => $faker->address(),
                    'instansi' => collect($instansiList)->random(),
                    'jurusan' => collect($jurusanList)->random(),
                    'nim_nis' => $faker->numerify('#######'),
                    'telepon' => $faker->phoneNumber(),
                    'status' => collect($statusList)->random(),
                    'tanggal_mulai' => $tanggalMulai,
                    'tanggal_selesai' => $tanggalSelesai,
                    'pdf_url' => null,
                    'created_at' => Carbon::create($tahun, rand(1, 12), rand(1, 28)),
                    'updated_at' => now(),
                ]);
            }

            // ===== Data untuk tabel indent =====
            for ($j = 1; $j <= 50; $j++) {
                $tanggalMulai = Carbon::create($tahun, rand(1, 12), rand(1, 25));
                $tanggalSelesai = (clone $tanggalMulai)->addWeeks(rand(1, 8));

                Indent::create([
                    'nama' => $faker->name(),
                    'alamat' => $faker->address(),
                    'instansi' => collect($instansiList)->random(),
                    'jurusan' => collect($jurusanList)->random(),
                    'nim_nis' => $faker->numerify('#######'),
                    'telepon' => $faker->phoneNumber(),
                    'status' => collect($statusList)->random(),
                    'tanggal_mulai' => $tanggalMulai,
                    'tanggal_selesai' => $tanggalSelesai,
                    'pdf_url' => null,
                    'created_at' => Carbon::create($tahun, rand(1, 12), rand(1, 28)),
                    'updated_at' => now(),
                ]);
            }
        }

        echo "✅ Dummy data lengkap untuk tahun 2024 & 2025 berhasil dibuat!\n";
    }
}
