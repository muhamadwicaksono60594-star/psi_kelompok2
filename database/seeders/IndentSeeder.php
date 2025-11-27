<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Indent;
use App\Models\User;
use Faker\Factory as Faker;

class IndentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Daftar instansi yang sering berpartner dengan Radar Kediri
        $instansi = [
            'Universitas Nusantara PGRI Kediri',
            'Universitas Islam Kadiri',
            'Universitas Brawijaya',
            'Universitas Negeri Malang',
            'Politeknik Negeri Malang',
            'SMK Negeri 1 Kediri',
            'SMK Negeri 2 Kediri',
            'SMK Telkom Malang',
            'Universitas Kadiri',
            'Politeknik Negeri Kediri',
        ];

        // Jurusan relevan dengan bidang Radar Kediri (multimedia, jurnalistik, IT)
        $jurusan = [
            'Manajemen Media',
            'Desain Komunikasi Visual',
            'Manajemen Informatika',
            'Teknik Komputer',
            'Jurnalistik',
            'Broadcasting',
            'Teknik Multimedia',
            'Sistem Informasi',
            'Teknik Informatika',
            'Ilmu Komunikasi',
        ];

        $status = ['menunggu', 'diterima', 'ditolak'];

        // Buat 1 user utama agar relasi user_id valid
        $user = User::firstOrCreate(
            ['email' => 'indent_user@example.com'],
            [
                'name' => 'User Indent Seeder',
                'password' => bcrypt('password123'),
                'jenjang' => 'Mahasiswa',
                'role' => 'user',
            ]
        );

        // Tambahkan data dummy sebanyak 50 baris
        for ($i = 1; $i <= 50; $i++) {
            $tanggalMulai = $faker->dateTimeBetween('2024-01-01', '2025-12-31');
            // Tambahkan durasi 1–3 bulan setelah tanggal mulai
            $tanggalSelesai = (clone $tanggalMulai)->modify('+' . rand(30, 90) . ' days');

            Indent::create([
                'user_id' => $user->id,
                'nama' => $faker->name,
                'asal_instansi' => $faker->randomElement($instansi),
                'jurusan' => $faker->randomElement($jurusan),
                'nim_nis' => $faker->numerify('##########'),
                'no_telepon' => '08' . $faker->numerify('##########'),
                'alamat' => $faker->address,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'status' => $faker->randomElement($status),
            ]);
        }
    }
}
