<?php

namespace App\Http\Controllers;

use App\Exports\LaporanBelumSurvei;
use App\Exports\LaporanBelumTS;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanSurveiExport;
use App\Exports\LaporanSurveiKepuasan;
use Illuminate\Support\Facades\DB;

class RekapDataController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object)[
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];
        $activeMenu = 'laporan';
        $prodi_id = null;
        $startYear = null;
        $endYear = null;
        if (empty(request()->all())) {
            $currentYear = date('Y');
            $startYear = $request->input('start_year', $currentYear - 3);
            $endYear = $request->input('end_year', $currentYear);
            $prodi_id = $request->input('prodi_id', 4);
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
        return view('data.laporan.laporan', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'topProfesi' => $topProfesi,
            'chartData' => $chartData,
            'prodi' => $prodi,
            'prodi_id' => $prodi_id,
            'startYear' => $startYear,
            'endYear' => $endYear,
        ]);
    }
    public function filter(Request $request)
    {
        $startYear = $request->input('start_year');
        $endYear = $request->input('end_year');
        $prodi = $request->input('prodi_id');
        return redirect()->route('laporan', compact('startYear', 'endYear', 'prodi'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new LaporanSurveiExport($request->start_year,$request->end_year,$request->prodi_id), 'Laporan Rekap Hasil Tracer Study Lulusan.xlsx');
    }

    public function exportSurveiKepuasan()
    {
        return Excel::download(new LaporanSurveiKepuasan, 'Laporan Rekap Hasil Survei Kepuasan Pengguna Lulusan.xlsx');
    }

    public function exportBelumTS()
    {
        return Excel::download(new LaporanBelumTS, 'Laporan Rekap Lulusan Yang Belum Mengisi Tracer Study.xlsx');
    }

    public function exportBelumSurvei(Request $request)
    {
        dd($request->all());

        return Excel::download(new LaporanBelumSurvei(), 'Laporan Rekap Atasan Yang Belum Mengisi Survei Kepuasan.xlsx');
    }
}
