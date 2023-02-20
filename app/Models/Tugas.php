<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_sesi
 * @property string $judul
 * @property integer $deskripsi
 * @property string $batas_pengumpulan
 * @property string $created_at
 * @property string $updated_at
 * @property Sesi $sesi
 * @property TugasDosen[] $tugasDosens
 */
class Tugas extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_sesi', 'judul', 'deskripsi', 'batas_pengumpulan', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sesi()
    {
        return $this->belongsTo('App\Models\Sesi', 'id_sesi');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tugasDosens()
    {
        return $this->hasMany('App\Models\TugasDosen', 'id_tugas');
    }
}
