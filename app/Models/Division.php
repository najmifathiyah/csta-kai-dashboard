<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Research;

class Division extends Model
{
    protected $fillable = [
        'kode_divisi',
        'nama_divisi',
        'deskripsi'
    ];

    public function researchs()
    {
        return $this->hasMany(Research::class);
    }
}