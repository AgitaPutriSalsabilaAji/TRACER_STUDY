<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProfesi extends Model
{
    use HasFactory;

    protected $table = 'kategori_profesi';

    protected $fillable = [
        'kategori_profesi',
    ];

    public function profesi()
    {
        return $this->hasMany(Profesi::class);
    }
}
