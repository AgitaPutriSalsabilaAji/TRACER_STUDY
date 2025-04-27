<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';

    protected $fillable = [
        'program_studi_id',
        'nama',
        'nim',
        'tanggal_lulus',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function surveiKepuasan()
    {
        return $this->hasMany(SurveiKepuasan::class);
    }

    public function lulusan()
    {
        return $this->hasOne(Lulusan::class);
    }
}
