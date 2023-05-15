<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\MustVerifyEmail as AuthMustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

/**
 * @property integer $id
 * @property integer $id_pelatihan
 * @property string $email
 * @property string $password
 * @property string $fullname
 * @property string $token_verification
 * @property string $email_verified_at
 * @property string $nik
 * @property string $nidn_nidk
 * @property string $gelar_depan
 * @property string $gelar_belakang
 * @property string $jenis_kelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string nama_instansi
 * @property string $alamat
 * @property string $provinsi
 * @property string $kota
 * @property string $kode_pos
 * @property string $telepon
 * @property string $foto_profil
 * @property string $berkas_ktp
 * @property string $berkas_sk_dosen
 * @property string $berkas_sk_pekerti
 * @property boolean $is_ktp_validated
 * @property boolean $is_sk_dosen_validated
 * @property boolean $is_sk_pekerti_validated
 * @property boolean $is_berkas_submited
 * @property string $created_at
 * @property string $updated_at
 * @property Pelatihan $pelatihan
 * @property DosenPelatihan[] $dosenPelatihans
 * @property DosenPresensi[] $dosenPresensis
 * @property KartuPesertum[] $kartuPesertas
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
    protected $fillable = ['id_pelatihan', 'email', 'password', 'fullname', 'token_verification', 'email_verified_at', 'nik', 'nidn_nidk', 'gelar_depan', 'gelar_belakang', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'nama_instansi', 'alamat', 'provinsi', 'kota', 'kode_pos', 'telepon', 'foto_profil', 'berkas_ktp', 'berkas_sk_dosen', 'berkas_sk_pekerti', 'is_ktp_validated', 'is_sk_dosen_validated', 'is_sk_pekerti_validated', 'is_berkas_submited', 'created_at', 'updated_at'];

    protected $hidden = ['password'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelatihan()
    {
        return $this->belongsTo('App\Models\Pelatihan', 'id_pelatihan');
    }

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
    public function kartuPesertas()
    {
        return $this->hasMany('App\Models\KartuPesertum', 'id_dosen');
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
