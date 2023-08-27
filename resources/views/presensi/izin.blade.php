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

    {{-- button --}}
    <div class="fab-button bottom-right " style="margin-bottom: 70px;">
        <a href="{{ route('buatizin.presensi') }}" class="fab bg-info"><ion-icon name="add-outline"></ion-icon></a>
    </div>
@endsection
