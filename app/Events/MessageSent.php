<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use App\Models\Pesan;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Pesan $pesan;
    public string $receiverNik;
    public string $senderNik;
    public string $riwayatPengacara;
    public string $riwayatPengguna;

    /**
     * Create a new event instance.
     */
    public function __construct(Pesan $pesan)
    {
        $this->pesan = $pesan;

        // resolve only needed fields here
        $riwayat = $pesan->riwayat()->select('nik_pengacara', 'nik_pengguna')->first();

        $this->senderNik = $pesan->nik;
        $this->receiverNik = $this->senderNik == $riwayat->nik_pengacara
            ? $riwayat->nik_pengguna
            : $riwayat->nik_pengacara;

        // store them for broadcastWith
        // $this->riwayatPengacara = $riwayat->nik_pengacara;
        // $this->riwayatPengguna  = $riwayat->nik_pengguna;
    }

    /**
     * Channels to broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("chatroom.{$this->pesan->id_riwayat}")
        ];
    }

    /**
     * Data sent to the frontend.
     */
    public function broadcastWith(): array
    {
        $riwayat = $this->pesan->riwayat;
        return [
            'pesan' => [
                'id_pesan' => $this->pesan->id,
                'teks' => $this->pesan->teks,
                'nik' => $this->pesan->nik,
                'created_at' => $this->pesan->created_at->format('d-m-Y H:i:s'),
                'pengacara_name' => optional($riwayat->pengacara)->nama_pengacara,
                'pengguna_name' => optional($riwayat->pengguna)->nama_pengguna,
                'nik_pengacara' => $riwayat->nik_pengacara,
                'nik_pengguna' => $riwayat->nik_pengguna,
            ],
        ];
    }
}
