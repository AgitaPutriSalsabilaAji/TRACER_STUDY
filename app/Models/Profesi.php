<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesi extends Model
{
    use HasFactory;

    protected $table = 'profesi';

    protected $fillable = [
        'kategori_profesi_id',
        'nama_profesi',
    ];

    public function kategoriProfesi()
    {
        return $this->belongsTo(KategoriProfesi::class);
    }

    public function lulusan()
    {
        return $this->hasMany(Lulusan::class);
    }
}
