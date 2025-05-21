<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Key;
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

    public function validateKode(Request $request)
    {
        $request->validate([
            'alumni_id' => 'required|exists:alumni,id',
            'nim' => 'required|string',
            'prodi' => 'required|integer',
            'tahun_lulus' => 'required|integer',
        ]);
        $exists = Lulusan::where('alumni_id', $request->alumni_id)->exists();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya bisa mengisi satu kali'
            ]);
        }
        $alumni = Alumni::find($request->alumni_id);

        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'Alumni tidak ditemukan.'
            ]);
        }

        if ($alumni->nim !== $request->nim) {
            return response()->json([
                'success' => false,
                'message' => 'NIM tidak cocok.'
            ]);
        }

        if ((int)$request->tahun_lulus !== (int)Carbon::parse($alumni->tanggal_lulus)->year) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun lulus tidak cocok.'
            ]);
        }

        if ((int)$request->prodi !== (int)$alumni->program_studi_id) {
            return response()->json([
                'success' => false,
                'message' => 'Program studi tidak cocok.'
            ]);
        }
        $token = bin2hex(random_bytes(16));
        Key::create([
            'alumni_id' => $request->alumni_id,
            'key_value' =>  $token,
        ]);
        session(['validated_alumni' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Validasi berhasil'
        ]);
    }
    // Menampilkan form
    // GuestController.php
    public function create()
    {
        $validated = session('validated_alumni', false);
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
        return view('guest/form-alumni', compact('tahunLulus', 'kategoriProfesi', 'profesi', 'jenisInstansi', 'prodi', 'validated'));
    }

    public function store(Request $request)
    {
        try {
            // Cari alumni berdasarkan alumni_id
            $alumni = Alumni::find($request->alumni_id);
            if (!$alumni) {
                return redirect()->back()
                    ->withInput()
                    ->with('alert', 'Alumni tidak ditemukan.');
            }

            // Validasi kecocokan tahun lulus dengan data alumni
            if ($request->tahun_lulus != Carbon::parse($alumni->tanggal_lulus)->year) {
                return redirect()->back()
                    ->withInput()
                    ->with('alert', 'Tahunnya beda tuan');
            }

            // Validasi kecocokan program studi dengan data alumni
            if ($request->prodi != $alumni->program_studi_id) {
                return redirect()->back()
                    ->withInput()
                    ->with('alert', 'Produnya beda sama yang di database');
            }

            // Atur aturan validasi dasar
            $rules = [
                'g-recaptcha-response' => 'required|captcha',
                'alumni_id' => 'required|exists:alumni,id',
                'profesi_id' => 'required|exists:profesi,id',
                'tahun_lulus' => 'required|numeric',
                'no_hp' => 'required|string|max:15',
                'email' => 'required|email',
            ];

            // Jika kategori bukan 3, tambahkan validasi detail instansi dan atasan
            if ($request->kategori != 3) {
                $rules = array_merge($rules, [
                    'jenis_instansi_id' => 'nullable|exists:jenis_instansi,id',
                    'tgl_pertama_kerja' => 'nullable|date',
                    'tgl_mulai_kerja_instansi' => 'nullable|date',
                    'nama_instansi' => 'nullable|string|max:255',
                    'skala' => 'nullable|string|max:100',
                    'lokasi_instansi' => 'nullable|string|max:255',
                    'nama_atasan_langsung' => 'nullable|string|max:255',
                    'jabatan_atasan_langsung' => 'nullable|string|max:255',
                    'no_hp_atasan_langsung' => 'nullable|string|max:15',
                    'email_atasan_langsung' => 'nullable|email',
                ]);
            }

            // Pesan error khusus captcha
            $messages = [
                'g-recaptcha-response.required' => 'Silakan centang captcha terlebih dahulu.',
                'g-recaptcha-response.captcha' => 'Kode captcha tidak valid. Silakan coba lagi.',
            ];

            // Validasi request sekaligus semua aturan dan pesan
            $validated = $request->validate($rules, $messages);

            // Simpan data lulusan ke database
            Lulusan::create($validated);

            // Jika kategori bukan 3, kirim email permohonan survei ke atasan langsung
            if ($request->kategori != 3 && !empty($request->email_atasan_langsung)) {
                $email = $request->email_atasan_langsung;
                $data = [
                    'subject' => 'Permohonan Pengisian Survei Kinerja Alumni',
                    'body' => "Yth. Bapak/Ibu,\n\n" .
                        "Kami dari tim Tracer Study Politeknik Negeri Malang memohon kesediaan Bapak/Ibu untuk mengisi survei terkait kinerja alumni kami, saudara/i *{$alumni->nama}*, yang saat ini bekerja di perusahaan/instansi Bapak/Ibu.\n\n" .
                        "Survei ini bertujuan untuk meningkatkan kualitas pendidikan dan menyesuaikan kurikulum dengan kebutuhan dunia kerja.\n\n" .
                        "Mohon luangkan waktu sejenak untuk mengisi survei tersebut melalui tautan berikut:\n[tautan survei di sini]\n\n" .
                        "Atas perhatian dan kerja sama Bapak/Ibu, kami ucapkan terima kasih.\n\n" .
                        "Hormat kami,\nTim Tracer Study\nPoliteknik Negeri Malang"
                ];

                Mail::raw($data['body'], function ($message) use ($email, $data) {
                    $message->to($email)
                        ->subject($data['subject']);
                });
            }
            return redirect('/')
                ->with('success', 'Data alumni berhasil disimpan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log error validasi
            Log::error('Validation error: ' . $e->getMessage());

            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('alert', 'Terjadi kesalahan validasi. Mohon periksa kembali data yang Anda masukkan.');
        } catch (\Exception $e) {
            // Log error umum
            Log::error('Error menyimpan data alumni: ' . $e->getMessage());

            return redirect()->back()
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
