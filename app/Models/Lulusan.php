<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lulusan extends Model
{
    use HasFactory;

    protected $table = 'lulusan';

    protected $fillable = [
        'alumni_id',
        'profesi_id',
        'jenis_instansi_id',
        'tahun_lulus',
        'no_hp',
        'email',
        'tgl_pertama_kerja',
        'tgl_mulai_kerja_instansi',
        'nama_instansi',
        'skala',
        'lokasi_instansi',
        'nama_atasan_langsung',
        'jabatan_atasan_langsung',
        'no_hp_atasan_langsung',
        'email_atasan_langsung',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }

    public function profesi()
    {
        return $this->belongsTo(Profesi::class);
    }

    public function jenisInstansi()
    {
        return $this->belongsTo(JenisInstansi::class);
    }
}
