<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail as AuthMustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $fullname
 * @property boolean $is_active
 * @property string $token_verification
 * @property string $token_expired
 * @property string $gelar_depan
 * @property string $gelar_belakang
 * @property string $berkas_ktp
 * @property string $berkas_sk_dosen
 * @property string $berkas_kartu_peserta
 * @property string $created_at
 * @property string $updated_at
 * @property DosenPelatihan[] $dosenPelatihans
 * @property DosenPresensi[] $dosenPresensis
 * @property Nilai[] $nilais
 * @property Pembayaran[] $pembayarans
 * @property Sertifikat[] $sertifikats
 * @property TugasDosen[] $tugasDosens
 */
class User extends AuthenticableUser implements MustVerifyEmail
{
    
    use AuthMustVerifyEmail, Notifiable;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dosen';

    /**
     * @var array
     */
    protected $fillable = ['email', 'password', 'fullname', 'email_verified_at', 'token_verification', 'token_expired', 'gelar_depan', 'gelar_belakang', 'berkas_ktp', 'berkas_sk_dosen', 'berkas_kartu_peserta', 'created_at', 'updated_at'];

    protected $hidden = ['password'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dosenPelatihans()
    {
        return $this->hasMany('App\Models\DosenPelatihan', 'id_dosen');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dosenPresensis()
    {
        return $this->hasMany('App\Models\DosenPresensi', 'id_dosen');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nilais()
    {
        return $this->hasMany('App\Models\Nilai', 'id_dosen');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayarans()
    {
        return $this->hasMany('App\Models\Pembayaran', 'id_dosen');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sertifikats()
    {
        return $this->hasMany('App\Models\Sertifikat', 'id_dosen');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tugasDosens()
    {
        return $this->hasMany('App\Models\TugasDosen', 'id_dosen');
    }
}
