<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lowongan;
use Carbon\Carbon;
use Faker\Factory as Faker;

class LowonganSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Daftar judul lowongan relevan untuk Radar Kediri
        $judulList = [
            'Magang Multimedia - Divisi Konten',
            'Magang Jurnalistik - Divisi Berita',
            'Magang Desain Grafis - Divisi Kreatif',
            'Magang IT - Divisi Pengembangan Web',
            'Magang Social Media - Divisi Pemasaran',
            'Magang Produksi Video - Divisi Video',
            'Magang Administrasi - Divisi Operasional',
            'Magang Data - Divisi Analitik',
            'Magang UI/UX - Divisi Produk',
            'Magang Support Teknis - Divisi IT Support'
        ];

        // Buat 10 lowongan utama (tanggal acak antara 2024–2025)
        foreach ($judulList as $index => $judul) {
            $mulai = $faker->dateTimeBetween('2024-01-01', '2025-12-01');
            $selesai = (clone $mulai)->modify('+' . rand(30, 120) . ' days');

            Lowongan::updateOrCreate(
                ['judul' => $judul],
                [
                    'judul' => $judul,
                    'deskripsi' => $faker->paragraph(2),
                    'tanggal_mulai' => Carbon::instance($mulai)->format('Y-m-d'),
                    'tanggal_selesai' => Carbon::instance($selesai)->format('Y-m-d'),
                    'kuota' => rand(3, 15),
                    // ambil id divisi acak dari 1 sampai 5 (ubah jika divisi kamu lebih banyak)
                    'divisi_id' => rand(1, 5),
                ]
            );
        }

        // Tambahkan beberapa lowongan acak tambahan
        for ($i = 0; $i < 5; $i++) {
            $mulai = $faker->dateTimeBetween('2024-01-01', '2025-12-01');
            $selesai = (clone $mulai)->modify('+' . rand(30, 120) . ' days');

            Lowongan::create([
                'judul' => $faker->sentence(3),
                'deskripsi' => $faker->paragraph(2),
                'tanggal_mulai' => Carbon::instance($mulai)->format('Y-m-d'),
                'tanggal_selesai' => Carbon::instance($selesai)->format('Y-m-d'),
                'kuota' => rand(3, 12),
                'divisi_id' => rand(1, 5),
            ]);
        }
    }
}
