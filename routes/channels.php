<?php

use App\Models\Riwayat;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Broadcast;
Broadcast::routes(['middleware' => ['web', 'auth:web,lawyer']]);

Broadcast::channel('chatroom.{id}', function ($user, $id) {
     $riwayat = Riwayat::find($id);

    // 2. If the chatroom doesn't exist, deny access.
    if (!$riwayat) {
        return false;
    }

    // 3. Get the unique identifier (NIK) from the user model.
    //    This works for both regular users and lawyers.
    $currentUserNik = $user->nik_pengguna ?? $user->nik_pengacara;

    // 4. Grant access only if the user's NIK matches one of the
    //    participants listed in the riwayat record.
    return $currentUserNik === $riwayat->nik_pengguna || $currentUserNik === $riwayat->nik_pengacara;
});

Broadcast::channel('callroom.{id}', function ($user, $id) {
    $riwayat = Riwayat::find($id);

    if (!$riwayat) {
        return false;
    }

    $currentUserNik = $user->nik_pengguna ?? $user->nik_pengacara;

    return $currentUserNik === $riwayat->nik_pengguna || $currentUserNik === $riwayat->nik_pengacara;
});

Broadcast::channel('pengacara.{nik_pengacara}', function ($lawyer, $nik_pengacara) {
    return $lawyer->nik_pengacara === $nik_pengacara;
}, ['guards' => ['lawyer']]);
