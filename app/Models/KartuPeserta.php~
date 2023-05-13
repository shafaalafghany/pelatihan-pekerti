<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_dosen
 * @property integer $id_pelatihan
 * @property string $berkas_kartu_peserta
 * @property string $created_at
 * @property string $updated_at
 * @property Pelatihan $pelatihan
 * @property Dosen $dosen
 */
class KartuPeserta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'kartu_peserta';

    /**
     * @var array
     */
    protected $fillable = ['id_dosen', 'id_pelatihan', 'berkas_kartu_peserta', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelatihan()
    {
        return $this->belongsTo('App\Models\Pelatihan', 'id_pelatihan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen()
    {
        return $this->belongsTo('App\Models\Dosen', 'id_dosen');
    }
}
