<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Hash;

class PendaftaranSeeder extends Seeder
{
    public function run(): void
    {
        $dataindent = [
            [
                'name' => 'Rizky Maulana',
                'email' => 'rizky@example.com',
                'asal_instansi' => 'Universitas Brawijaya',
                'jurusan' => 'Teknik Informatika',
                'nim_nis' => '214210001',
                'no_telepon' => '081234567890',
                'alamat' => 'Jl. Anggrek No. 12, Kediri',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'asal_instansi' => 'Universitas Negeri Malang',
                'jurusan' => 'Manajemen Informatika',
                'nim_nis' => '224210045',
                'no_telepon' => '081278945612',
                'alamat' => 'Jl. Melati No. 3, Pare',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Ahmad Fauzan',
                'email' => 'ahmad@example.com',
                'asal_instansi' => 'SMK Telkom Malang',
                'jurusan' => 'Teknik Komputer dan Jaringan',
                'nim_nis' => '11223344',
                'no_telepon' => '082133445566',
                'alamat' => 'Jl. Diponegoro No. 9, Malang',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Siti Rahmawati',
                'email' => 'siti@example.com',
                'asal_instansi' => 'Universitas Islam Kadiri',
                'jurusan' => 'Sistem Informasi',
                'nim_nis' => '214210078',
                'no_telepon' => '085732190876',
                'alamat' => 'Jl. Mawar No. 7, Kediri',
                'status' => 'menunggu',
            ],
            [
                'name' => 'Bayu Pratama',
                'email' => 'bayu@example.com',
                'asal_instansi' => 'Politeknik Negeri Malang',
                'jurusan' => 'Teknik Multimedia dan Jaringan',
                'nim_nis' => '214210099',
                'no_telepon' => '081223456789',
                'alamat' => 'Jl. Kenanga No. 10, Kediri',
                'status' => 'menunggu',
            ],
        ];

        foreach ($dataindent as $data) {
            // 🔹 Buat akun user
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'jenjang' => str_contains($data['asal_instansi'], 'SMK') ? 'Siswa' : 'Mahasiswa',
                    'role' => 'user',
                ]
            );

            // 🔹 Buat data pendaftaran terhubung dengan user
            Pendaftaran::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama' => $data['name'],
                    'asal_instansi' => $data['asal_instansi'],
                    'jurusan' => $data['jurusan'],
                    'nim_nis' => $data['nim_nis'],
                    'no_telepon' => $data['no_telepon'],
                    'alamat' => $data['alamat'],
                    'status' => $data['status'],
                ]
            );
        }
    }
}
