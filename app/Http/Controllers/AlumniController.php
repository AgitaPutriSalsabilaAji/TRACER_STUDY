<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Alumni;
use App\Models\SurveiKepuasan;

class AlumniController extends Controller
{
    // Tampilkan form survei atasan
    public function create()
    {
        session()->forget('validated_alumni');
        return view('guest.form-atasan');
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
}
