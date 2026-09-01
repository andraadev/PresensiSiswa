<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Counseling extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function student()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
