<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use App\Models\ProgramStudi;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Spatie\LaravelIgnition\Recorders\DumpRecorder\Dump;

class DataImportController extends Controller
{
    public function upload(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:2048',
        ]);

        // Simpan file ke folder public/uploads
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = public_path('uploads/' . $fileName);
        $file->move(public_path('uploads'), $fileName);

        // Baca isi file Excel
        $collections = Excel::toCollection(null, $filePath)->first();

        $data = [];

        foreach ($collections as $index => $row) {
            if ($index === 0) continue; // Skip header

            try {
                $programStudi = $row[0];
                $nim = $row[1];
                $nama = $row[2];
                // Konversi tanggal Excel
                $tanggalLulus = is_numeric($row[3])
                    ? Date::excelToDateTimeObject($row[3])->format('Y-m-d')
                    : date('Y-m-d', strtotime($row[3]));

                // ✅ Cek apakah program studi sudah ada, kalau tidak maka buat
                $prodiId = ProgramStudi::firstOrCreate(
                    ['program_studi' => $programStudi]
                );


                // Simpan ke array (atau database)
                // Jika ingin simpan ke database:
                Alumni::firstOrCreate(
                    [
                        'nim' => $nim,
                        'program_studi_id' => $prodiId->id,
                    ],
                    [
                        'nama' => $nama,
                        'tanggal_lulus' => $tanggalLulus,
                    ]
                );
            } catch (\Exception $e) {
                Log::error("Baris $index gagal: " . $e->getMessage());
            }
        }
        // ✅ Hapus file setelah diproses
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        return back()->with('success', 'Data berhasil diunggah dan dibaca.')
            ->with('data_excel', $data); // bisa ditampilkan di view
    }
}
