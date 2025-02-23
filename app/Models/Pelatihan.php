<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $nama
 * @property string $jenis_pelatihan
 * @property string $mulai_pendaftaran
 * @property string $batas_pendaftaran
 * @property string $tanggal_pelaksanaan
 * @property integer $kuota_pendaftar
 * @property integer $jumlah_pendaftar
 * @property string $tautan_sertifikat
 * @property boolean $is_active
 * @property string $created_at
 * @property string $updated_at
 * @property Dosen[] $dosens
 * @property DosenPelatihan[] $dosenPelatihans
 * @property KartuPesertum[] $kartuPesertas
 * @property Nilai[] $nilais
 * @property Presensi[] $presensis
 * @property Sertifikat[] $sertifikats
 * @property Sesi[] $sesis
 * @property Tugas[] $tugas
 */
class Pelatihan extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'pelatihan';

    /**
     * @var array
     */
    protected $fillable = ['nama', 'jenis_pelatihan', 'mulai_pendaftaran', 'batas_pendaftaran', 'tanggal_pelaksanaan', 'kuota_pendaftar', 'jumlah_pendaftar', 'tautan_sertifikat', 'is_active', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dosens()
    {
        return $this->hasMany('App\Models\Dosen', 'id_pelatihan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dosenPelatihans()
    {
        return $this->hasMany('App\Models\DosenPelatihan', 'id_pelatihan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kartuPesertas()
    {
        return $this->hasMany('App\Models\KartuPesertum', 'id_pelatihan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nilais()
    {
        return $this->hasMany('App\Models\Nilai', 'id_pelatihan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function presensis()
    {
        return $this->hasMany('App\Models\Presensi', 'id_pelatihan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sertifikats()
    {
        return $this->hasMany('App\Models\Sertifikat', 'id_pelatihan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sesis()
    {
        return $this->hasMany('App\Models\Sesi', 'id_pelatihan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tugas()
    {
        return $this->hasMany('App\Models\Tugas', 'id_pelatihan');
    }
}
