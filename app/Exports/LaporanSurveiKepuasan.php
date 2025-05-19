<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class LaporanSurveiKepuasan implements FromCollection
{
    public function collection()
    {
    $data = DB::table('survei_kepuasan as sk')
    ->join('alumni as a', 'sk.alumni_id', '=', 'a.id')
    ->leftJoin('program_studi as ps', 'a.program_studi_id', '=', 'ps.id')
    ->leftJoin('lulusan as l', 'l.alumni_id', '=', 'a.id')
    ->select([
        'sk.nama_surveyor as Nama',
        'sk.instansi as Instansi',
        'sk.jabatan as Jabatan',
        'sk.email as Email',
        'a.nama as Nama_Alumni',
        'ps.program_studi as Program_Studi',
        DB::raw('YEAR(l.tahun_lulus) as Tahun_Lulus'),
        'sk.kerjasama_tim as Kerjasama_Tim',
        'sk.keahlian_di_bidang_ti as Keahlian_di_bidang_TI',
        'sk.kemampuan_bahasa_asing as Kemampuan_berbahasa_asing',
        'sk.kemampuan_komunikasi as Kemampuan_berkomunikasi',
        'sk.pengembangan_diri as Pengembangan_diri',
        'sk.kepemimpinan as Kepemimpinan',
        'sk.etos_kerja as Etos_Kerja',
        'sk.kompetensi_belum_terpenuhi as Kompetensi_yang_dibutuhkan_tapi_belum_dapat_dipenuhi',
        'sk.saran_kurikulum as Saran_untuk_kurikulum_program_studi'
    ])
    ->get();
    return $data;
    }
}
