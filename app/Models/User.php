<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = "user";

    protected $fillable = ['guru_id', 'nama_lengkap', 'username', 'password', 'role', 'is_active'];

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
