<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_dosen
 * @property string $invoice
 * @property string $created_at
 * @property string $updated_at
 * @property Dosen $dosen
 */
class Pembayaran extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pembayaran';

    /**
     * @var array
     */
    protected $fillable = ['id_dosen', 'invoice', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen()
    {
        return $this->belongsTo('App\Models\Dosen', 'id_dosen');
    }
}
