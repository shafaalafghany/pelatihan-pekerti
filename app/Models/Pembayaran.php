<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $id_dosen
 * @property integer $id_pelatihan
 * @property string $invoice
 * @property string $kode_pembayaran
 * @property boolean $status
 * @property string $snap_token
 * @property string $created_at
 * @property string $updated_at
 * @property Pelatihan $pelatihan
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
    protected $fillable = ['id_dosen', 'id_pelatihan', 'invoice', 'kode_pembayaran', 'status', 'snap_token', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelatihan()
    {
        return $this->belongsTo('App\Models\Pelatihan', 'id_pelatihan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen()
    {
        return $this->belongsTo('App\Models\Dosen', 'id_dosen');
    }
}
