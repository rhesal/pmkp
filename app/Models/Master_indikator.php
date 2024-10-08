<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master_indikator extends Model
{
    use HasFactory;

    protected $table = 'master_indikator_mutu';

    protected $fillable = [
        'indikator',
        'unit_id',
        'kategori',
        'nilai_standar',
        'satuan_pengukuran',
        'numerator',
        'denumerator',
        'penanggung_jawab',
        'status'
    ];

    public function unit()
    {
        return $this->belongsTo(Master_unit::class);
    }

    public function nilai_mutu()
    {
        return $this->belongsToMany(Penilaian::class,'indikator_id');
    }
}
