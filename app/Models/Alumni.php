<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumni extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'alumni';

    protected $fillable = [
        'program_studi_id',
        'nama',
        'nim',
        'tanggal_lulus',
    ];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function surveiKepuasan()
    {
        return $this->hasMany(SurveiKepuasan::class);
    }

    public function lulusan()
    {
        return $this->hasOne(Lulusan::class);
    }

    public function alumni()
    {
        return $this->hasMany(Alumni::class, 'program_studi_id');
    }
}
