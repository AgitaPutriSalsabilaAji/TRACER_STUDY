<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Lulusan;
use App\Models\Profesi;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use App\Models\JenisInstansi;
use Illuminate\Support\Carbon;
use App\Models\KategoriProfesi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Alumni; // Pastikan model Alumni sudah ada

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
            $alumni = Alumni::find($request->alumni_id);


            $validated = [];
            if (!($request->tahun_lulus == Carbon::parse($alumni->tanggal_lulus)->year)) {
                return redirect()->back()
                    ->withInput() 
                    ->with('alert', 'Tahunnya beda tuan');
            } else if (!($request->prodi == $alumni->program_studi_id)) {
                return redirect()->back()
                    ->withInput() 
                    ->with('alert', 'Produnya beda sama yang di database');
            }
            if ($request->kategori == 3) {
                $validated = $request->validate([
                    'alumni_id'              => 'required|exists:alumni,id',
                    'profesi_id'             => 'required|exists:profesi,id',
                    'tahun_lulus'            => 'required|numeric',
                    'no_hp'                  => 'required|string|max:15',
                    'email'                  => 'required|email',
                ]);
                Lulusan::create($validated);
            } else {
                $request->validate([
                    'alumni_id'              => 'required|exists:alumni,id',
                    'profesi_id'             => 'required|exists:profesi,id',
                    'jenis_instansi_id'      => 'nullable|exists:jenis_instansi,id',
                    'tahun_lulus'            => 'required|numeric',
                    'no_hp'                  => 'required|string|max:15',
                    'email'                  => 'required|email',
                    'tgl_pertama_kerja'      => 'nullable|date',
                    'tgl_mulai_kerja_instansi' => 'nullable|date',
                    'nama_instansi'          => 'nullable|string|max:255',
                    'skala'                  => 'nullable|string|max:100',
                    'lokasi_instansi'        => 'nullable|string|max:255',
                    'nama_atasan_langsung'   => 'nullable|string|max:255',
                    'jabatan_atasan_langsung' => 'nullable|string|max:255',
                    'no_hp_atasan_langsung'  => 'nullable|string|max:15',
                    'email_atasan_langsung'  => 'nullable|email',
                ]);


                Lulusan::create($validated);
                $email = $request->email_atasan_langsung;

                $data = [
                    'subject' => 'Permohonan Pengisian Survei Kinerja Alumni',
                    'title' => 'Permohonan Pengisian Survei',
                    'body' => "Yth. Bapak/Ibu,\n\n" .
                        "Kami dari tim Tracer Study Politeknik Negeri Malang memohon kesediaan Bapak/Ibu untuk mengisi survei terkait kinerja alumni kami, saudara/i *{$alumni->nama}*, yang saat ini bekerja di perusahaan/instansi Bapak/Ibu.\n\n" .
                        "Survei ini bertujuan untuk meningkatkan kualitas pendidikan dan menyesuaikan kurikulum dengan kebutuhan dunia kerja.\n\n" .
                        "Mohon luangkan waktu sejenak untuk mengisi survei tersebut melalui tautan berikut:\n[tautan survei di sini]\n\n" .
                        "Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.\n\n" .
                        "Hormat kami,\n" .
                        "Tim Tracer Study\n" .
                        "Politeknik Negeri Malang"
                ];

                Mail::raw($data['body'], function ($message) use ($email, $data) {
                    $message->to($email)
                        ->subject($data['subject']);
                });

                return redirect()->route('guest.home')->with('success', 'Data alumni berhasil disimpan!');
            }
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
