<?php

namespace App\Exports;

use App\Models\Survei;
use App\Models\SurveiKepuasan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class LaporanSurveiExport implements FromCollection, WithHeadings
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
        $data =  DB::table('alumni as a')
            ->join('program_studi as ps', 'a.program_studi_id', '=', 'ps.id')
            ->join('lulusan as l', 'a.id', '=', 'l.alumni_id')
            ->leftJoin('jenis_instansi as ji', 'l.jenis_instansi_id', '=', 'ji.id')
            ->leftJoin('profesi as p', 'l.profesi_id', '=', 'p.id')
            ->leftJoin('kategori_profesi as kp', 'p.kategori_profesi_id', '=', 'kp.id')
            ->select([
                'ps.program_studi as Program_Studi',
                'a.nim as NIM',
                'a.nama as Nama',
                'l.no_hp as No_HP',
                'l.email as Email',
                'a.tanggal_lulus as Tanggal_Lulus',
                'l.tahun_lulus as Tahun_Lulus',
                'l.tgl_pertama_kerja as Tanggal_Pertama_Kerja',
                DB::raw('DATEDIFF(l.tgl_pertama_kerja, a.tanggal_lulus) as Masa_Tunggu_hari'),
                'l.tgl_mulai_kerja_instansi as Tgl_Mulai_Kerja_Instansi',
                'ji.jenis_instansi as Jenis_Instansi',
                'l.nama_instansi as Nama_Instansi',
                'l.skala as Skala',
                'l.lokasi_instansi as Lokasi_Instansi',
                'kp.kategori_profesi as Kategori_Profesi',
                'p.nama_profesi as Profesi',
                'l.nama_atasan_langsung as Nama_Atasan_Langsung',
                'l.jabatan_atasan_langsung as Jabatan_Atasan_Langsung',
                'l.no_hp_atasan_langsung as No_HP_Atasan_Langsung',
                'l.email_atasan_langsung as Email_Atasan_Langsung',
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
            'Program Studi',
            'NIM',
            'Nama',
            'No HP',
            'Email',
            'Tanggal Lulus',
            'Tahun Lulus',
            'Tanggal Pertama Kerja',
            'Masa Tunggu (hari)',
            'Tgl Mulai Kerja Instansi Saat Ini',
            'Jenis Instansi',
            'Nama Instansi',
            'Skala',
            'Lokasi Instansi',
            'Kategori Profesi',
            'Profesi',
            'Nama Atasan Langsung',
            'Jabatan Atasan Langsung',
            'No HP Atasan Langsung',
            'Email Atasan Langsung',
        ];
    }
}

// QUERY REKAP 1
/* SELECT 
    ps.program_studi AS `Program Studi`,
    a.nim AS `NIM`,
    a.nama AS `Nama`,
    l.no_hp AS `No.HP`,
    l.email AS `Email`,
    a.tanggal_lulus AS `Tanggal Lulus`,
    l.tahun_lulus AS `Tahun Lulus`,
    l.tgl_pertama_kerja AS `Tanggal Pertama Kerja`,
    DATEDIFF(l.tgl_pertama_kerja, a.tanggal_lulus) AS `Masa Tunggu (hari)`,
    l.tgl_mulai_kerja_instansi AS `Tgl Mulai Kerja Instansi Saat Ini`,
    ji.jenis_instansi AS `Jenis Instansi`,
    l.nama_instansi AS `Nama Instansi`,
    l.skala AS `Skala`,
    l.lokasi_instansi AS `Lokasi Instansi`,
    kp.kategori_profesi AS `Kategori Profesi`,
    p.nama_profesi AS `Profesi`,
    l.alamat_kantor AS `Alamat Kantor`, -- Jika kolom ini ada
    l.nama_atasan_langsung AS `Nama Atasan Langsung`,
    l.jabatan_atasan_langsung AS `Jabatan Atasan Langsung`,
    l.no_hp_atasan_langsung AS `No HP Atasan Langsung`,
    l.email_atasan_langsung AS `Email Atasan Langsung`
FROM alumni a
JOIN program_studi ps ON a.program_studi_id = ps.id
JOIN lulusan l ON a.id = l.alumni_id
LEFT JOIN jenis_instansi ji ON l.jenis_instansi_id = ji.id
LEFT JOIN profesi p ON l.profesi_id = p.id
LEFT JOIN kategori_profesi kp ON p.kategori_profesi_id = kp.id;
*/

// QUERY REKAP 2
/* SELECT
	sk.nama_surveyor AS 'Nama',
    sk.instansi AS `Instansi`,
    sk.jabatan AS `Jabatan`,
    sk.email AS `Email`,
    a.nama AS `Nama Alumni`,
    ps.program_studi AS `Program Studi`,
    YEAR(l.tahun_lulus) AS `Tahun Lulus`,
    
    sk.kerjasama_tim AS `Kerjasama Tim`,
    sk.keahlian_di_bidang_ti AS `Keahlian di bidang TI`,
    sk.kemampuan_bahasa_asing AS `Kemampuan berbahasa asing`,
    sk.kemampuan_komunikasi AS `Kemampuan berkomunikasi`,
    sk.pengembangan_diri AS `Pengembangan diri`,
    sk.kepemimpinan AS `Kepemimpinan`,
    sk.etos_kerja AS `Etos Kerja`,
    sk.kompetensi_belum_terpenuhi AS `Kompetensi yang dibutuhkan tapi belum dapat dipenuhi`,
    sk.saran_kurikulum AS `Saran untuk kurikulum program studi`

FROM survei_kepuasan sk
JOIN alumni a ON sk.alumni_id = a.id
LEFT JOIN program_studi ps ON a.program_studi_id = ps.id
LEFT JOIN lulusan l ON l.alumni_id = a.id;
*/

// QUERY REKAP ALUMNI BELUM TS
/*SELECT 
  ps.program_studi AS `Program Studi`,
  a.nim AS NIM,
  a.nama AS Nama,
  a.tanggal_lulus AS `Tanggal Lulus`
FROM alumni a
JOIN program_studi ps ON a.program_studi_id = ps.id
LEFT JOIN lulusan l ON a.id = l.alumni_id
WHERE l.alumni_id IS NULL
ORDER BY ps.program_studi, a.nama;
*/


// QUERY REKAP ATASAN BELUM TS
/* SELECT
  l.nama_atasan_langsung AS Nama,
  l.nama_instansi AS Instansi,
  l.jabatan_atasan_langsung AS Jabatan,
  l.no_hp_atasan_langsung AS `No HP`,
  l.email_atasan_langsung AS Email,
  a.nama AS `Nama Alumni`,
  ps.program_studi AS `Program Studi`,
  l.tahun_lulus AS `Tahun Lulus`
FROM lulusan l
JOIN alumni a ON l.alumni_id = a.id
JOIN program_studi ps ON a.program_studi_id = ps.id
WHERE l.tgl_pertama_kerja IS NULL
ORDER BY a.nama;
*/
