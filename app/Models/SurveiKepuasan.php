<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveiKepuasan extends Model
{
    use HasFactory;

    protected $table = 'survei_kepuasan';

    protected $fillable = [
        'alumni_id',
        'nama_surveyor',
        'instansi',
        'jabatan',
        'email',
        'ketjasama_tim',
        'keahlian_u',
        'kemampuan_bahasa_asing',
        'kemampuan_komunikasi',
        'pengembangan_diri',
        'kepemimpinan',
        'etos_kerja',
        'kompetensi_belum_terpenuhi',
        'saran_kurikulum',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
