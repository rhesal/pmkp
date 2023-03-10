<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'nilai_mutu';

    protected $fillable = [
        'indikator_id',
        'tanggal',
        'numerator',
        'denumerator',
        'hasil',
    ];

    public function indikatorMutu()
    {
        return $this->belongsTo(Master_indikator::class);
    }
}
