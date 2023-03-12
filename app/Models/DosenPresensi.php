<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_dosen
 * @property integer $id_sesi
 * @property string $created_at
 * @property string $updated_at
 * @property Sesi $sesi
 * @property Dosen $dosen
 */
class DosenPresensi extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dosen_presensi';

    /**
     * @var array
     */
    protected $fillable = ['id_dosen', 'id_sesi', 'created_at', 'updated_at'];

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
    public function dosen()
    {
        return $this->belongsTo('App\Models\Dosen', 'id_dosen');
    }
}
