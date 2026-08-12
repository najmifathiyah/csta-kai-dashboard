<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    protected $table = 'datasets';

    protected $fillable = [
        'nama_file',
        'layanan',
        'jumlah_data',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'jumlah_data' => 'integer',
    ];
}