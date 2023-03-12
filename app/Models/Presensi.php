<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_pelatihan
 * @property integer $id_sesi
 * @property string $kode_presensi
 * @property string $batas_presensi
 * @property string $created_at
 * @property string $updated_at
 * @property Sesi $sesi
 * @property Pelatihan $pelatihan
 */
class Presensi extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'presensi';

    /**
     * @var array
     */
    protected $fillable = ['id_pelatihan', 'id_sesi', 'kode_presensi', 'batas_presensi', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sesi()
    {
        return $this->belongsTo('App\Models\Sesi', 'id_sesi');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelatihan()
    {
        return $this->belongsTo('App\Models\Pelatihan', 'id_pelatihan');
    }
}
