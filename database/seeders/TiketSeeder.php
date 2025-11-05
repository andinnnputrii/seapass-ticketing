<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Penumpang;
use App\Models\Tiket;
use App\Models\Kendaraan;
use App\Models\ValidasiTiket;
use App\Models\Jadwal;
use Carbon\Carbon;

class TiketSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah ada jadwal
        $jadwals = Jadwal::with('kapal')->get();

        if ($jadwals->count() == 0) {
            $this->command->warn('⚠️ Tidak ada data jadwal. Jalankan JadwalKapalSeeder terlebih dahulu.');
            return;
        }

        // Hapus data lama dengan aman
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('validasi_tikets')->truncate();
        DB::table('kendaraans')->truncate();
        DB::table('tikets')->truncate();
        DB::table('penumpangs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('🎫 Membuat data Penumpang, Tiket, Kendaraan & Validasi...');

        // Data
        $namaPenumpang = [
            'Ahmad Rizki Maulana', 'Siti Nurhaliza Putri', 'Budi Santoso Wijaya',
            'Dewi Lestari Kusuma', 'Eko Prasetyo Saputra', 'Fitri Handayani Wati',
            'Gunawan Wibowo Permana', 'Hana Pertiwi Lestari', 'Indra Kusuma Setiawan',
            'Joko Widodo Santoso', 'Kartika Sari Andini', 'Lukman Hakim Pratama',
            'Maya Sari Wijaya', 'Nurul Hidayah', 'Oki Setiana Dewi', 'Putra Mahardika'
        ];

        $metodeBayar = ['QRIS', 'Tunai', 'Bank', 'E-Wallet'];
        $tipeTiket = ['Penumpang', 'Penumpang', 'Penumpang', 'Kendaraan'];
        $kelasTiket = ['Ekonomi', 'Ekonomi', 'Bisnis', 'VIP'];
        $statusTiket = ['Valid', 'Valid', 'Valid', 'Tervalidasi', 'Batal', 'Reschedule'];
        $statusPembayaran = ['Paid', 'Paid', 'Paid', 'Pending'];

        // Jenis kendaraan
        $jenisKendaraan = [
            'Truk Kontainer',
            'Truk Engkel',
            'Bus',
            'Pickup',
            'Minibus'
        ];

        $totalTiket = 30;
        $berhasil = 0;

        for ($i = 1; $i <= $totalTiket; $i++) {
            try {
                // Pilih jadwal random
                $jadwal = $jadwals->random();

                if (!$jadwal->kapal_id) {
                    $this->command->warn("Jadwal ID {$jadwal->id} tidak punya kapal_id, skip...");
                    continue;
                }

                // Buat penumpang
                $penumpangId = 'USR' . str_pad($i, 3, '0', STR_PAD_LEFT);
                $nama = $namaPenumpang[array_rand($namaPenumpang)];
                $jk = rand(0, 1) ? 'Laki-laki' : 'Perempuan';

                $penumpang = Penumpang::create([
                    'penumpang_id' => $penumpangId,
                    'nama_lengkap' => $nama,
                    'nik' => '3578' . str_pad(rand(1, 999999999999), 12, '0', STR_PAD_LEFT),
                    'jenis_kelamin' => $jk,
                    'no_telepon' => '08' . rand(100000000, 999999999),
                    'email' => 'user' . $i . '@example.com',
                    'created_at' => Carbon::now()->subDays(rand(0, 30)),
                    'updated_at' => Carbon::now()
                ]);

                // Buat tiket
                $tipe = $tipeTiket[array_rand($tipeTiket)];
                $kelas = $kelasTiket[array_rand($kelasTiket)];
                $status = $statusTiket[array_rand($statusTiket)];
                $statusBayar = $statusPembayaran[array_rand($statusPembayaran)];

                // Hitung harga
                $harga = match($kelas) {
                    'Ekonomi' => rand(50000, 100000),
                    'Bisnis' => rand(150000, 250000),
                    'VIP' => rand(300000, 500000),
                };

                if ($tipe == 'Kendaraan') {
                    $harga += 200000;
                }

                $pajak = $harga * 0.1;
                $totalBayar = $harga + $pajak;

                // Data tambahan
                $nomorKursi = $tipe == 'Penumpang' ? chr(65 + rand(0, 10)) . rand(1, 50) : null;

                // Waktu
                $waktuPemesanan = Carbon::now()->subDays(rand(1, 30));
                $waktuPembayaran = $statusBayar == 'Paid'
                    ? $waktuPemesanan->copy()->addMinutes(rand(5, 120))
                    : null;
                $waktuValidasi = in_array($status, ['Tervalidasi', 'Batal']) && $waktuPembayaran
                    ? $waktuPembayaran->copy()->addHours(rand(1, 48))
                    : null;

                $tiketId = 'TKT' . str_pad($i, 3, '0', STR_PAD_LEFT);

                $tiket = Tiket::create([
                    'tiket_id' => $tiketId,
                    'penumpang_id' => $penumpang->penumpang_id,
                    'jadwal_id' => $jadwal->id,
                    'kapal_id' => $jadwal->kapal_id,
                    'tipe_tiket' => $tipe,
                    'kelas_tiket' => $kelas,
                    'harga' => $harga,
                    'pajak' => $pajak,
                    'total_bayar' => $totalBayar,
                    'metode_bayar' => $metodeBayar[array_rand($metodeBayar)],
                    'status_pembayaran' => $statusBayar,
                    'status_tiket' => $status,
                    'kode_booking' => 'BK' . strtoupper(substr(md5(time() . $i), 0, 8)),
                    'nomor_kursi' => $nomorKursi,
                    'waktu_pemesanan' => $waktuPemesanan,
                    'waktu_pembayaran' => $waktuPembayaran,
                    'waktu_validasi' => $waktuValidasi,
                    'validasi_oleh' => $waktuValidasi ? (['Brodie', 'petugas01', 'petugas02', 'petugas03', 'petugas04'][array_rand(['Brodie', 'petugas01', 'petugas02', 'petugas03', 'petugas04'])]) : null,
                    'created_at' => $waktuPemesanan,
                    'updated_at' => Carbon::now()
                ]);

                // BUAT DATA KENDARAAN jika tipe kendaraan
                if ($tipe == 'Kendaraan') {
                    $huruf1 = chr(rand(65, 90)); // A-Z
                    $angka = rand(1000, 9999);
                    $huruf2 = chr(rand(65, 90)) . chr(rand(65, 90));
                    $platNomor = "$huruf1 $angka $huruf2";

                    $jenis = $jenisKendaraan[array_rand($jenisKendaraan)];

                    // Panjang dan muatan berdasarkan jenis
                    [$panjang, $muatan] = match($jenis) {
                        'Truk Kontainer' => [12.0, rand(10000, 15000)],
                        'Truk Engkel' => [6.5, rand(3000, 5000)],
                        'Bus' => [8.0, rand(6000, 8000)],
                        'Pickup' => [5.0, rand(1000, 2000)],
                        'Minibus' => [6.0, rand(2000, 3000)],
                    };

                    Kendaraan::create([
                        'kendaraan_id' => 'KND' . str_pad($i, 3, '0', STR_PAD_LEFT),
                        'tiket_id' => $tiketId,
                        'plat_nomor' => $platNomor,
                        'jenis_kendaraan' => $jenis,
                        'panjang' => $panjang,
                        'muatan' => $muatan,
                        'created_at' => $waktuPemesanan,
                        'updated_at' => Carbon::now()
                    ]);
                }

                // BUAT DATA VALIDASI jika sudah tervalidasi
                if ($status == 'Tervalidasi' && $waktuValidasi) {
                    $gates = ['Gate A1', 'Gate A2', 'Gate B1', 'Gate B2'];
                    $petugas = ['Brodie', 'petugas01', 'petugas02', 'petugas03', 'petugas04'];
                    $metode = ['QR', 'QR', 'QR', 'Manual']; // Lebih banyak QR

                    ValidasiTiket::create([
                        'tiket_id' => $tiketId,
                        'waktu_validasi' => $waktuValidasi,
                        'status_validasi' => 'valid',
                        'metode' => $metode[array_rand($metode)],
                        'lokasi_pintu' => $gates[array_rand($gates)],
                        'petugas' => $petugas[array_rand($petugas)],
                        'catatan' => null,
                        'created_at' => $waktuValidasi,
                        'updated_at' => Carbon::now()
                    ]);
                } elseif ($status == 'Batal' && $waktuValidasi) {
                    // Validasi gagal
                    $gates = ['Gate A1', 'Gate A2', 'Gate B1', 'Gate B2'];
                    $petugas = ['Brodie', 'petugas01', 'petugas02', 'petugas03', 'petugas04'];
                    $catatan = ['Sudah digunakan', 'QR tidak terbaca', 'Data tidak valid', 'Tiket expired'];

                    ValidasiTiket::create([
                        'tiket_id' => $tiketId,
                        'waktu_validasi' => $waktuValidasi,
                        'status_validasi' => 'invalid',
                        'metode' => 'QR',
                        'lokasi_pintu' => $gates[array_rand($gates)],
                        'petugas' => $petugas[array_rand($petugas)],
                        'catatan' => $catatan[array_rand($catatan)],
                        'created_at' => $waktuValidasi,
                        'updated_at' => Carbon::now()
                    ]);
                }

                $berhasil++;

            } catch (\Exception $e) {
                $this->command->error("Error pada tiket #{$i}: " . $e->getMessage());
                continue;
            }
        }

        $this->command->info("✅ Berhasil membuat {$berhasil} data lengkap!");

        // Tampilkan statistik
        $totalPenumpang = Penumpang::count();
        $totalTiket = Tiket::count();
        $totalKendaraan = Kendaraan::count();
        $totalValidasi = ValidasiTiket::count();

        $this->command->info("\n📊 Statistik:");
        $this->command->info("   👥 Penumpang: {$totalPenumpang}");
        $this->command->info("   🎫 Tiket: {$totalTiket}");
        $this->command->info("   🚚 Kendaraan: {$totalKendaraan}");
        $this->command->info("   ✅ Validasi: {$totalValidasi}");

        $valid = Tiket::where('status_tiket', 'Valid')->count();
        $tervalidasi = Tiket::where('status_tiket', 'Tervalidasi')->count();
        $batal = Tiket::where('status_tiket', 'Batal')->count();

        $this->command->info("\n📈 Status Tiket:");
        $this->command->info("   ✓ Valid: {$valid}");
        $this->command->info("   ✓ Tervalidasi: {$tervalidasi}");
        $this->command->info("   ✗ Batal: {$batal}");
    }
}
