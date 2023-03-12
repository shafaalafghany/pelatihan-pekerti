<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_dosen
 * @property integer $id_pelatihan
 * @property string $berkas_sertifikat
 * @property string $created_at
 * @property string $updated_at
 * @property Dosen $dosen
 * @property Pelatihan $pelatihan
 */
class Sertifikat extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sertifikat';

    /**
     * @var array
     */
    protected $fillable = ['id_dosen', 'id_pelatihan', 'berkas_sertifikat', 'created_at', 'updated_at'];

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
