<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "guru";

    protected $primaryKey = "id";

    public function kelas()
    {
        return $this->hasOne(Kelas::class);
    }

}
