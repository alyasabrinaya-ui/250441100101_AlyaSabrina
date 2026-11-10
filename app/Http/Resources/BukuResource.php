<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BukuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'id_kategori' => $this->kategori_id,             
            'kategori'    => $this->kategori->nama ?? '-',   
            'judul'       => $this->judul,                   
            'penulis'     => $this->penulis,                 
            'tahun'       => (int) $this->tahun_terbit,      
        ];
    }
}