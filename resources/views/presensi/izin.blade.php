@extends('layouts.presensi')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-info text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin / Sakit</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection
@section('content')
    <div class="row" style="margin-top: 4rem;">
        <div class="col">
            @php
                $messagesuccess = Session::get('success');
                $messageerror = Session::get('error');
            @endphp

            @if (Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{ $messagesuccess }}
                </div>
            @endif

            @if (Session::get('error'))
                <div class="alert alert-danger" role="alert">
                    {{ $messageerror }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <ul class="listview image-listview">
                <li>

                    @forelse ($dataizin as $item)
                        <div class="item">
                            {{-- <div class="icon-box bg-primary">
                                <div class="avatar">
                                    <img src="{{ Auth::guard('karyawan')->user()->foto == null ? asset('assets/img/sample/avatar/avatar1.jpg') : Storage::url('uploads/karyawan/' . Auth::guard('karyawan')->user()->foto) }}"
                                        alt="avatar" class="imaged w32 rounded">
                                </div>
                            </div> --}}
                            <div class="in">
                                <div>
                                    {{ date('d-m-Y', strtotime($item->tgl_izin)) }}
                                    <strong>({{ $item->status == 'i' ? 'Izin' : 'Sakit' }})</strong> <br>
                                    <small class="text-muted">{{ $item->keterangan }}</small>
                                </div>

                                @if ($item->status_approved == 0)
                                    <span class="badge badge-warning">menunggu konfirmasi</span>
                                @elseif ($item->status_approved == 1)
                                    <span class="badge badge-success">dikonfirmasi</span>
                                @elseif ($item->status_approved == 2)
                                    <span class="badge badge-danger">ditolak</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="">
                            <div class="text-center">
                                <div class="mt-2 text-danger"><strong>Belum ada data</strong></div>
                                <img src="{{ asset('assets') }}/anim/empty.gif" alt="image" class="image">
                            </div>
                        </div>
                    @endforelse

                </li>
            </ul>
        </div>
    </div>

    {{-- button --}}
    <div class="fab-button bottom-right " style="margin-bottom: 70px;">
        <a href="{{ route('buatizin.presensi') }}" class="fab bg-info"><ion-icon name="add-outline"></ion-icon></a>
    </div>

    @includeIf('presensi.modal')
@endsection
