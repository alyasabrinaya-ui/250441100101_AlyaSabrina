<?php

namespace App\Policies;

use App\Models\Anggota;
use App\Models\User;

class AnggotaPolicy
{
   
    public function viewRiwayat(User $user, Anggota $anggota): bool
    {
        return $user->id === $anggota->user_id
            || $user->can('kelola peminjaman');
    }
}