<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Key;
use App\Models\Alumni;
use Illuminate\Http\Request;
use App\Models\SurveiKepuasan;

class AlumniController extends Controller
{
    public function validateKode(Request $request)
    {

        $request->validate([
            'key' => 'required|exists:keys,key_value',
        ]);
        $key = Key::where('key_value', $request->key)->first();
        if (!$key) {
            return response()->json([
                'success' => false,
                'message' => 'Key tidak valid atau survei sudah diisi'
            ]);
        }
        
        $alumni = Alumni::find($key->alumni_id);

        session([
            'validated_atasan' => true,
            'alumni_id' => $alumni->id,
            'nama' => $alumni->nama . ' (' . $alumni->nim . ')',
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
        return view('guest.form-atasan', compact('validated', 'nama', 'alumni_id'));
    }

    // Simpan hasil survei atasan
    public function store(Request $request)
    {

        $request->validate([
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
        Key::where('alumni_id', $request->alumni_id)->delete();

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
        $alumni = Alumni::all();
        return view('data.data_alumni.data_alumni', compact('alumni'));
    }

    // =====================
    // Simpan Alumni Baru dari Halaman Admin
    // =====================
    public function storeAlumni(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:alumni,nim',
            'program_studi' => 'required|string|max:255',
            'tanggal_lulus' => 'required|date',
        ]);

        Alumni::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'program_studi' => $request->program_studi,
            'tanggal_lulus' => $request->tanggal_lulus,
        ]);

        return redirect()->route('data-alumni.index')->with('success', 'Data alumni berhasil ditambahkan!');
    }

    public function createAlumni()
    {
        return view('data.data_alumni.create');
    }

    public function editAlumni($id)
    {
        $alumni = Alumni::findOrFail($id);
        return view('data.data_alumni.edit', compact('alumni'));
    }

    public function updateAlumni(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:alumni,nim,' . $id,
            'program_studi' => 'required|string|max:255',
            'tanggal_lulus' => 'required|date',
        ]);

        $alumni = Alumni::findOrFail($id);
        $alumni->update($request->all());

        return redirect()->route('data-alumni.index')->with('success', 'Data alumni berhasil diperbarui!');
    }

    public function destroyAlumni($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->delete();

        return redirect()->route('data-alumni.index')->with('success', 'Data alumni berhasil dihapus!');
    }
}
