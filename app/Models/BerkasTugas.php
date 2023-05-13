<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_tugas
 * @property string $nama_berkas
 * @property string $created_at
 * @property string $updated_at
 * @property Tuga $tuga
 */
class BerkasTugas extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_tugas', 'nama_berkas', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tugas()
    {
        return $this->belongsTo('App\Models\Tugas', 'id_tugas');
    }
}
