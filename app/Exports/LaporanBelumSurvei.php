<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class LaporanBelumSurvei implements FromCollection, WithHeadings
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
    $data = DB::table('lulusan as l')
    ->join('alumni as a', 'l.alumni_id', '=', 'a.id')
    ->join('program_studi as ps', 'a.program_studi_id', '=', 'ps.id')
    ->leftJoin('survei_kepuasan as sk', 'sk.alumni_id', '=', 'a.id') // join ke survei_kepuasan
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
    ->whereNull('sk.alumni_id') // kondisi "belum isi survei kepuasan"
    ->when($this->startYear, function ($query) {
        return $query->where('l.tahun_lulus', '>=', $this->startYear);
    })
    ->when($this->endYear, function ($query) {
        return $query->where('l.tahun_lulus', '<=', $this->endYear);
    })
    ->when($this->prodi_id, function ($query) {
        return $query->where('a.program_studi_id', $this->prodi_id);
    })
    ->orderBy('a.nama')
    ->get();


    return $data;
    }

    public function headings(): array
    {
        return [
            'Nama Atasan Langsung',
            'Instansi',
            'Jabatan',
            'No HP',
            'Email',
            'Nama Alumni',
            'Program Studi',
            'Tahun Lulus',
        ];
    }
}
