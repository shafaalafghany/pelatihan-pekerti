<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_nilai
 * @property integer $id_dosen
 * @property integer $nilai
 * @property string $created_at
 * @property string $updated_at
 * @property Nilai $nilai
 * @property Dosen $dosen
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
    protected $fillable = ['id_nilai', 'id_dosen', 'nilai', 'created_at', 'updated_at'];

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
    public function dosen()
    {
        return $this->belongsTo('App\Models\Dosen', 'id_dosen');
    }
}
