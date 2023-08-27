@extends('layouts.presensi')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

    <style>
        .datepicker-modal {
            max-height: 430px !important;
        }

        .datepicker-date-display {
            background-color: cornflowerblue;
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
        <div class="pageTitle">Form Izin / Sakit</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection
@section('content')
    <div class="row" style="margin-top: 70px;">
        <div class="col">
            <form action="{{ route('storeizin.presensi') }}" method="POST" id="frmizin">
                @csrf

                <div class="form-group">
                    <input type="text" name="tgl_izin" id="tgl_izin" class="form-control datepicker"
                        placeholder="Tanggal">
                </div>

                <div class="form-group">
                    <select name="status" id="status" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="i">Izin</option>
                        <option value="s">Sakit</option>
                    </select>
                </div>

                <div class="form-group">
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="5" placeholder="Keterangan"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-info btn-block">Kirim</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('myscripts')
    <script src="https://cdn.tiny.cloud/1/re1hyyagcsptel9z6bg836dptpkbrbpua7kjc4rgae0ap8kj/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tinymce.init({
            selector: 'textarea#ket',
            height: 200,
            init_instance_callback: function(editor) {
                var freeTiny = document.querySelector('.tox .tox-notification--in');
                freeTiny.style.display = 'none';
            }
        });

        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd"
            });
        });


        $('#frmizin').submit(function() {
            var tgl_izin = $('#tgl_izin').val();
            var status = $('#status').val();
            var keterangan = tinymce.get('ket').getContent();;

            if (tgl_izin == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Tanggal harus dipilih..!',
                });
                return false;
            } else if (status == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Status harus dipilih..!',
                });
                return false;
            } else if (keterangan.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Keterangan harus diisi..!',
                });
                return false;
            }
        });
    </script>
@endpush
