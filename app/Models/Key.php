<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    use HasFactory;

    protected $fillable = ['alumni_id','lulusan_id', 'key_value', 'is_active'];

    // Relasi ke alumni
    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
