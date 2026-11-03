@php
    $inputId        = 'input_' . $name;
    $previewId      = 'preview_' . $name;
    $previewWrapId  = 'preview_wrap_' . $name;
    $overlayId      = 'cam_overlay_' . $name;
    $videoId        = 'cam_video_' . $name;
    $canvasId       = 'cam_canvas_' . $name;
    $errorId        = 'cam_error_' . $name;
    $errMsgId       = 'cam_error_msg_' . $name;
    $captureBtnId   = 'cam_capture_' . $name;
@endphp

<div class="mb-3">
    <label class="form-label">
        {{ $label }} @if($required)<span class="text-danger">*</span>@endif
    </label>

    <div id="{{ $previewWrapId }}" class="mb-2" style="display: {{ $existingFoto ? 'block' : 'none' }};">
        <img id="{{ $previewId }}"
             src="{{ $existingFoto ? $existingFoto : '' }}"
             class="img-fluid rounded-3 border zoomable"
             style="max-height: 280px;">
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <button type="button" class="btn btn-light btn-sm"
                onclick="document.getElementById('{{ $inputId }}').click()">
            <i class="bi bi-image me-1"></i> Pilih File
        </button>
        <button type="button" class="btn btn-primary btn-sm"
                onclick="LaporAja_openCamera('{{ $name }}')">
            <i class="bi bi-camera-fill me-1"></i> Buka Kamera
        </button>
    </div>

    <input type="file" name="{{ $name }}" id="{{ $inputId }}"
           accept="image/*" capture="environment"
           class="d-none"
           onchange="LaporAja_previewFile(event, '{{ $previewId }}', '{{ $previewWrapId }}')"
           @if($required && !$existingFoto) required @endif>

    <div class="form-text">Format JPG/PNG, maksimal 2MB.</div>
</div>

{{-- CAMERA OVERLAY --}}
<div id="{{ $overlayId }}" class="laporaja-cam-overlay">
    <div class="laporaja-cam-dialog">
        <div class="laporaja-cam-header">
            <h6 class="m-0 fw-bold" style="font-size:.9rem;">
                <i class="bi bi-camera-fill me-1"></i> Ambil Foto
            </h6>
            <button type="button" class="laporaja-cam-close"
                    onclick="LaporAja_closeCamera('{{ $name }}')">
                &times;
            </button>
        </div>

        <div class="laporaja-cam-body">
            <video id="{{ $videoId }}" autoplay playsinline muted></video>
            <div id="{{ $errorId }}" class="laporaja-cam-error">
                <i class="bi bi-camera-video-off"></i>
                <p id="{{ $errMsgId }}">Kamera tidak tersedia</p>
                <small>Gunakan tombol "Pilih File" sebagai alternatif.</small>
            </div>
            <canvas id="{{ $canvasId }}" class="d-none"></canvas>
        </div>

        <div class="laporaja-cam-footer">
            <button type="button" class="btn btn-light"
                    onclick="LaporAja_closeCamera('{{ $name }}')">
                <i class="bi bi-x-lg"></i> Batal
            </button>
            <button type="button" id="{{ $captureBtnId }}"
                    class="btn btn-primary"
                    onclick="LaporAja_capture('{{ $name }}')">
                <i class="bi bi-camera-fill me-1"></i> Ambil Foto
            </button>
        </div>
    </div>
</div>