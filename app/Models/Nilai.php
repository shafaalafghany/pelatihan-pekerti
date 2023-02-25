<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_dosen
 * @property integer $id_pelatihan
 * @property DetailNilai[] $detailNilais
 * @property Dosen $dosen
 * @property Pelatihan $pelatihan
 */
class Nilai extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'nilai';

    /**
     * @var array
     */
    protected $fillable = ['id_dosen', 'id_pelatihan'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detailNilais()
    {
        return $this->hasMany('App\Models\DetailNilai', 'id_nilai');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen()
    {
        return $this->belongsTo('App\Models\Dosen', 'id_dosen');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelatihan()
    {
        return $this->belongsTo('App\Models\Pelatihan', 'id_pelatihan');
    }
}
