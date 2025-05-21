<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class LaporanBelumTS implements FromCollection, WithHeadings
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
    $alumniBelumIsi = DB::table('alumni as a')
        ->join('program_studi as ps', 'a.program_studi_id', '=', 'ps.id')
        ->leftJoin('lulusan as l', 'a.id', '=', 'l.alumni_id')
        ->whereNull('l.alumni_id')
        ->when($this->startYear, function ($query) {
            return $query->whereYear('a.tanggal_lulus', '>=', $this->startYear);
        })
        ->when($this->endYear, function ($query) {
            return $query->whereYear('a.tanggal_lulus', '<=', $this->endYear);
        })
        ->when($this->prodi_id, function ($query) {
            return $query->where('a.program_studi_id', $this->prodi_id);
        })
        ->select(
            'ps.program_studi as program_studi',
            'a.nim',
            'a.nama',
            'a.tanggal_lulus'
        )
        ->orderBy('ps.program_studi')
        ->orderBy('a.nama')
        ->get();

    return $alumniBelumIsi;
    }

    public function headings(): array
    {
        return [
            'Program Studi',
            'NIM',
            'Nama',
            'Tanggal Lulus'
        ];
    }
}
