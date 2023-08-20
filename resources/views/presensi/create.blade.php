@extends('layouts.presensi')

@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    {{-- sweetalert --}}
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <style>
        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 15px;
        }

        #map {
            height: 200px;
        }

        #takeabsen.loading {
            position: relative;
        }

        #takeabsen.loading .spinner-grow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
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
    {{-- latidute & lobfitude --}}
    <div class="row" style="margin-top: 70px;">
        <div class="col">
            <input type="hidden" id="lokasi">
            <div class="webcam-capture"></div>
        </div>
    </div>

    {{-- kamera webcam --}}
    <div class="row">
        <div class="col">
            @if ($cek > 0)
                <button id="takeabsen" class="btn btn-danger btn-block">
                    <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                    Presensi Pulang
                </button>
            @else
                <button id="takeabsen" class="btn btn-info btn-block">
                    <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                    Presensi Masuk
                </button>
            @endif
        </div>
    </div>

    {{-- tampilan peta --}}
    <div class="row mt-2">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>

    {{-- audio notifikasi --}}
    <audio id="notifikasi_in">
        <source src="{{ asset('assets') }}/sound/notifikasi_in.mp3" type="audio/mpeg">
    </audio>
    <audio id="notifikasi_out">
        <source src="{{ asset('assets') }}/sound/notifikasi_out.mp3" type="audio/mpeg">
    </audio>
    <audio id="notifikasi_gagal">
        <source src="{{ asset('assets') }}/sound/notifikasi_gagal.mp3" type="audio/mpeg">
    </audio>
    <audio id="notifikasi_luar_radius">
        <source src="{{ asset('assets') }}/sound/notifikasi_luar_radius.mp3" type="audio/mpeg">
    </audio>
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
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 17);

            // layer peta
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            // marker lokasi / titik lokasi
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

            // radius lokasi kantor
            var circle = L.circle([-6.895905, 109.662748], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 10
            }).addTo(map);
        }

        function errorCallback() {

        }

        // tombol klik presensi masuk
        $("#takeabsen").click(function(e) {
            var button = $(this);

            button.prop("disabled", true);
            button.addClass("loading");
            button.html(
                '<ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon> Sedang Memproses...'
            );

            // ambil gambar
            Webcam.snap(function(uri) {
                image = uri;
            });

            // ambil lokasi
            var lokasi = $('#lokasi').val();

            // Tambahkan jeda 2 detik
            setTimeout(function() {
                // dengan menggunakan ajax
                $.ajax({
                    type: "POST",
                    url: "{{ route('presensi.store') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        image: image,
                        lokasi: lokasi,
                    },
                    cache: false,
                    success: function(response) {
                        // Lakukan sesuatu setelah permintaan berhasil
                        // Misalnya, hilangkan status loading pada tombol
                        button.prop("disabled", false);
                        button.removeClass("loading");
                        button.html(
                            '<ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon> Presensi Masuk'
                        );

                        var notifikasi_in = document.getElementById('notifikasi_in')
                        var notifikasi_out = document.getElementById('notifikasi_out')
                        var notifikasi_gagal = document.getElementById('notifikasi_gagal')
                        var notifikasi_luar_radius = document.getElementById(
                            'notifikasi_luar_radius')
                        var status = response.split("|");
                        // Cek respons
                        if (status[0] == "success") {

                            // bunyikan audio
                            if (status[2] == 'in') {
                                notifikasi_in.play();
                            } else {
                                notifikasi_out.play();
                            }

                            // Tampilkan SweetAlert jika respons adalah 0
                            Swal.fire({
                                title: 'Presensi Berhasil',
                                html: status[1],
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                    const b = Swal.getHtmlContainer().querySelector(
                                        'b');
                                    timerInterval = setInterval(() => {
                                        b.textContent = Swal.getTimerLeft();
                                    }, 100);
                                },
                                customClass: {
                                    htmlContainer: 'text-center' // Menambahkan kelas CSS text-center
                                },
                                willClose: () => {
                                    window.location.href =
                                        '{{ route('dashboard') }}';
                                }
                            })
                        } else {

                            if (status[2] == 'radius') {
                                notifikasi_luar_radius.play();
                            } else {
                                notifikasi_gagal.play();
                            }

                            // Tampilkan SweetAlert jika respons bukan success
                            Swal.fire({
                                title: 'Presensi Gagal',
                                html: status[1],
                                icon: 'error', // Tambahkan ikon error
                                confirmButtonText: 'OK',
                                customClass: {
                                    htmlContainer: 'text-center' // Menambahkan kelas CSS text-center
                                },
                            });
                        }
                    },
                });
            }, 1000); // Jeda 1 detik (1000 milidetik)
        })
    </script>
@endpush
