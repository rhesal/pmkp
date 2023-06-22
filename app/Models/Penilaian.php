<?php

namespace App\Models;

use App\Models\Master_indikator;
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
        'visitor',
    ];

    public function indikators()
    {
        return $this->belongsToMany(Master_indikator::class);
    }
}
