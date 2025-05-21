<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class LaporanSurveiKepuasan implements FromCollection, WithHeadings
{
    protected $startYear;
    protected $endYear;
    protected $prodi_id;

    public function __construct($startYear, $endYear, $prodi_id)
    {
        $this->startYear = $startYear;
        $this->endYear = $endYear;
        $this->prodi_id = $prodi_id;
    }

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
        ->when($this->startYear, fn($query) => $query->where('l.tahun_lulus', '>=', $this->startYear))
        ->when($this->endYear, fn($query) => $query->where('l.tahun_lulus', '<=', $this->endYear))
        ->when($this->prodi_id, fn($query) => $query->where('a.program_studi_id', $this->prodi_id))
        ->get();
    return $data;
    }

    public function headings(): array
    {
        return [
            'Nama Surveyor',
            'Instansi',
            'Jabatan',
            'Email',
            'Nama Alumni',
            'Program Studi',
            'Tahun Lulus',
            'Kerjasama Tim',
            'Keahlian di Bidang TI',
            'Kemampuan Berbahasa Asing',
            'Kemampuan Berkomunikasi',
            'Pengembangan Diri',
            'Kepemimpinan',
            'Etos Kerja',
            'Kompetensi yang Dibutuhkan tapi Belum Dipenuhi',
            'Saran untuk Kurikulum Program Studi',
        ];
    }
}
