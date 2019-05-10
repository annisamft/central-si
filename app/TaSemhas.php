<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaSemhas extends Model
{
    protected $table = 'ta_semhas';
    protected $guarded = [];

    // Tambahkan Kode yang diperlukan dibawah ini
    public function ruangans()
    {
        return $this->hasOne(Ruangan::class);
    }
    
    public function sempros()
    {
        return $this->hasOne(TaSempro::class);
    }
}
