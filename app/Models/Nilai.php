<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_pelatihan
 * @property string $nama_nilai
 * @property string $created_at
 * @property string $updated_at
 * @property DetailNilai[] $detailNilais
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
    protected $fillable = ['id_pelatihan', 'nama_nilai', 'created_at', 'updated_at'];

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
    public function pelatihan()
    {
        return $this->belongsTo('App\Models\Pelatihan', 'id_pelatihan');
    }
}
