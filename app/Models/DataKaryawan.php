<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKaryawan extends Model
{
    protected $table = 'data_karyawan';
            
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_admin',
        'nama',
        'jenis_kelamin',
        'tanggal_masuk',
        'id_data_jabatan',
        'status'
    ];
}
