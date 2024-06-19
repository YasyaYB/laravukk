<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    use HasFactory;
    protected $table ='kategori';

    protected $fillable = [
        'deskripsi',
        'kategori',
    ];

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'kategori_id');
    }
}
