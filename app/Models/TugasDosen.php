<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_tugas
 * @property integer $id_dosen
 * @property string $file
 * @property string $created_at
 * @property string $updated_at
 * @property Dosen $dosen
 * @property Tuga $tuga
 */
class TugasDosen extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tugas_dosen';

    /**
     * @var array
     */
    protected $fillable = ['id_tugas', 'id_dosen', 'file', 'created_at', 'updated_at'];

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
    public function tuga()
    {
        return $this->belongsTo('App\Models\Tuga', 'id_tugas');
    }
}
