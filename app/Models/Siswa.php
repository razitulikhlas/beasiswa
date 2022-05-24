<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Siswa extends Authenticatable
{
     use HasApiTokens, HasFactory, Notifiable;
    protected $table = "tbl_siswa";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
protected $fillable = [
        'nama',
        'nim',
        'nama_ayah',
        'tahun_masuk',
        'nama_ibu',
        'phone',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'id_jurusan',
        'agama',
        'alamat_asal',
        'alamat_sekarang',
        'email',
        'status_tmpt_tinggal',
        'sumber_biaya_sekolah',
        'nomor_kk',
        'image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];



    public function jurusan(){
        return $this->hasOne(Jurusan::class,'id','id_jurusan');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}


