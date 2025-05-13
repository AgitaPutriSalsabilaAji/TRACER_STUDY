<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Profesi;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\JenisInstansi;
use App\Models\KategoriProfesi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Alumni; // Pastikan model Alumni sudah ada
use App\Models\Lulusan;

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

        $kategoriProfesi = KategoriProfesi::all();
        $profesi =  Profesi::all();
        $jenisInstansi = JenisInstansi::all();
        $prodi =  ProgramStudi::all();
        // Pastikan nama view sesuai dengan file view yang ada
        return view('guest/form-alumni', compact('tahunLulus', 'kategoriProfesi', 'profesi', 'jenisInstansi', 'prodi'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi input dari form
            $validated = $request->validate([
                'alumni_id'              => 'required|exists:alumni,id',
                'profesi_id'             => 'required|exists:profesi,id',
                'jenis_instansi_id'      => 'required|exists:jenis_instansi,id',
                'tahun_lulus'            => 'required|numeric',
                'no_hp'                  => 'required|string|max:15',
                'email'                  => 'required|email',
                'tgl_pertama_kerja'      => 'nullable|date',
                'tgl_mulai_kerja_instansi' => 'nullable|date',
                'nama_instansi'          => 'required|string|max:255',
                'skala'                  => 'required|string|max:100',
                'lokasi_instansi'        => 'required|string|max:255',
                'nama_atasan_langsung'   => 'required|string|max:255',
                'jabatan_atasan_langsung' => 'required|string|max:255',
                'no_hp_atasan_langsung'  => 'required|string|max:15',
                'email_atasan_langsung'  => 'required|email',
            ]);

            // Jika validasi sukses, simpan data
            Lulusan::create($validated);
            $email = $request->email_atasan_langsung;
            
            return redirect()->route('guest/form-alumni')->with('success', 'Data alumni berhasil disimpan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika validasi gagal
            return redirect()->back()
                ->withErrors($e->validator) // Mengirim error validasi kembali
                ->withInput() // Menyertakan data inputan sebelumnya
                ->with('alert', 'Terjadi kesalahan validasi. Mohon periksa kembali data yang Anda masukkan.');
        } catch (Exception $e) {
            // Tangkap exception lainnya
            Log::error('Error menyimpan data alumni: ' . $e->getMessage()); // Log error ke file log
            return back()
                ->with('alert', 'Terjadi kesalahan saat menyimpan data alumni. Silakan coba lagi.')
                ->withInput();
        }
    }


    public function getNama(Request $request)
    {
        $query = $request->get('query');

        $data = Alumni::where('nama', 'LIKE', "%{$query}%")
            ->orWhere('nim', 'LIKE', "%{$query}%")
            ->get(['id', 'nama', 'nim']);

        return response()->json($data);
    }
}
