<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_nilai
 * @property integer $id_tugas
 * @property string $nama_nilai
 * @property integer $nilai
 * @property Nilai $nilai
 * @property Tuga $tuga
 */
class DetailNilai extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'detail_nilai';

    /**
     * @var array
     */
    protected $fillable = ['id_nilai', 'id_tugas', 'nama_nilai', 'nilai'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nilai()
    {
        return $this->belongsTo('App\Models\Nilai', 'id_nilai');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tugas()
    {
        return $this->belongsTo('App\Models\Tugas', 'id_tugas');
    }
}
