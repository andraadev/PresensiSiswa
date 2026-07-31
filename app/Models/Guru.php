<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = ['nip', 'nama_lengkap', 'jenis_kelamin', 'no_telepon'];

    protected $table = "guru";

    protected $primaryKey = "id";

    public function kelas()
    {
        return $this->hasOne(Kelas::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
