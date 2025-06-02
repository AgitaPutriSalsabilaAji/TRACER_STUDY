<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Key;
use App\Models\Alumni;
use App\Models\Lulusan;
use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use App\Models\SurveiKepuasan;
use Yajra\DataTables\Facades\DataTables;


class AlumniController extends Controller
{
    public function validateKode(Request $request)
    {

        $request->validate([
            'key' => 'required|exists:keys,key_value',
        ], [
            'key.exists' => 'Token tidak ditemukan atau tidak valid.',
        ]);

        $key = Key::where('key_value', $request->key)->first();
        if (!$key->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Mohon maaf, pengisian survei hanya dapat dilakukan satu kali. Berdasarkan catatan kami, Anda telah mengisi survei pada tanggal ' . $key->updated_at->format('d F Y') . '.',
            ]);
        }

        $alumni = Alumni::find($key->alumni_id);

        session([
            'validated_atasan' => true,
            'alumni_id' => $alumni->id,
            'nama' => $alumni->nama . ' (' . $alumni->nim . ')',
            'lulusan_id' => $key->lulusan_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Validasi berhasil'
        ]);
    }
    // Tampilkan form survei atasan
    public function create()
    {
        session()->forget('validated_alumni');

        $validated = session('validated_atasan', false);
        $nama = session('nama', '');
        $alumni_id = session('alumni_id', '');
        $lulusan_id = session('lulusan_id', '');

        $lulusan = Lulusan::find($lulusan_id);

        $nama_surveyor = '';
        $instansi = '';
        $jabatan = '';
        $email = '';

        if ($lulusan) {
            $nama_surveyor = $lulusan->nama_atasan_langsung;
            $instansi = $lulusan->nama_instansi;
            $jabatan = $lulusan->jabatan_atasan_langsung;
            $email = $lulusan->email_atasan_langsung;
        }

        return view('guest.form-atasan', compact(
            'validated',
            'nama',
            'alumni_id',
            'nama_surveyor',
            'instansi',
            'jabatan',
            'email'
        ));
    }


    // Simpan hasil survei atasan
    public function store(Request $request)
    {
        $request->validate([
            'g-recaptcha-response' => 'required|captcha',
            'alumni_id' => 'required|exists:alumni,id',
            'nama_surveyor' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'kerjasama_tim' => 'required|in:1,2,3,4',
            'keahlian_di_bidang_ti' => 'required|in:1,2,3,4',
            'kemampuan_bahasa_asing' => 'required|in:1,2,3,4',
            'kemampuan_komunikasi' => 'required|in:1,2,3,4',
            'pengembangan_diri' => 'required|in:1,2,3,4',
            'kepemimpinan' => 'required|in:1,2,3,4',
            'etos_kerja' => 'required|in:1,2,3,4',
            'kompetensi_belum_terpenuhi' => 'nullable|string',
            'saran_kurikulum' => 'nullable|string',
        ]);

        SurveiKepuasan::create([
            'alumni_id' => $request->alumni_id,
            'nama_surveyor' => $request->nama_surveyor,
            'instansi' => $request->instansi,
            'jabatan' => $request->jabatan,
            'email' => $request->email,
            'kerjasama_tim' => $request->kerjasama_tim,
            'keahlian_di_bidang_ti' => $request->keahlian_di_bidang_ti,
            'kemampuan_bahasa_asing' => $request->kemampuan_bahasa_asing,
            'kemampuan_komunikasi' => $request->kemampuan_komunikasi,
            'pengembangan_diri' => $request->pengembangan_diri,
            'kepemimpinan' => $request->kepemimpinan,
            'etos_kerja' => $request->etos_kerja,
            'kompetensi_belum_terpenuhi' => $request->kompetensi_belum_terpenuhi,
            'saran_kurikulum' => $request->saran_kurikulum,
        ]);
        $key = Key::where('alumni_id', $request->alumni_id)->first();

        $key->is_active = false;
        $key->save();



        return redirect()->route('guest.home')->with('success', 'Terima kasih telah mengisi survei!');
    }



    // Untuk autocomplete nama alumni (opsional)
    public function getNama(Request $request)
    {
        $search = $request->input('q');

        $alumni = Alumni::where('nama', 'LIKE', '%' . $search . '%')
            ->orWhere('nim', 'LIKE', '%' . $search . '%')
            ->orWhereRaw("YEAR(tanggal_lulus) LIKE ?", ["%$search%"]) // kalau mau cari berdasarkan tahun juga
            ->get(['id', 'nama', 'nim', 'tanggal_lulus']);

        $result = $alumni->map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->nama . ' | ' . $item->nim . ' | ' . Carbon::parse($item->tanggal_lulus)->year,
            ];
        });

        return response()->json($result);
    }

    // =====================
    // Tampilkan Halaman Data Alumni
    // =====================
    public function index()
    {
        $alumni = Alumni::with('programStudi')->get();
        $programStudi = ProgramStudi::all();
        $isSuperadmin = auth()->user()->is_superadmin;
        return view('data.data_alumni.data_alumni', compact('alumni', 'programStudi', 'isSuperadmin'));
    }

    // =====================

    // Create Alumni - Form & Simpan
    // =====================
    public function createAlumni()
    {
        $programStudi = ProgramStudi::all();
        return view('data.data_alumni.create', compact('programStudi'));
    }

    // =====================

    // Simpan Alumni Baru dari Halaman Admin
    // =====================
    public function storeAlumni(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:alumni,nim',
            'program_studi_id' => 'required|exists:program_studi_id|string|max:255',
            'tanggal_lulus' => 'required|date',
        ]);

        Alumni::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'program_studi' => $request->program_studi_id,
            'tanggal_lulus' => $request->tanggal_lulus,
        ]);

        return redirect()->route('data-alumni.index')->with('success', 'Data alumni berhasil ditambahkan!');
    }

    // Edit & Update Alumni
    // =====================

    public function editAlumni($id)
    {

        $alumni = Alumni::findOrFail($id);
        $programStudi = ProgramStudi::all();

        return response()->json([
            'alumni' => $alumni,
            'programStudi' => $programStudi
        ]);
    }

    public function updateAlumni(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:alumni,nim,' . $id,
            'program_studi_id' => 'required|string|max:255',
            'tanggal_lulus' => 'required|date',
        ]);


        $alumni = Alumni::findOrFail($id);
        $alumni->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'program_studi_id' => $request->program_studi_id,
            'tanggal_lulus' => $request->tanggal_lulus,
        ]);

        return redirect()->route('data-alumni.index')->with('success', 'Data alumni berhasil diperbarui!');
    }

    // =====================
    // Hapus Alumni
    // =====================

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = auth()->user()->is_superadmin
                ? Alumni::withTrashed()->with('programStudi')->select('alumni.*')
                : Alumni::with('programStudi')->select('alumni.*');

            $table = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('program_studi', function ($row) {
                    return $row->programStudi->program_studi ?? '-';
                })
                ->addColumn('tanggal_lulus', function ($row) {
                    return \Carbon\Carbon::parse($row->tanggal_lulus)->format('d-m-Y');
                });

            // Kalau superadmin, tambahkan kolom ini
            if (auth()->user()->is_superadmin) {
                $table->addColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d-m-Y H:i') : '-';
                })
                    ->addColumn('updated_at', function ($row) {
                        return $row->updated_at ? $row->updated_at->format('d-m-Y H:i') : '-';
                    })
                    ->addColumn('deleted_at', function ($row) {
                        return $row->deleted_at ? $row->deleted_at->format('d-m-Y H:i') : '-';
                    });
            }

         $table->addColumn('aksi', function ($row) {
    $deleteUrl = route('data-alumni.destroy', $row->id);
    $restoreUrl = route('data-alumni.restore', $row->id);
    $forceDeleteUrl = route('data-alumni.forceDelete', $row->id);

    $csrf = csrf_field();
    $methodDelete = method_field('DELETE');

    // Mulai wrapper responsif
    $buttons = '<div class="d-flex flex-wrap justify-content-center gap-1">';

    if (is_null($row->deleted_at)) {
        $buttons .= '<button onclick="editAlumni(' . $row->id . ')" class="btn btn-warning btn-sm m-1"><i class="fas fa-edit"></i> Edit</button>';
        $buttons .= <<<HTML
<form action="{$deleteUrl}" method="POST" class="d-inline m-1" onsubmit="return confirm('Yakin ingin menghapus alumni ini?')">
    {$csrf}
    {$methodDelete}
    <button class="btn btn-danger btn-sm">Hapus</button>
</form>
HTML;
    } else {
        if (auth()->user()->is_superadmin) {
            $buttons .= <<<HTML
<form action="{$restoreUrl}" method="POST" class="d-inline m-1" onsubmit="return confirm('Yakin ingin mengembalikan data {$row->nama} ?')"> 
    {$csrf}
    <button class="btn btn-success btn-sm"><i class="fas fa-undo"></i> Pulihkan</button>
</form>
<form action="{$forceDeleteUrl}" method="POST" class="d-inline m-1" onsubmit="return confirm('Yakin ingin menghapus permanen alumni ini?')">
    {$csrf}
    {$methodDelete}
    <button class="btn btn-danger btn-sm"><i class="fas fa-trash-restore-alt"></i> Buang</button>
</form>
HTML;
        }
    }

    $buttons .= '</div>';

    return $buttons;
});


            return $table->rawColumns(['aksi'])->make(true);
        }
    }

    // Soft Delete (hapus sementara)
    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->delete();
        return back()->with('success', 'Alumni berhasil dihapus .');
    }

    // Restore (kembalikan data yang sudah di soft delete)
    public function restore($id)
    {
        $alumni = Alumni::withTrashed()->findOrFail($id);
        $alumni->restore();

        return back()->with('success', "Alumni {$alumni->nama} berhasil dipulihkan.");
    }


    // Hapus Permanen (force delete)
    public function forceDelete($id)
    {
        $alumni = Alumni::withTrashed()->findOrFail($id);
        $alumni->forceDelete();
        return back()->with('success', "Alumni {$alumni->nama} berhasil dihapus permanen.");
    }
}
