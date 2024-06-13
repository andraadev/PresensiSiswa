<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\Relations\HasOne;

class Siswa extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "siswa";

    public function kelas() : BelongsTo {
        return $this->belongsTo(Kelas::class);
    }

    public function absensi() {
        return $this->hasMany(Absensi::class);
    }
}
