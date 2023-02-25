<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $fullname
 * @property boolean $is_active
 * @property string $token_verification
 * @property string $gelar_depan
 * @property string $gelar_belakang
 * @property string $ktp
 * @property string $sk_dosen
 * @property string $created_at
 * @property string $updated_at
 * @property Sesi[] $sesis
 * @property Pembayaran[] $pembayarans
 * @property TugasDosen[] $tugasDosens
 */
class User extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dosen';

    /**
     * @var array
     */
    protected $fillable = ['email', 'password', 'fullname', 'is_active', 'token_verification', 'gelar_depan', 'gelar_belakang', 'ktp', 'sk_dosen', 'created_at', 'updated_at'];

    protected $hidden = ['password'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sesis()
    {
        return $this->belongsToMany('App\Models\Sesi', 'dosen_presensi', 'id_user', 'id_sesi');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayarans()
    {
        return $this->hasMany('App\Models\Pembayaran', 'id_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tugasDosens()
    {
        return $this->hasMany('App\Models\TugasDosen', 'id_user');
    }
}
