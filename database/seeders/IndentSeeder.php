<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Indent;
use App\Models\User;

class IndentSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user dulu (karena ada relasi user_id)
        $user = User::firstOrCreate(
            ['email' => 'mahasiswa@example.com'],
            [
                'name' => 'Rizky Mahasiswa',
                'password' => bcrypt('password123'),
            ]
        );

        // Tambahkan data indent contoh
        Indent::create([
            'user_id' => $user->id,
            'nama' => 'Budi Santoso',
            'asal_instansi' => 'Universitas Nusantara PGRI Kediri',
            'jurusan' => 'Manajemen Informatika',
            'nim_nis' => '2309482323',
            'no_telepon' => '085123456789',
            'alamat' => 'Jl. Hasanudin No. 15 Kediri',
            'tanggal_mulai' => now()->addDays(7),
            'tanggal_selesai' => now()->addMonths(3),
            'status' => 'menunggu', // bisa juga 'diterima' atau 'ditolak'
        ]);

        Indent::create([
            'user_id' => $user->id,
            'nama' => 'Siti Rahmawati',
            'asal_instansi' => 'Politeknik Negeri Malang',
            'jurusan' => 'Teknik Komputer',
            'nim_nis' => '2309400001',
            'no_telepon' => '085678912345',
            'alamat' => 'Jl. Diponegoro No. 9 Kediri',
            'tanggal_mulai' => now()->addDays(14),
            'tanggal_selesai' => now()->addMonths(4),
            'status' => 'menunggu',
        ]);
    }
}
