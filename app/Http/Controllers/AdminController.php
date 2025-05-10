<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index(Request $request)
    {

        $breadcrumb = (object)[
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];
        $activeMenu = 'dashboard';
        $topProfesi = DB::table('lulusan as l')
            ->join('profesi as p', 'l.profesi_id', '=', 'p.id')
            ->select('p.nama_profesi', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('p.nama_profesi')
            ->orderByDesc('jumlah')
            ->limit(9)
            ->get();

        // Hitung jumlah profesi selain top 9
        $sisaJumlah = DB::table('lulusan as l')
            ->join('profesi as p', 'l.profesi_id', '=', 'p.id')
            ->select(DB::raw('COUNT(*) as jumlah'))
            ->whereNotIn('p.nama_profesi', $topProfesi->pluck('nama_profesi'))
            ->value('jumlah');

        // Gabungkan "Lainnya" jika ada
        if ($sisaJumlah > 0) {
            $topProfesi->push((object)[
                'nama_profesi' => 'Lainnya',
                'jumlah' => $sisaJumlah
            ]);
        }

        $jenisInstansi = DB::table('lulusan as l')
            ->join('jenis_instansi as ji', 'l.jenis_instansi_id', '=', 'ji.id')
            ->select('ji.jenis_instansi', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('ji.jenis_instansi')
            ->get();

            $chartData = [];

            $fields = [
                'kerjasama_tim' => 'Kerjasama Tim',
                'keahlian_di_bidang_ti' => 'Keahlian di Bidang TI',
                'kemampuan_bahasa_asing' => 'Kemampuan Bahasa Asing',
                'kemampuan_komunikasi' => 'Kemampuan Komunikasi',
                'pengembangan_diri' => 'Pengembangan Diri',
                'kepemimpinan' => 'Kepemimpinan',
                'etos_kerja' => 'Etos Kerja'
            ];
        
            foreach ($fields as $field => $label) {
                $data = DB::table('survei_kepuasan')
                    ->select(
                        DB::raw("COUNT(CASE WHEN $field = 4 THEN 1 END) AS sangat_baik"),
                        DB::raw("COUNT(CASE WHEN $field = 3 THEN 1 END) AS baik"),
                        DB::raw("COUNT(CASE WHEN $field = 2 THEN 1 END) AS cukup"),
                        DB::raw("COUNT(CASE WHEN $field = 1 THEN 1 END) AS kurang")
                    )->first();
        
                $chartData[$label] = [
                    ['country' => 'Sangat Baik', 'litres' => $data->sangat_baik],
                    ['country' => 'Baik',        'litres' => $data->baik],
                    ['country' => 'Cukup',       'litres' => $data->cukup],
                    ['country' => 'Kurang',      'litres' => $data->kurang]
                ];
            }
        return view('admin.dashboard', compact('breadcrumb', 'activeMenu', 'topProfesi', 'jenisInstansi', 'chartData'));
    }

    public function lulusan_table(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('alumni as a')
                ->leftJoin('lulusan as l', 'a.id', '=', 'l.alumni_id')
                ->leftJoin('profesi as p', 'l.profesi_id', '=', 'p.id')
                ->leftJoin('kategori_profesi as kp', 'p.kategori_profesi_id', '=', 'kp.id')
                ->select(
                    DB::raw('YEAR(a.tanggal_lulus) as tahun_lulus'),
                    DB::raw('COUNT(a.nim) as total_lulusan'),
                    DB::raw('COUNT(l.id) as lulusan_terlacak'),
                    DB::raw('SUM(CASE WHEN kp.kategori_profesi = "Infokom" THEN 1 ELSE 0 END) as kerja_bidang_infokom'),
                    DB::raw('SUM(CASE WHEN kp.kategori_profesi = "non-Infokom" THEN 1 ELSE 0 END) as kerja_bidang_non_infokom'),
                    DB::raw('SUM(CASE WHEN l.skala = "Internasional" THEN 1 ELSE 0 END) as internasional'),
                    DB::raw('SUM(CASE WHEN l.skala = "Nasional" THEN 1 ELSE 0 END) as nasional'),
                    DB::raw('SUM(CASE WHEN l.skala = "Regional" THEN 1 ELSE 0 END) as regional')
                )
                ->whereBetween(DB::raw('YEAR(a.tanggal_lulus)'), [2025, 2030])
                ->groupBy(DB::raw('YEAR(a.tanggal_lulus)'))
                ->orderBy('tahun_lulus');

            return DataTables::of($data)->make(true);
        }
    }
    public function masa_tunggu_table(Request $request)
    {
        if ($request->ajax()) {
            $data = Alumni::select(
                DB::raw('YEAR(tanggal_lulus) as tahun_lulusan'),
                DB::raw('COUNT(alumni.id) as jumlah_lulusan'),
                DB::raw('COUNT(lulusan.id) as jumlah_terlacak'),
                DB::raw('ROUND(AVG(TIMESTAMPDIFF(DAY, alumni.tanggal_lulus, lulusan.tgl_pertama_kerja) / 30), 2) as rata_rata_waktu_tunggu_bulan')
            )
                ->leftJoin('lulusan', 'alumni.id', '=', 'lulusan.alumni_id')
                ->groupBy(DB::raw('YEAR(alumni.tanggal_lulus)'))
                ->orderBy('tahun_lulusan');
            return DataTables::of($data)->make(true);
        }
    }
    public function performa_lulusan_table(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::select("SELECT 
                'Kerjasama Tim' AS jenis_kemampuan,
                ROUND((COUNT(CASE WHEN kerjasama_tim = 4 THEN 1 END) * 100.0) / COUNT(*), 2) AS sangat_baik,
                ROUND((COUNT(CASE WHEN kerjasama_tim = 3 THEN 1 END) * 100.0) / COUNT(*), 2) AS baik,
                ROUND((COUNT(CASE WHEN kerjasama_tim = 2 THEN 1 END) * 100.0) / COUNT(*), 2) AS cukup,
                ROUND((COUNT(CASE WHEN kerjasama_tim = 1 THEN 1 END) * 100.0) / COUNT(*), 2) AS kurang
            FROM survei_kepuasan
            UNION
            SELECT 
                'Keahlian di Bidang TI' AS jenis_kemampuan,
                ROUND((COUNT(CASE WHEN keahlian_di_bidang_ti = 4 THEN 1 END) * 100.0) / COUNT(*), 2) AS sangat_baik,
                ROUND((COUNT(CASE WHEN keahlian_di_bidang_ti = 3 THEN 1 END) * 100.0) / COUNT(*), 2) AS baik,
                ROUND((COUNT(CASE WHEN keahlian_di_bidang_ti = 2 THEN 1 END) * 100.0) / COUNT(*), 2) AS cukup,
                ROUND((COUNT(CASE WHEN keahlian_di_bidang_ti = 1 THEN 1 END) * 100.0) / COUNT(*), 2) AS kurang
            FROM survei_kepuasan
            UNION
            SELECT 
                'Kemampuan Bahasa Asing' AS jenis_kemampuan,
                ROUND((COUNT(CASE WHEN kemampuan_bahasa_asing = 4 THEN 1 END) * 100.0) / COUNT(*), 2) AS sangat_baik,
                ROUND((COUNT(CASE WHEN kemampuan_bahasa_asing = 3 THEN 1 END) * 100.0) / COUNT(*), 2) AS baik,
                ROUND((COUNT(CASE WHEN kemampuan_bahasa_asing = 2 THEN 1 END) * 100.0) / COUNT(*), 2) AS cukup,
                ROUND((COUNT(CASE WHEN kemampuan_bahasa_asing = 1 THEN 1 END) * 100.0) / COUNT(*), 2) AS kurang
            FROM survei_kepuasan
            UNION
            SELECT 
                'Kemampuan Komunikasi' AS jenis_kemampuan,
                ROUND((COUNT(CASE WHEN kemampuan_komunikasi = 4 THEN 1 END) * 100.0) / COUNT(*), 2) AS sangat_baik,
                ROUND((COUNT(CASE WHEN kemampuan_komunikasi = 3 THEN 1 END) * 100.0) / COUNT(*), 2) AS baik,
                ROUND((COUNT(CASE WHEN kemampuan_komunikasi = 2 THEN 1 END) * 100.0) / COUNT(*), 2) AS cukup,
                ROUND((COUNT(CASE WHEN kemampuan_komunikasi = 1 THEN 1 END) * 100.0) / COUNT(*), 2) AS kurang
            FROM survei_kepuasan
            UNION
            SELECT 
                'Pengembangan Diri' AS jenis_kemampuan,
                ROUND((COUNT(CASE WHEN pengembangan_diri = 4 THEN 1 END) * 100.0) / COUNT(*), 2) AS sangat_baik,
                ROUND((COUNT(CASE WHEN pengembangan_diri = 3 THEN 1 END) * 100.0) / COUNT(*), 2) AS baik,
                ROUND((COUNT(CASE WHEN pengembangan_diri = 2 THEN 1 END) * 100.0) / COUNT(*), 2) AS cukup,
                ROUND((COUNT(CASE WHEN pengembangan_diri = 1 THEN 1 END) * 100.0) / COUNT(*), 2) AS kurang
            FROM survei_kepuasan
            UNION
            SELECT 
                'Kepemimpinan' AS jenis_kemampuan,
                ROUND((COUNT(CASE WHEN kepemimpinan = 4 THEN 1 END) * 100.0) / COUNT(*), 2) AS sangat_baik,
                ROUND((COUNT(CASE WHEN kepemimpinan = 3 THEN 1 END) * 100.0) / COUNT(*), 2) AS baik,
                ROUND((COUNT(CASE WHEN kepemimpinan = 2 THEN 1 END) * 100.0) / COUNT(*), 2) AS cukup,
                ROUND((COUNT(CASE WHEN kepemimpinan = 1 THEN 1 END) * 100.0) / COUNT(*), 2) AS kurang
            FROM survei_kepuasan
            UNION
            SELECT 
                'Etos Kerja' AS jenis_kemampuan,
                ROUND((COUNT(CASE WHEN etos_kerja = 4 THEN 1 END) * 100.0) / COUNT(*), 2) AS sangat_baik,
                ROUND((COUNT(CASE WHEN etos_kerja = 3 THEN 1 END) * 100.0) / COUNT(*), 2) AS baik,
                ROUND((COUNT(CASE WHEN etos_kerja = 2 THEN 1 END) * 100.0) / COUNT(*), 2) AS cukup,
                ROUND((COUNT(CASE WHEN etos_kerja = 1 THEN 1 END) * 100.0) / COUNT(*), 2) AS kurang
            FROM survei_kepuasan;
            ");
            return DataTables::of($data)->make(true);
        }
    }
}
