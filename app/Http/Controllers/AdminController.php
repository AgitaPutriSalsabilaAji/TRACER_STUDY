<?php

namespace App\Http\Controllers;

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




        return view('admin.dashboard', compact('breadcrumb', 'activeMenu', 'topProfesi', 'jenisInstansi'));
    }

    public function lulusanList(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('alumni as a')
                ->leftJoin('lulusan as l', 'a.id', '=', 'l.alumni_id')
                ->leftJoin('profesi as p', 'l.profesi_id', '=', 'p.id')
                ->leftJoin('kategori_profesi as kp', 'p.kategori_profesi_id', '=', 'kp.id') // Join dengan kategori profesi
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
}
