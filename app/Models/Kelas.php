<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
        'slug_kelas',
        'guru_id',
        'qr_code',
    ];

    protected $table = "kelas";

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
