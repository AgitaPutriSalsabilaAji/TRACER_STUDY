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
        return Excel::download(new LaporanSurveiKepuasan($request->start_year,$request->end_year,$request->prodi_id), 'Laporan Rekap Hasil Survei Kepuasan Pengguna Lulusan.xlsx');
    }

    public function exportBelumTS(Request $request)
    {
        return Excel::download(new LaporanBelumTS($request->start_year,$request->end_year,$request->prodi_id), 'Laporan Rekap Lulusan Yang Belum Mengisi Tracer Study.xlsx');
    }

    public function exportBelumSurvei(Request $request)
    {

        return Excel::download(new LaporanBelumSurvei($request->start_year,$request->end_year,$request->prodi_id), 'Laporan Rekap Atasan Yang Belum Mengisi Survei Kepuasan.xlsx');
    }
}
