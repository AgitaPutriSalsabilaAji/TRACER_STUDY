<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $prodi_id = null;
        $startYear = null;
        $endYear = null;
        if (empty(request()->all())) {
            $currentYear = date("Y");
            $startYear = $currentYear - 3;
            $endYear = $currentYear;
            $prodi_id = 4;
        } else {
            $startYear = request()->start_year;
            $endYear = request()->end_year;
            $prodi_id = request()->prodi_id;
        }

        $topProfesi = DB::table('lulusan as l')
            ->join('profesi as p', 'l.profesi_id', '=', 'p.id')
            ->join('alumni as a', 'l.alumni_id', '=', 'a.id')
            ->select('p.nama_profesi', DB::raw('COUNT(*) as jumlah'))
            ->whereBetween('l.tahun_lulus', [$startYear, $endYear])  // Filter berdasarkan tahun
            ->where('a.program_studi_id', $prodi_id)
            ->groupBy('p.nama_profesi')
            ->orderByDesc('jumlah')
            ->limit(9)
            ->get();

        // Hitung jumlah profesi selain top 9
        $sisaJumlah = DB::table('lulusan as l')
            ->join('profesi as p', 'l.profesi_id', '=', 'p.id')
            ->join('alumni as a', 'l.alumni_id', '=', 'a.id')
            ->select(DB::raw('COUNT(*) as jumlah'))
            ->whereBetween('l.tahun_lulus', [$startYear, $endYear])  // Filter berdasarkan tahun
            ->where('a.program_studi_id', $prodi_id)
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
            ->join('alumni as a', 'l.alumni_id', '=', 'a.id')
            ->select('ji.jenis_instansi', DB::raw('COUNT(*) as jumlah'))
            ->whereBetween('l.tahun_lulus', [$startYear, $endYear])
            ->where('a.program_studi_id', $prodi_id)
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
                )
                ->join('alumni as a', 'survei_kepuasan.alumni_id', '=', 'a.id')
                ->join('lulusan as l', 'l.alumni_id', '=', 'a.id')
                ->whereBetween('l.tahun_lulus', [$startYear, $endYear])
                ->where('a.program_studi_id', $prodi_id)
                ->first();

            $chartData[$label] = [
                ['country' => 'Sangat Baik', 'litres' => $data->sangat_baik],
                ['country' => 'Baik',        'litres' => $data->baik],
                ['country' => 'Cukup',       'litres' => $data->cukup],
                ['country' => 'Kurang',      'litres' => $data->kurang]
            ];
        }
        $prodi = ProgramStudi::all();

        return view('admin.dashboard', compact('breadcrumb', 'activeMenu', 'topProfesi', 'jenisInstansi', 'chartData', 'prodi', 'startYear', 'endYear', 'prodi_id'));
    }
    public function filter(Request $request)
    {
        $startYear = $request->input('start_year');
        $endYear = $request->input('end_year');
        $prodi = $request->input('prodi_id');
        return redirect()->route('dashboard', compact('startYear', 'endYear', 'prodi'));
    }
    public function lulusan_table(Request $request)
    {

        $prodiId = $request->input('filter_prodi');
        $startYear = $request->input('start_year');
        $endYear = $request->input('end_year');

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
                DB::raw('SUM(CASE WHEN l.skala = "Wirausaha" THEN 1 ELSE 0 END) as wirausaha')
            )
            ->whereBetween(DB::raw('YEAR(a.tanggal_lulus)'), [$startYear, $endYear])
            ->where('a.program_studi_id', $prodiId)
            ->groupBy(DB::raw('YEAR(a.tanggal_lulus)'))
            ->orderBy('tahun_lulus');

        return DataTables::of($data)->make(true);
    }
    public function masa_tunggu_table(Request $request)
    {
        $prodiId = $request->input('filter_prodi');
        $startYear = $request->input('start_year');
        $endYear = $request->input('end_year');
        $data = Alumni::select(
            DB::raw('YEAR(tanggal_lulus) as tahun_lulusan'),
            DB::raw('COUNT(alumni.id) as jumlah_lulusan'),
            DB::raw('COUNT(lulusan.id) as jumlah_terlacak'),
            DB::raw('ROUND(AVG(TIMESTAMPDIFF(DAY, alumni.tanggal_lulus, lulusan.tgl_pertama_kerja) / 30), 2) as rata_rata_waktu_tunggu_bulan')
        )
            ->leftJoin('lulusan', 'alumni.id', '=', 'lulusan.alumni_id')
            ->whereBetween(DB::raw('YEAR(alumni.tanggal_lulus)'), [$startYear, $endYear])
            ->where('alumni.program_studi_id', $prodiId)
            ->groupBy(DB::raw('YEAR(alumni.tanggal_lulus)'))
            ->orderBy('tahun_lulusan');
        return DataTables::of($data)->make(true);
    }
    public function performa_lulusan_table(Request $request)
    {
        $prodiId = $request->input('filter_prodi');
        $startYear = $request->input('start_year');
        $endYear = $request->input('end_year');

        $data = DB::table('view_rekap_kemampuan')
            ->where('program_studi_id', $prodiId )  
            ->whereBetween('tahun_lulus', [$startYear, $endYear])
            ->get();


        return DataTables::of($data)->make(true);
    }
}
