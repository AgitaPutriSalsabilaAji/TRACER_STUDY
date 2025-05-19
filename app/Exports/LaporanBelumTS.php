<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class LaporanBelumTS implements FromCollection
{
    public function collection()
    {
    $alumniBelumIsi = DB::table('alumni as a')
    ->join('program_studi as ps', 'a.program_studi_id', '=', 'ps.id')
    ->leftJoin('lulusan as l', 'a.id', '=', 'l.alumni_id')
    ->whereNull('l.alumni_id')
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
}
