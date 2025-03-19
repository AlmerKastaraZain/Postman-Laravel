<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataJabatan extends Model
{
    protected $table = 'data_jabatan';

            
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'jabatan',
        'gaji_pokok',
        'tunjangan',
        'total',
        'id_admin',
    ];
}
