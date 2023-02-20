<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $nama
 * @property string $mulai_pendaftaran
 * @property string $batas_pendaftaran
 * @property integer $kuota_pendaftar
 * @property integer $jumlah_pendaftar
 * @property string $created_at
 * @property string $updated_at
 * @property DosenPelatihan[] $dosenPelatihans
 * @property Presensi[] $presensis
 * @property Sesi[] $sesis
 */
class Pelatihan extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pelatihan';

    /**
     * @var array
     */
    protected $fillable = ['nama', 'mulai_pendaftaran', 'batas_pendaftaran', 'kuota_pendaftar', 'jumlah_pendaftar', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dosenPelatihans()
    {
        return $this->hasMany('App\Models\DosenPelatihan', 'id_pelatihan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function presensis()
    {
        return $this->hasMany('App\Models\Presensi', 'id_pelatihan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sesis()
    {
        return $this->hasMany('App\Models\Sesi', 'id_pelatihan');
    }
}
