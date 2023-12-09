@extends('layouts.admin.tabler')

@section('contents')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">

                        <h2 class="page-title">
                            DATA KARYAWAN
                        </h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">

                            {{-- TOMBOL --}}
                            <a href="#" class="btn btn-primary d-none d-sm-inline-block" id="btnTambahKaryawan">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Tambah Data
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-body pl-3 ps-3 pb-3">
            <div class="container-xl">
                <div class="row ">

                    <div class="row card">

                        <div class="card-body">

                            <div class="row">
                                <div class="col-12">
                                    @if (Session::get('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif

                                    @if (Session::get('warning'))
                                        <div class="alert alert-warning">
                                            {{ Session::get('warning') }}
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="{{ route('karyawan') }}" method="GET">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="nama_karyawan"
                                                        placeholder="Nama Karyawan" value="{{ Request('nama_karyawan') }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <select name="kode_dept" class="form-control" id="kode_dept">
                                                        <option selected disabled>-- Pilih --</option>

                                                        @foreach ($departemen as $item)
                                                            @if ($item->id == Request('kode_dept'))
                                                                <option value="{{ $item->id }}" selected>
                                                                    {{ $loop->iteration }} -
                                                                    {{ $item->nama_dept }} -
                                                                    {{ $item->kode_dept }}
                                                                </option>
                                                            @else
                                                                <option value="{{ $item->id }}">{{ $loop->iteration }} -
                                                                    {{ $item->nama_dept }} -
                                                                    {{ $item->kode_dept }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-search" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                            <path d="M21 21l-6 -6"></path>
                                                        </svg>
                                                        Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table table-vcenter table-mobile-md card-table ">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>No. HP</th>
                                            <th class="w-1">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($karyawan as $item)
                                            <tr>
                                                <td>{{ $loop->iteration + $karyawan->firstItem() - 1 }}.</td>
                                                <td data-label="Foto">
                                                    <div class="d-flex py-1 align-items-center">
                                                        <span class="avatar me-2"
                                                            style="background-image: url({{ $item->foto != null ? Storage::url('uploads/karyawan/' . $item->foto) : 'assets/img/sample/avatar/avatar1.jpg' }})"></span>
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">{{ $item->nama_lengkap }}
                                                            </div>
                                                            <div class="text-secondary"><a href="#"
                                                                    class="text-reset">{{ $item->nik }}</a></div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td data-label="Title">
                                                    <div>{{ $item->kode_dept }}</div>
                                                    <div class="text-secondary">{{ $item->nama_dept }}</div>
                                                </td>
                                                <td>{{ $item->no_hp }}</td>
                                                <td>
                                                    <div class="btn-list flex-nowrap">
                                                        <a href="#" class="btn">
                                                            Edit
                                                        </a>
                                                        <div class="dropdown">
                                                            <button class="btn dropdown-toggle align-text-top"
                                                                data-bs-toggle="dropdown">
                                                                Actions
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item" href="#">
                                                                    Action
                                                                </a>
                                                                <a class="dropdown-item" href="#">
                                                                    Another action
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $karyawan->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-blur fade" id="modal-input-karyawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('karyawan.store') }}" method="POST" id="frmKaryawan"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-barcode" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M4 7v-1a2 2 0 0 1 2 -2h2"></path>
                                            <path d="M4 17v1a2 2 0 0 0 2 2h2"></path>
                                            <path d="M16 4h2a2 2 0 0 1 2 2v1"></path>
                                            <path d="M16 20h2a2 2 0 0 0 2 -2v-1"></path>
                                            <path d="M5 11h1v2h-1z"></path>
                                            <path d="M10 11l0 2"></path>
                                            <path d="M14 11h1v2h-1z"></path>
                                            <path d="M19 11l0 2"></path>
                                        </svg>
                                    </span>
                                    <input type="number" min="0" class="form-control" name="nik"
                                        id="nik" placeholder="NIK">
                                </div>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        </svg>
                                    </span>
                                    <input type="text" value="" class="form-control" name="nama_lengkap"
                                        id="nama_lengkap" placeholder="Nama Lengkap">
                                </div>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-device-desktop-analytics" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M3 4m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z">
                                            </path>
                                            <path d="M7 20h10"></path>
                                            <path d="M9 16v4"></path>
                                            <path d="M15 16v4"></path>
                                            <path d="M9 12v-4"></path>
                                            <path d="M12 12v-1"></path>
                                            <path d="M15 12v-2"></path>
                                            <path d="M12 12v-1"></path>
                                        </svg>
                                    </span>
                                    <input type="text" name="jabatan" id="jabatan" class="form-control"
                                        placeholder="Jabatan">
                                </div>
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                                            </path>
                                        </svg>
                                    </span>
                                    <input type="text" name="no_hp" id="no_hp" class="form-control"
                                        placeholder="No. Hp">
                                </div>
                                <div class="mb-3">
                                    <select name="kode_dept" id="kode_dept" class="form-control" id="kode_dept">

                                        <option selected disabled>-- Pilih Departemen --</option>

                                        @foreach ($departemen as $item)
                                            <option value="{{ $item->kode_dept }}">{{ $loop->iteration }} -
                                                {{ $item->nama_dept }} -
                                                {{ $item->kode_dept }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input type="file" name="foto" id="foto" class="form-control" />
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto btn-danger" data-bs-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ban"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                <path d="M5.7 5.7l12.6 12.6"></path>
                            </svg>
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                                <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M14 4l0 4l-6 0l0 -4"></path>
                            </svg>
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('myscript')
    <script>
        $(function() {
            $('#btnTambahKaryawan').click(function() {
                $('#modal-input-karyawan').modal('show');
                $('.modal .modal-title').text('Tambah Karyawan')
            });

            $('#frmKaryawan').submit(function() {
                var nik = $('#nik').val();
                var nama_lengkap = $('#nama_lengkap').val();
                var jabatan = $('#jabatan').val();
                var no_hp = $('#no_hp').val();
                var kode_dept = $('#frmKaryawan').find('#kode_dept').val();

                // validasi
                if (nik == "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'NIK tidak boleh kosong..!!',
                    }).then(() => {
                        $("nik").focus();
                    });
                    return false;
                } else if (nama_lengkap == "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Nama lengkap tidak boleh kosong..!!',
                    }).then(() => {
                        $("nama_lengkap").focus();
                    });
                    return false;
                } else if (jabatan == "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Jabatan tidak boleh kosong..!!',
                    }).then(() => {
                        $("jabatan").focus();
                    });
                    return false;
                } else if (no_hp == "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'No. Hp tidak boleh kosong..!!',
                    }).then(() => {
                        $("no_hp").focus();
                    });
                    return false;
                } else if (kode_dept == "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Departemen harus dipilih..!!',
                    }).then(() => {
                        $("kode_dept").focus();
                    });
                    return false;
                }
            })
        })
    </script>
@endpush
