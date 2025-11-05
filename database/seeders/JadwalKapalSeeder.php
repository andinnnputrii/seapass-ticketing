<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Jadwal;
use App\Models\Kapal;
use Carbon\Carbon;

class JadwalKapalSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua kapal dari database
        $kapals = Kapal::all();

        if ($kapals->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada data kapal! Silakan seed kapal terlebih dahulu.');
            return;
        }

        // Debug: Cek struktur kapal
        $firstKapal = $kapals->first();
        $kapalIdField = $firstKapal->getKeyName();

        // Hapus jadwal lama dengan cara yang aman (disable foreign key check)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('jadwal_logs')->truncate();
        DB::table('jadwals')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('🚢 Membuat jadwal untuk Oktober 2025...');

        // Data pelabuhan
        $rutes = [
            ['asal' => 'Tanjung Perak', 'tujuan' => 'Tanjung Emas'],
            ['asal' => 'Banten', 'tujuan' => 'Bakauheni'],
            ['asal' => 'Gilimanuk', 'tujuan' => 'Ketapang'],
            ['asal' => 'Surabaya', 'tujuan' => 'Makassar'],
            ['asal' => 'Padangbai', 'tujuan' => 'Lembar'],
            ['asal' => 'Jakarta', 'tujuan' => 'Surabaya'],
        ];

        // Jam keberangkatan
        $jamBerangkat = ['08:00:00', '10:00:00', '14:00:00', '16:00:00', '20:00:00'];

        // Status
        $statuses = ['On-Time', 'On-Time', 'On-Time', 'Delay', 'Cancelled'];

        $keteranganByStatus = [
            'On-Time' => ['Kapal Siap', 'Operasional Normal', 'Siap Berangkat'],
            'Delay' => ['Cuaca buruk', 'Antrian panjang', 'Gangguan Teknis'],
            'Cancelled' => ['Maintenance kapal', 'Cuaca ekstrem', 'Masalah teknis'],
        ];

        // Generate hanya 18 jadwal untuk 2 halaman (10 + 8)
        $startDate = Carbon::create(2025, 10, 1);
        $totalJadwal = 18;

        $jadwalCount = 0;
        $jadwalId = 1;

        // Buat jadwal tersebar di bulan Oktober
        $tanggalList = [1, 3, 5, 7, 9, 12, 15, 18, 21, 24, 26, 28, 30]; // Tanggal acak di Oktober

        for ($i = 0; $i < $totalJadwal; $i++) {
            $date = $startDate->copy()->day($tanggalList[array_rand($tanggalList)]);

            $kapal = $kapals->random();
            $kapalId = $kapal->{$kapalIdField} ?? $kapal->id ?? null;

            if (!$kapalId) {
                continue;
            }

            $rute = $rutes[array_rand($rutes)];
            $jam = $jamBerangkat[array_rand($jamBerangkat)];
            $status = $statuses[array_rand($statuses)];

            // Generate ID Jadwal
            $idJadwal = 'J' . str_pad($jadwalId, 3, '0', STR_PAD_LEFT);

            // Estimasi kedatangan
            $jamBerangkatCarbon = Carbon::parse($jam);
            $estimasiKedatangan = $jamBerangkatCarbon->copy()->addHours(rand(4, 12))->format('H:i:s');

            // Keterangan berdasarkan status
            $keterangan = $keteranganByStatus[$status][array_rand($keteranganByStatus[$status])];

            // Keterangan khusus untuk hari libur
            if ($date->format('m-d') == '10-05') {
                $keterangan = 'Idul Adha 1446 H - Jadwal Terbatas';
            } elseif ($date->format('m-d') == '10-26') {
                $keterangan = 'Tahun Baru Islam 1447 H - Operasional Normal';
            }

            DB::table('jadwals')->insert([
                'id' => $jadwalId,
                'id_jadwal' => $idJadwal,
                'kapal_id' => $kapalId,
                'pelabuhan_asal' => $rute['asal'],
                'pelabuhan_tujuan' => $rute['tujuan'],
                'tanggal_keberangkatan' => $date->format('Y-m-d'),
                'jam_berangkat' => $jam,
                'estimasi_kedatangan' => $estimasiKedatangan,
                'status' => $status,
                'keterangan' => $keterangan,
                'created_at' => $date->copy()->subDays(rand(1, 5)),
                'updated_at' => Carbon::now(),
            ]);

            $jadwalCount++;
            $jadwalId++;
        }

        $this->command->info("✅ Berhasil membuat {$jadwalCount} jadwal untuk Oktober 2025!");

        // Sekarang buat logs (hanya untuk 15 jadwal pertama)
        $this->createLogs();
    }

    private function createLogs()
    {
        $this->command->info('📝 Membuat log perubahan jadwal...');

        $jadwals = Jadwal::with('kapal')->get();

        if ($jadwals->isEmpty()) {
            return;
        }

        $users = ['Admin', 'Brodie', 'Operator001', 'System'];

        $perubahanExamples = [
            'Status: On-Time → Delay',
            'Jam Berangkat: 08:00 → 09:00',
            'Status: Delay → Cancelled',
            'Estimasi Kedatangan: 12:00 → 13:30',
            'Pelabuhan diubah',
        ];

        $alasanExamples = [
            'Cuaca buruk',
            'Keterlambatan dari pelabuhan sebelumnya',
            'Permintaan operator',
            'Masalah teknis',
        ];

        $logCount = 0;

        // Buat log hanya untuk 15 jadwal (untuk 2 halaman: 10 + 5)
        foreach ($jadwals->take(15) as $jadwal) {
            // Pastikan kapal ada
            if (!$jadwal->kapal) {
                continue;
            }

            // Log created
            DB::table('jadwal_logs')->insert([
                'jadwal_id' => $jadwal->id,
                'id_jadwal' => $jadwal->id_jadwal,
                'kapal_id' => $jadwal->kapal_id,
                'nama_kapal' => $jadwal->kapal->nama_kapal ?? 'Unknown',
                'perubahan' => 'Jadwal baru dibuat',
                'diubah_oleh' => $users[array_rand($users)],
                'alasan_perubahan' => null,
                'jenis_perubahan' => 'created',
                'created_at' => $jadwal->created_at,
                'updated_at' => $jadwal->created_at,
            ]);
            $logCount++;

            // 50% chance ada 1 update
            if (rand(0, 1)) {
                DB::table('jadwal_logs')->insert([
                    'jadwal_id' => $jadwal->id,
                    'id_jadwal' => $jadwal->id_jadwal,
                    'kapal_id' => $jadwal->kapal_id,
                    'nama_kapal' => $jadwal->kapal->nama_kapal ?? 'Unknown',
                    'perubahan' => $perubahanExamples[array_rand($perubahanExamples)],
                    'diubah_oleh' => $users[array_rand($users)],
                    'alasan_perubahan' => $alasanExamples[array_rand($alasanExamples)],
                    'jenis_perubahan' => rand(0, 1) ? 'updated' : 'status_changed',
                    'created_at' => Carbon::parse($jadwal->created_at)->addMinutes(rand(60, 300)),
                    'updated_at' => Carbon::now(),
                ]);
                $logCount++;
            }
        }

        $this->command->info("✅ Berhasil membuat {$logCount} log perubahan!");
    }
}
