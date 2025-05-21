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

        $belum_tracer = DB::table('alumni as a')
                ->leftJoin('lulusan as l', 'a.nim', '=', 'l.alumni_id')
                ->select(
                    'a.program_studi_id',
                    DB::raw('EXTRACT(YEAR FROM a.tanggal_lulus) as tahun_lulus'),
                    DB::raw('COUNT(CASE WHEN l.alumni_id IS NULL THEN 1 END) as jumlah_belum_mengisi')
                )
                ->whereBetween(DB::raw('EXTRACT(YEAR FROM a.tanggal_lulus)'), [$startYear, $endYear])
                ->where('a.program_studi_id', $prodi_id)
                ->groupBy('a.program_studi_id', DB::raw('EXTRACT(YEAR FROM a.tanggal_lulus)'))
                ->orderBy(DB::raw('EXTRACT(YEAR FROM a.tanggal_lulus)'))
                ->get();

        $belum_survey = DB::table('alumni as a')
            ->join('lulusan as l', 'a.id', '=', 'l.alumni_id')
            ->leftJoin('survei_kepuasan as sk', 'l.alumni_id', '=', 'sk.alumni_id')
            ->selectRaw("
                COUNT(CASE WHEN sk.alumni_id IS NOT NULL THEN 1 END) AS jumlah_mengisi_survei,
                COUNT(CASE WHEN sk.alumni_id IS NULL THEN 1 END) AS jumlah_belum_mengisi_survei
            ")
            ->whereBetween(DB::raw('EXTRACT(YEAR FROM a.tanggal_lulus)'), [2023, 2025])
            ->where('a.program_studi_id', 3)
            ->first();

        $chart_survei = DB::table('view_rekap_kemampuan')
            ->select(
                'tahun_lulus as year',
                'jenis_kemampuan',
                DB::raw('ROUND(AVG(sangat_baik), 2) as nilai')
            )
            ->where('program_studi_id', $prodi_id)
            ->whereBetween('tahun_lulus', [$startYear, $endYear])
            ->groupBy('tahun_lulus', 'jenis_kemampuan')
            ->get();
    


        $prodi = ProgramStudi::all();
        return view('data.laporan.laporan', [
            'chart_survei' => $chart_survei,
            'topProfesi' => $topProfesi,
            'chartData' => $chartData,
            'belum_tracer' => $belum_tracer,
            'belum_survey' => $belum_survey,
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
        return Excel::download(new LaporanSurveiExport($request->start_year, $request->end_year, $request->prodi_id), 'Laporan Rekap Hasil Tracer Study Lulusan.xlsx');
    }

    public function exportSurveiKepuasan(Request $request)
    {
        return Excel::download(new LaporanSurveiKepuasan($request->start_year, $request->end_year, $request->prodi_id), 'Laporan Rekap Hasil Survei Kepuasan Pengguna Lulusan.xlsx');
    }

    public function exportBelumTS(Request $request)
    {
        return Excel::download(new LaporanBelumTS($request->start_year, $request->end_year, $request->prodi_id), 'Laporan Rekap Lulusan Yang Belum Mengisi Tracer Study.xlsx');
    }

    public function exportBelumSurvei(Request $request)
    {

        return Excel::download(new LaporanBelumSurvei($request->start_year, $request->end_year, $request->prodi_id), 'Laporan Rekap Atasan Yang Belum Mengisi Survei Kepuasan.xlsx');
    }
}
