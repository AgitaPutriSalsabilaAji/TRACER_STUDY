<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Alumni; // Pastikan model Alumni sudah ada
use Exception;

class GuestController extends Controller
{
    // Menampilkan form
   // GuestController.php
public function create()
{
    // Generate tahun lulus dari tahun sekarang hingga 2000
    $tahunLulus = [];
    for ($i = date('Y'); $i >= 2000; $i--) {
        $tahunLulus[$i] = $i;
    }

    // Pastikan nama view sesuai dengan file view yang ada
    return view('guest/form-alumni', compact('tahunLulus'));
}


  // Menyimpan data alumni
    public function store(Request $request)
    {
        try {
            // Debug awal: tampilkan semua input yang dikirim
            dd($request->all());

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'prodi_studi' => 'required',
                'tahun' => 'required|numeric',
                'no_hp' => 'required|string|max:15',
                'email' => 'required|email',
                'tgl_pertama_kerja' => 'nullable|date',
                'tgl_instansi' => 'nullable|date',
                'jenis_instansi' => 'required|string',
                'nama_instansi' => 'required|string',
                'skala_instansi' => 'required|string',
                'lokasi_instansi' => 'required|string',
                'kategori' => 'required|string',
                'profesi' => 'required|string',
                'feedback' => 'nullable|string',
                'survei' => 'nullable|string',
                'kepuasan' => 'required|string|in:Sangat Puas,Puas,Tidak Puas',
            ]);

            // Debug validasi berhasil
            Log::info('Validated Data:', $validated);

            // Simpan ke database
            Alumni::create($validated);

            return redirect()->route('guest/form.alumni')->with('success', 'Data alumni berhasil disimpan!');
        } catch (Exception $e) {
            // Tangkap error dan log
            Log::error('Error menyimpan data alumni: ' . $e->getMessage());
            return back()->withErrors(['msg' => 'Terjadi kesalahan saat menyimpan data alumni.'])->withInput();
        }
    }
}
