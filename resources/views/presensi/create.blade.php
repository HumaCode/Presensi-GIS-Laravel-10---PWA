@extends('layouts.presensi')

@push('css')
    <style>
        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 15px;
        }
    </style>
@endpush

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-info text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">{{ config('app.name') }}</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <div class="row" style="margin-top: 70px;">
        <div class="col">
            <input type="hidden" id="lokasi">
            <div class="webcam-capture"></div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <button id="takeabsen" class="btn btn-info btn-block">
                <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                Presensi Masuk</button>
        </div>
    </div>
@endsection


@push('myscripts')
    <script>
        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jpeg',
            jpeg_quality: 80,
        });

        Webcam.attach('.webcam-capture');

        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        // menampilkan lokasi
        function successCallback(position) {
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;
        }

        function errorCallback() {

        }
    </script>
@endpush