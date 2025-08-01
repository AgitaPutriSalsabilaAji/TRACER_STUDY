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
            'alumni_id_validate' => 'required|exists:alumni,id',
            'nim' => 'required|string',
            'prodi' => 'required|integer',
            'tahun_lulus' => 'required|integer',
        ]);
        $record = Lulusan::where('alumni_id', $request->alumni_id_validate)->first();

        if ($record) {
            $tanggal = $record->created_at->format('d-m-Y');

            return response()->json([
                'success' => false,

                'message' => "Dengan hormat, pengisian formulir ini hanya diperkenankan satu kali. Berdasarkan catatan kami, Anda telah melakukan pengisian pada tanggal {$tanggal} ",
            ]);
        }
        $alumni = Alumni::find($request->alumni_id_validate);

        if (!$alumni) {
            return response()->json([
                'success' => false,
                'message' => 'Alumni tidak ditemukan.',
            ]);
        }

        if ($alumni->nim !== $request->nim) {
            return response()->json([
                'success' => false,
                'message' => 'NIM tidak cocok.',
            ]);
        }

        if ((int) $request->tahun_lulus !== (int) Carbon::parse($alumni->tanggal_lulus)->year) {
            return response()->json([
                'success' => false,
                'message' => 'Tahun lulus tidak cocok.',
            ]);
        }

        if ((int) $request->prodi !== (int) $alumni->program_studi_id) {
            return response()->json([
                'success' => false,
                'message' => 'Program studi tidak cocok.',
            ]);
        }

        session([
            'validated_alumni' => true,
            'alumni_id' => $alumni->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Validasi berhasil',
        ]);
    }
    // Menampilkan formh
    // GuestController.php
    public function create()
    {
        $validated = session('validated_alumni', false);
        $kategoriProfesi = KategoriProfesi::all();
        $profesi = Profesi::all();
        $jenisInstansi = JenisInstansi::all();
        $key = Key::where('alumni_id')->first();
        $prodi = ProgramStudi::all();

        $alumni_id = session('alumni_id', '');
        $alumni = Alumni::find($alumni_id);
        $prodi_terpilih = '';
        $tahun_lulus_terpilih = '';
        $nama = '';
        if ($alumni) {
            $nama = $alumni->nama . ' (' . $alumni->nim . ')';
            $prodi_terpilih = $alumni->program_studi_id;
            $tahun_lulus_terpilih = date('Y', strtotime($alumni->tanggal_lulus));
        }
        $prodi_terpilih_nama = optional($prodi->firstWhere('id', $prodi_terpilih))->program_studi ?? '-';
        return view('guest/form-alumni', compact('kategoriProfesi', 'profesi', 'jenisInstansi', 'prodi', 'validated', 'nama', 'alumni_id', 'prodi_terpilih', 'prodi_terpilih_nama', 'tahun_lulus_terpilih'));
    }

    public function store(Request $request)
    {
        try {
            // Cari alumni berdasarkan alumni_id
            $alumni = Alumni::find($request->alumni_id);
            if (!$alumni) {
                return redirect()->back()->withInput()->with('alert', 'Mohon maaf, Alumni tidak ditemukan.');
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
                    'jenis_instansi_id' => 'required|exists:jenis_instansi,id',
                    'tgl_pertama_kerja' => 'required|date',
                    'tgl_mulai_kerja_instansi' => 'required|date',
                    'nama_instansi' => 'required|string|max:255',
                    'skala' => 'required|string|max:100',
                    'lokasi_instansi' => 'required|string|max:255',
                    'nama_atasan_langsung' => 'required|string|max:255',
                    'jabatan_atasan_langsung' => 'required|string|max:255',
                    'no_hp_atasan_langsung' => 'required|string|max:15',
                    'email_atasan_langsung' => 'required|email',
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
            $lulusan = Lulusan::create($validated);

            // Jika kategori bukan 3, kirim email permohonan survei ke atasan langsung
            if ($request->kategori != 3 && !empty($request->email_atasan_langsung)) {
                $token = bin2hex(random_bytes(16));
                $keyRecord = Key::create([
                    'alumni_id' => $request->alumni_id,
                    'lulusan_id' => $lulusan->id,
                    'key_value' => $token,
                ]);

                $email = $request->email_atasan_langsung;
                $token = $keyRecord->key_value;
                Mail::send(
                    'emails.permohonan_survei',
                    [
                        'alumni' => $alumni,
                        'token' => $token,
                        'survey_link' => route('form.atasan'),
                    ],
                    function ($message) use ($email) {
                        $message->to($email)->subject('Permohonan Pengisian Survei Kinerja Alumni');
                    },
                );
            }
            if ($request->kategori == 3) {
                return redirect('/')->with('success', 'Data alumni berhasil disimpan. Terima kasih atas partisipasi Anda!')->with('success_atasan', 'Data alumni berhasil disimpan. Terima kasih atas partisipasi Anda!');
            } else {
                return redirect('/')->with('success', 'Data alumni berhasil disimpan. Terima kasih atas partisipasi Anda. Mohon informasikan kepada atasan Anda untuk mengisi survei yang telah dikirimkan ke email.')->with('success_atasan', 'Data alumni berhasil disimpan. Terima kasih atas partisipasi Anda!');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log error validasi
            Log::error('Validation error: ' . $e->getMessage());

            return redirect()->back()->withErrors($e->validator)->withInput()->with('alert', 'Terjadi kesalahan validasi. Mohon periksa kembali data yang Anda masukkan.');
        } catch (\Exception $e) {
            // Log error umum
            Log::error('Error menyimpan data alumni: ' . $e->getMessage());

            return redirect()->back()->with('alert', 'Terjadi kesalahan saat menyimpan data alumni. Silakan coba lagi.')->withInput();
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
