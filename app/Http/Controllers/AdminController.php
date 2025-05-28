<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\ProgramStudi;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
            $prodi_id = 1;
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

        $tabel_lulusan = DB::table('alumni as a')
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
            ->where('a.program_studi_id', $prodi_id)
            ->groupBy(DB::raw('YEAR(a.tanggal_lulus)'))
            ->orderBy('tahun_lulus')
            ->get();

        $tabel_masa_tunggu = Alumni::select(
            DB::raw('YEAR(tanggal_lulus) as tahun_lulusan'),
            DB::raw('COUNT(alumni.id) as jumlah_lulusan'),
            DB::raw('COUNT(lulusan.id) as jumlah_terlacak'),
            DB::raw('ROUND(AVG(TIMESTAMPDIFF(DAY, alumni.tanggal_lulus, lulusan.tgl_pertama_kerja) / 30), 2) as rata_rata_waktu_tunggu_bulan')
        )
            ->leftJoin('lulusan', 'alumni.id', '=', 'lulusan.alumni_id')
            ->whereBetween(DB::raw('YEAR(alumni.tanggal_lulus)'), [$startYear, $endYear])
            ->where('alumni.program_studi_id', $prodi_id)
            ->groupBy(DB::raw('YEAR(alumni.tanggal_lulus)'))
            ->orderBy('tahun_lulusan')
            ->get();
        $tabel_performa = DB::table('view_rekap_kemampuan')
            ->select(
                'program_studi_id',
                'jenis_kemampuan',
                DB::raw('ROUND(AVG(sangat_baik), 2) as sangat_baik'),
                DB::raw('ROUND(AVG(baik), 2) as baik'),
                DB::raw('ROUND(AVG(cukup), 2) as cukup'),
                DB::raw('ROUND(AVG(kurang), 2) as kurang')
            )
            ->where('program_studi_id', $prodi_id)
            ->whereBetween('tahun_lulus', [$startYear, $endYear])
            ->groupBy('program_studi_id', 'jenis_kemampuan')
            ->get();

        return view('admin.dashboard', compact('tabel_lulusan', 'tabel_masa_tunggu', 'tabel_performa', 'activeMenu', 'topProfesi', 'jenisInstansi', 'chartData', 'prodi', 'startYear', 'endYear', 'prodi_id'));
    }
    public function filter(Request $request)
    {
        $startYear = $request->input('start_year');
        $endYear = $request->input('end_year');
        $prodi = $request->input('prodi_id');
        return redirect()->route('dashboard', compact('startYear', 'endYear', 'prodi'));
    }

    public function index_admin()
    {
        $breadcrumb = (object)[
            'title' => 'Kelola Admin',
            'list' => ['Home', 'Admin']
        ];
        $activeMenu = 'admin';

        return view('data.tambah_admin.tambah_admin', compact('breadcrumb', 'activeMenu'));
    }

    public function list()
    {
        $data = Admin::select(['id', 'username', 'email']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $editUrl = route('admin.update', $row->id);
                $deleteUrl = route('admin.destroy', $row->id);

                return '
                    <button onclick="editAdmin(\'' . $editUrl . '\', \'' . e($row->username) . '\', \'' . e($row->email) . '\')" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button onclick="deleteAdmin(\'' . $deleteUrl . '\')" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admins,username',
            'email' => 'required|email|unique:admins,email',
        ]);

        // Ambil input dari request
        $username = $request->username;
        $email = $request->email;

        // Buat password otomatis sama dengan username (biasanya di-hash dulu)
        $password = Hash::make($request->username);

        Admin::create([
            'username' => $request->username,
            'name' => $request->username,
            'email' => $request->email,
            'password' => $password
        ]);

        // Kirim email ke admin baru
        $data = [
            'subject' => 'Akun Admin Baru',
            'body' => "Selamat! Anda telah ditambahkan sebagai admin.\n\n" .
                "Berikut adalah detail akun Anda:\n" .
                "Username: {$username}\n" .
                "Password: {$username}\n\n" .
                "Silakan login dan segera ubah password Anda demi keamanan akun.\n\n" .
                "Terima kasih,\nTracer Study"
        ];

        $adminsEmail = $email;
        Mail::raw($data['body'], function ($message) use ($adminsEmail, $data) {
            $message->to($adminsEmail)
                ->subject($data['subject']);
        });

        return redirect()->back()->with('success', 'Admin berhasil ditambahkan. ');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|unique:admins,username,' . $id,
            'email' => 'required|email|unique:admins,email,' . $id
        ]);

        Admin::where('id', $id)->update([
            'username' => $request->username,
            'email' => $request->email
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Admin::destroy($id);
        return response()->json(['success' => true]);
    }
}
