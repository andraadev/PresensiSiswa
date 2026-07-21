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

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function getPersenHadirAttribute()
    {
        $totalPertemuan = $this->total_hadir + $this->total_sakit + $this->total_izin + $this->total_alpa;

        if ($totalPertemuan == 0) {
            return 0;
        }

        return round(($this->total_hadir / $totalPertemuan) * 100, 1);
    }
}
