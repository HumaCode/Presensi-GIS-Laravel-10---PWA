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
                            {{-- <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#modal-report">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Create new report
                            </a> --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-body p-3">
            <div class="container-xl">
                <div class="row ">

                    <div class="row card">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-mobile-md card-table">
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
                                                <td>{{ $loop->iteration }}.</td>
                                                <td data-label="Foto">
                                                    <div class="d-flex py-1 align-items-center">
                                                        <span class="avatar me-2"
                                                            style="background-image: url({{ Storage::url('uploads/karyawan/' . $item->foto) }})"></span>
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
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
