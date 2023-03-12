<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_pelatihan
 * @property string $nama
 * @property string $keterangan
 * @property string $tanggal
 * @property string $created_at
 * @property string $updated_at
 * @property DosenPresensi[] $dosenPresensis
 * @property Presensi[] $presensis
 * @property Pelatihan $pelatihan
 * @property Tuga[] $tugas
 */
class Sesi extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sesi';

    /**
     * @var array
     */
    protected $fillable = ['id_pelatihan', 'nama', 'keterangan', 'tanggal', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dosenPresensis()
    {
        return $this->hasMany('App\Models\DosenPresensi', 'id_sesi');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function presensis()
    {
        return $this->hasMany('App\Models\Presensi', 'id_sesi');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelatihan()
    {
        return $this->belongsTo('App\Models\Pelatihan', 'id_pelatihan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tugas()
    {
        return $this->hasMany('App\Models\Tugas', 'id_sesi');
    }
}
