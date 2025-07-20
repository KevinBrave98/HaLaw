@push('css')
    <link rel="stylesheet" href="{{ asset('assets/styles/konsultasi.css') }}">
@endpush
<x-layout_user :title="'Halaw - Metode Pembayaran'">
<div class="d-flex border-bottom mb-3 w-100" style="height: 80px">
  <a href="" 
     class="tab d-flex align-items-center justify-content-center flex-fill text-white text-decoration-none selected" 
     style="font-weight: bold; font-size: 25px;">
    Sedang Berlangsung
  </a>
  <a href="" 
     class="tab d-flex align-items-center justify-content-center flex-fill text-white text-decoration-none" 
     style="font-weight: bold; font-size: 25px; background-color: #3c2a1a;">
    Riwayat Konsultasi
  </a>
</div>
<div class="container mt-4" style="padding: 20px">
    @foreach($riwayats as $riwayat)
    <div class="card shadow-sm mb-3" style="border: 1px solid #B99010; background-color: #fdf5ee;">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <img src="{{ asset($riwayat->foto_pengacara) }}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd;">
                <div class="ms-3">
                    <h5 class="mb-0">{{ $riwayat->nama_pengacara }}</h5>
                    <small class="text-muted">Lorem ipsum dolor sit amet.</small>
                </div>
            </div>
            <div class="d-flex gap-3">
                @if ($riwayat->chat)
                    <a href="#" class="text-brown fs-4"><i class="bi bi-chat-left-text-fill"></i></a>
                @else
                    <span class="fs-4 icon-disabled">
                        <i class="bi bi-chat-left-text-fill" style="text-decoration: line-through;"></i>
                    </span>
                @endif

                {{-- Voice Chat --}}
                @if ($riwayat->voice_chat)
                    <a href="#" class="text-brown fs-4"><i class="bi bi-telephone-fill"></i></a>
                @else
                    <span class="fs-4 icon-disabled">
                        <i class="bi bi-telephone-fill" style="text-decoration: line-through;"></i>
                    </span>
                @endif

                {{-- Video Call --}}
                @if ($riwayat->video_call)
                    <a href="#" class="text-brown fs-4"><i class="bi bi-camera-video-fill"></i></a>
                @else
                    <span class="fs-4 icon-disabled">
                        <i class="bi bi-camera-video-fill" style="text-decoration: line-through;"></i>
                    </span>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
</x-layout_user>