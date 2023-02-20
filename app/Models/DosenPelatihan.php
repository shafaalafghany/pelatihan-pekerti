<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id_dosen
 * @property integer $id_pelatihan
 * @property string $created_at
 * @property string $updated_at
 * @property Dosen $dosen
 * @property Pelatihan $pelatihan
 */
class DosenPelatihan extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dosen_pelatihan';

    /**
     * @var array
     */
    protected $fillable = ['id_dosen', 'id_pelatihan', 'created_at', 'updated_at'];

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
