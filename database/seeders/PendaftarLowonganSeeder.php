<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pendaftaran;
use App\Models\Lowongan;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class PendaftarLowonganSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Nama khas Indonesia (unik, tidak diulang)
        $namaIndonesia = [
            'Budi Santoso', 'Agus Prasetyo', 'Dewi Lestari', 'Siti Rahmawati', 'Putri Aulia',
            'Rizky Maulana', 'Nurul Hidayah', 'Rina Kartika', 'Andi Saputra', 'Teguh Wibowo',
            'Mega Oktaviani', 'Fajar Kurniawan', 'Indah Permata Sari', 'Yuli Astuti', 'Arif Rahman',
            'Dian Safitri', 'Hendra Setiawan', 'Citra Maharani', 'Dimas Pratama', 'Lia Anggraini',
            'Rafi Ahmad', 'Zahra Fitriani', 'Eka Purnama', 'Lukman Hakim', 'Nadia Ayu Lestari',
            'Hana Putri', 'Bambang Irawan', 'Aulia Rahman', 'Farhan Setiadi', 'Retno Dwi Cahyani',
            'Ahmad Fauzi', 'Febri Handayani', 'Aditia Prakoso', 'Maya Sari Dewi', 'Reza Mahendra',
            'Tia Anggraeni', 'Imam Syafi’i', 'Yudha Permana', 'Intan Maharani', 'Reno Prabowo',
            'Gita Lestari', 'Anisa Safitri', 'Yoga Pratama', 'Andika Saputra', 'Sari Wulandari',
            'Nanda Wijaya', 'Putra Hermawan', 'Melati Kusuma', 'Adit Nugraha', 'Rina Aprilia'
        ];

        $asalInstansi = [
            'Universitas Brawijaya',
            'Universitas Nusantara PGRI Kediri',
            'Universitas Islam Kadiri',
            'Universitas Negeri Malang',
            'Politeknik Negeri Malang',
            'SMK Negeri 1 Kediri',
            'SMK Negeri 2 Kediri',
            'SMK Negeri 3 Kediri'
        ];

        $jurusanList = [
            'Manajemen Informatika',
            'Teknik Informatika',
            'Desain Komunikasi Visual',
            'Jurnalistik',
            'Sistem Informasi',
            'Produksi Media',
            'Broadcasting',
            'Administrasi Perkantoran'
        ];

        // Pastikan ada user default
        $user = User::firstOrCreate(
            ['email' => 'dummyuser@example.com'],
            [
                'name' => 'Dummy User',
                'password' => bcrypt('password123'),
                'jenjang' => 'Mahasiswa',
                'role' => 'user',
            ]
        );

        $lowongans = Lowongan::all();
        if ($lowongans->isEmpty()) {
            $this->command->warn("⚠️ Tidak ada data lowongan. Jalankan LowonganSeeder dulu.");
            return;
        }

        // Tentukan jumlah maksimal pendaftar (sebanyak nama tersedia)
        $jumlahPendaftar = count($namaIndonesia);

        // Acak urutan nama agar tidak berurutan
        shuffle($namaIndonesia);

        for ($i = 0; $i < $jumlahPendaftar; $i++) {
            $low = $lowongans->random();

            // Ambil nama unik dari daftar (tidak akan terduplikasi)
            $nama = $namaIndonesia[$i];

            // Ambil tanggal dari lowongan
            $tanggalMulai = Carbon::parse($low->tanggal_mulai);
            $tanggalSelesai = Carbon::parse($low->tanggal_selesai);

            // Tanggal pendaftaran dibuat sebelum magang dimulai
            $createdAt = $faker->dateTimeBetween(
                $tanggalMulai->copy()->subDays(60),
                $tanggalMulai
            );

            Pendaftaran::create([
                'user_id' => $user->id,
                'lowongan_id' => $low->id,
                'nama' => $nama,
                'asal_instansi' => $faker->randomElement($asalInstansi),
                'jurusan' => $faker->randomElement($jurusanList),
                'nim_nis' => $faker->numerify('23######'),
                'no_telepon' => '08'.$faker->numerify('##########'),
                'alamat' => 'Jl. '.$faker->streetName.' No. '.$faker->buildingNumber.', '.$faker->city,
                'status' => $faker->randomElement(['menunggu', 'diterima', 'ditolak']),
                'tanggal_mulai' => $tanggalMulai->format('Y-m-d'),
                'tanggal_selesai' => $tanggalSelesai->format('Y-m-d'),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }

        $this->command->info("✅ Seeder berhasil! $jumlahPendaftar pendaftar khas Indonesia dibuat otomatis mengikuti tanggal lowongan.");
    }
}
