<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataAbsensi extends Model
{
        
    protected $table = 'data_absensi';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'status_kehadiran',
        'id_admin',
        'id_data_karyawan',
    ];
}
