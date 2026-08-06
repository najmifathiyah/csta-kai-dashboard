<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Research;

class Category extends Model
{
    protected $fillable = [
        'kode_kategori',
        'nama_kategori'
    ];

    public function researchs()
    {
        return $this->hasMany(Research::class);
    }
}