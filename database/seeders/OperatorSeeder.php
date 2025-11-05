<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OperatorSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('operators')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $operators = [
            [
                'operator_id' => 'OPR001',
                'nama_operator' => 'PT ASDP Indonesia Ferry',
                'email' => 'info@asdp.id',
                'no_telepon' => '021-5551234',
                'alamat' => 'Jl. Gajah Mada No. 14, Jakarta Pusat',
                'jumlah_kapal' => 1,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'operator_id' => 'OPR002',
                'nama_operator' => 'PT Pelayaran Dharma Lautan',
                'email' => 'cs@dharmalautan.com',
                'no_telepon' => '0721-123456',
                'alamat' => 'Jl. Raya Bakauheni, Lampung',
                'jumlah_kapal' => 2,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'operator_id' => 'OPR003',
                'nama_operator' => 'PT Pelayaran Belawan',
                'email' => 'info@pelayaranbelawan.co.id',
                'no_telepon' => '061-6611234',
                'alamat' => 'Jl. Pelabuhan Belawan, Medan',
                'jumlah_kapal' => 1,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'operator_id' => 'OPR005',
                'nama_operator' => 'PT Samudera Nusantara',
                'email' => 'contact@samudranusantara.id',
                'no_telepon' => '031-3211234',
                'alamat' => 'Jl. Perak Timur, Surabaya',
                'jumlah_kapal' => 1,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'operator_id' => 'OPR006',
                'nama_operator' => 'PT Pelayaran Sumba Line',
                'email' => 'admin@sumbaline.com',
                'no_telepon' => '0387-61234',
                'alamat' => 'Jl. Pelabuhan Waingapu, NTT',
                'jumlah_kapal' => 1,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'operator_id' => 'OPR007',
                'nama_operator' => 'PT Flores Shipping',
                'email' => 'info@floresshipping.id',
                'no_telepon' => '0385-41234',
                'alamat' => 'Jl. Soekarno Hatta, Labuan Bajo',
                'jumlah_kapal' => 1,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'operator_id' => 'OPR008',
                'nama_operator' => 'PT Kendari Marine Services',
                'email' => 'cs@kendarimarine.com',
                'no_telepon' => '0401-321123',
                'alamat' => 'Jl. Pelabuhan Kendari, Sulawesi Tenggara',
                'jumlah_kapal' => 1,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'operator_id' => 'OPR009',
                'nama_operator' => 'PT Pelayaran Maluku Line',
                'email' => 'info@maluku-line.id',
                'no_telepon' => '0911-321234',
                'alamat' => 'Jl. Yos Sudarso, Ambon',
                'jumlah_kapal' => 1,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'operator_id' => 'OPR010',
                'nama_operator' => 'PT Papua Ferry Express',
                'email' => 'contact@papuaferry.id',
                'no_telepon' => '0951-321234',
                'alamat' => 'Jl. Pelabuhan Sorong, Papua Barat',
                'jumlah_kapal' => 1,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('operators')->insert($operators);

        $this->command->info('✓ Operator data seeded successfully!');
    }
}
