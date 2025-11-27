<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pendaftaran;
use App\Models\Lowongan;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PendaftaranLowonganSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $lowongans = Lowongan::all();

        if ($lowongans->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada data lowongan! Jalankan LowonganSeeder dulu.');
            return;
        }

        // Daftar nama khas Indonesia tanpa duplikat (acak, realistis)
        $namaList = [
            'Ahmad Fauzi', 'Siti Nurhaliza', 'Budi Santoso', 'Dewi Anggraini', 'Rizky Maulana',
            'Citra Wulandari', 'Andi Saputra', 'Mega Lestari', 'Fajar Ramadhan', 'Putri Ayu',
            'Hendra Kurniawan', 'Rina Oktaviani', 'Teguh Pratama', 'Lina Marlina', 'Agus Setiawan',
            'Yuni Astuti', 'Rani Febrianti', 'Doni Wijaya', 'Nurul Hidayah', 'Arif Budiman',
            'Ayu Lestari', 'Indra Saputra', 'Farah Dwi Utami', 'Eko Prasetyo', 'Tia Kartika',
            'Bagas Rahman', 'Dewi Sartika', 'Reza Pratama', 'Wulan Pertiwi', 'Bayu Aditya',
            'Novi Rahmawati', 'Fajar Setiawan', 'Rahmat Hidayat', 'Intan Sari', 'Siti Aisyah',
            'Hendra Wijaya', 'Anita Sari', 'Yoga Pratama', 'Melani Kusuma', 'Gilang Saputra',
            'Taufik Hidayat', 'Lina Wati', 'Rudi Kurniawan', 'Rina Amalia', 'Andre Maulana',
            'Putra Pratomo', 'Nanda Aprilia', 'Asep Sutrisno', 'Yeni Marlina', 'Dewi Puspita',
        ];

        $instansiList = [
            'Universitas Nusantara PGRI Kediri',
            'Politeknik Negeri Malang',
            'Universitas Brawijaya',
            'Universitas Airlangga',
            'Universitas Negeri Surabaya',
            'SMKN 1 Kediri',
            'SMKN 2 Kediri',
            'Universitas Muhammadiyah Malang',
        ];

        $jurusanList = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Desain Komunikasi Visual',
            'Manajemen Informatika',
            'Multimedia',
            'Jurnalistik',
            'Pemasaran Digital',
            'Teknik Komputer dan Jaringan',
        ];

        $nimStart = 2401000; // tahun 2024

        $totalRecords = 50; // jumlah total dummy data
        $usedNames = [];

        for ($i = 0; $i < $totalRecords; $i++) {
            // Pilih nama unik
            do {
                $nama = $faker->unique()->randomElement($namaList);
            } while (in_array($nama, $usedNames));
            $usedNames[] = $nama;

            // Pilih lowongan acak
            $lowongan = $lowongans->random();

            // Ambil tanggal mulai dan selesai dari lowongan
            $tanggalMulai = Carbon::parse($lowongan->tanggal_mulai);
            $tanggalSelesai = Carbon::parse($lowongan->tanggal_selesai);

            // Pastikan tahun 2024–2025
            if ($tanggalMulai->year < 2024 || $tanggalMulai->year > 2025) {
                $tanggalMulai = Carbon::createFromDate(rand(2024, 2025), rand(1, 12), rand(1, 28));
                $tanggalSelesai = (clone $tanggalMulai)->addDays(rand(30, 120));
            }

            Pendaftaran::create([
                'nama' => $nama,
                'asal_instansi' => $faker->randomElement($instansiList),
                'jurusan' => $faker->randomElement($jurusanList),
                'nim_nis' => $nimStart + $i,
                'no_telepon' => '08' . rand(1000000000, 9999999999),
                'alamat' => $faker->address,
                'status' => 'menunggu',
                'lowongan_id' => $lowongan->id,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
            ]);
        }

        $this->command->info("✅ Berhasil menambahkan {$totalRecords} data pendaftar lowongan (2024–2025)!");
    }
}
