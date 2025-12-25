<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penumpang;
use Illuminate\Support\Facades\DB;

class PenumpangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data dummy penumpang
        $penumpangs = [
            [
                'penumpang_id' => 'P001',
                'nama_lengkap' => 'Bambang Wicaksono',
                'nik' => '3571010101950001',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1995-01-01',
                'no_telepon' => '081234567890',
                'email' => 'bambang.wicaksono@email.com',
                'alamat' => 'Jl. Raya Surabaya No. 123, Surabaya',
            ],
            [
                'penumpang_id' => 'P002',
                'nama_lengkap' => 'Rina Kartika',
                'nik' => '3571030201890001',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1989-02-01',
                'no_telepon' => '081234567891',
                'email' => 'rina.kartika@email.com',
                'alamat' => 'Jl. Pemuda No. 45, Surabaya',
            ],
            [
                'penumpang_id' => 'P003',
                'nama_lengkap' => 'Andi Saputra',
                'nik' => '3571030901980001',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1998-09-01',
                'no_telepon' => '081234567892',
                'email' => 'andi.saputra@email.com',
                'alamat' => 'Jl. Diponegoro No. 78, Surabaya',
            ],
            [
                'penumpang_id' => 'P004',
                'nama_lengkap' => 'Siti Aisyah',
                'nik' => '3571030401800001',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1980-04-01',
                'no_telepon' => '081234567893',
                'email' => 'siti.aisyah@email.com',
                'alamat' => 'Jl. Basuki Rahmat No. 12, Surabaya',
            ],
            [
                'penumpang_id' => 'P005',
                'nama_lengkap' => 'Doni Prasetyo',
                'nik' => '3571030501940001',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1994-05-01',
                'no_telepon' => '081234567894',
                'email' => 'doni.prasetyo@email.com',
                'alamat' => 'Jl. Tunjungan No. 89, Surabaya',
            ],
            [
                'penumpang_id' => 'P006',
                'nama_lengkap' => 'Nia Rahmawati',
                'nik' => '3571030601920001',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1992-06-01',
                'no_telepon' => '081234567895',
                'email' => 'nia.rahmawati@email.com',
                'alamat' => 'Jl. Ahmad Yani No. 34, Surabaya',
            ],
            [
                'penumpang_id' => 'P007',
                'nama_lengkap' => 'Ahmad Fathurrahman',
                'nik' => '3571030701960001',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1996-07-01',
                'no_telepon' => '081234567896',
                'email' => 'ahmad.fathur@email.com',
                'alamat' => 'Jl. Pahlawan No. 56, Surabaya',
            ],
            [
                'penumpang_id' => 'P008',
                'nama_lengkap' => 'Lisa Marlina',
                'nik' => '3571030801970001',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1997-08-01',
                'no_telepon' => '081234567897',
                'email' => 'lisa.marlina@email.com',
                'alamat' => 'Jl. Veteran No. 23, Surabaya',
            ],
            [
                'penumpang_id' => 'P009',
                'nama_lengkap' => 'Eko Sutrisno',
                'nik' => '3571030901990001',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1999-09-01',
                'no_telepon' => '081234567898',
                'email' => 'eko.sutrisno@email.com',
                'alamat' => 'Jl. Mayjen Sungkono No. 67, Surabaya',
            ],
            [
                'penumpang_id' => 'P010',
                'nama_lengkap' => 'Dewi Anggraini',
                'nik' => '3571031801750001',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1975-01-18',
                'no_telepon' => '081234567899',
                'email' => 'dewi.anggraini@email.com',
                'alamat' => 'Jl. Kertajaya No. 90, Surabaya',
            ],
            [
                'penumpang_id' => 'P011',
                'nama_lengkap' => 'Budi Santoso',
                'nik' => '3571021501880001',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1988-02-15',
                'no_telepon' => '081234567800',
                'email' => 'budi.santoso@email.com',
                'alamat' => 'Jl. Ngagel No. 15, Surabaya',
            ],
            [
                'penumpang_id' => 'P012',
                'nama_lengkap' => 'Fitri Handayani',
                'nik' => '3571032201910001',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1991-03-22',
                'no_telepon' => '081234567801',
                'email' => 'fitri.handayani@email.com',
                'alamat' => 'Jl. Rungkut No. 28, Surabaya',
            ],
            [
                'penumpang_id' => 'P013',
                'nama_lengkap' => 'Agus Setiawan',
                'nik' => '3571041001870001',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1987-04-10',
                'no_telepon' => '081234567802',
                'email' => 'agus.setiawan@email.com',
                'alamat' => 'Jl. Gubeng No. 41, Surabaya',
            ],
            [
                'penumpang_id' => 'P014',
                'nama_lengkap' => 'Sri Wahyuni',
                'nik' => '3571050501930001',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1993-05-05',
                'no_telepon' => '081234567803',
                'email' => 'sri.wahyuni@email.com',
                'alamat' => 'Jl. Darmo No. 52, Surabaya',
            ],
            [
                'penumpang_id' => 'P015',
                'nama_lengkap' => 'Hendra Wijaya',
                'nik' => '3571061201900001',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1990-06-12',
                'no_telepon' => '081234567804',
                'email' => 'hendra.wijaya@email.com',
                'alamat' => 'Jl. Mayjend Sungkono No. 19, Surabaya',
            ],
        ];

        // Insert data menggunakan DB transaction untuk performa
        DB::transaction(function () use ($penumpangs) {
            foreach ($penumpangs as $penumpang) {
                Penumpang::create($penumpang);
            }
        });

        $this->command->info('✅ Berhasil menambahkan ' . count($penumpangs) . ' data penumpang!');
    }
}
