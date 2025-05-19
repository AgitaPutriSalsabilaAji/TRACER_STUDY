<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LaporanBelumSurvei implements FromCollection
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }
    public function collection()
    {
    $rekapLulusanBelumIsiTracer = DB::table('lulusan as l')
    ->join('alumni as a', 'l.alumni_id', '=', 'a.id')
    ->join('program_studi as ps', 'a.program_studi_id', '=', 'ps.id')
    ->select(
        'l.nama_atasan_langsung as Nama',
        'l.nama_instansi as Instansi',
        'l.jabatan_atasan_langsung as Jabatan',
        'l.no_hp_atasan_langsung as No_HP',
        'l.email_atasan_langsung as Email',
        'a.nama as Nama_Alumni',
        'ps.program_studi as Program_Studi',
        'l.tahun_lulus as Tahun_Lulus'
    )
    ->whereNull('l.tgl_pertama_kerja')  // kondisi "belum isi tracer study"
    ->orderBy('a.nama')
    ->get();

    return $rekapLulusanBelumIsiTracer;
    }
}
