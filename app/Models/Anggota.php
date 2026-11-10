<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggotas';

    protected $fillable = ['nama', 'email', 'no_telepon'];

    public $timestamps = false;

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }
        public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}