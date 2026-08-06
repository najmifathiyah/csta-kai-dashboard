<?php

namespace App\Imports;

use App\Models\Research;
use App\Models\Division;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ResearchImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $division = Division::firstOrCreate(
            ['nama_divisi' => trim($row['divisi'])],
            [
                'kode_divisi' => strtoupper(substr(trim($row['divisi']),0,3)),
                'deskripsi' => '-'
            ]
        );

        $category = Category::firstOrCreate(
            ['nama_kategori' => trim($row['kategori'])],
            [
                'kode_kategori' => strtoupper(substr(trim($row['kategori']),0,3))
            ]
        );

        return new Research([
            'kode_research'      => $row['kode_research'],
            'judul'              => $row['judul'],
            'division_id'        => $division->id,
            'category_id'        => $category->id,
            'penanggung_jawab'   => $row['penanggung_jawab'],
            'tahun'              => $row['tahun'],
            'tanggal_penelitian' => $row['tanggal_penelitian'],
            'status'             => $row['status'],
            'ringkasan'          => $row['ringkasan'],
        ]);
    }
}