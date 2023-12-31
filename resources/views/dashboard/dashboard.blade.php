@extends('layouts.presensi')

@section('content')
    <div class="section" id="user-section">
        <div id="user-detail">
            <div class="avatar">
                <img src="{{ Auth::guard('karyawan')->user()->foto == null ? asset('assets/img/sample/avatar/avatar1.jpg') : Storage::url('uploads/karyawan/' . Auth::guard('karyawan')->user()->foto) }}"
                    alt="avatar" class="imaged w64 rounded">
            </div>
            <div id="user-info">
                <h2 id="user-name">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</h2>
                <span id="user-role">{{ Auth::guard('karyawan')->user()->jabatan }}</span>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="{{ route('profil.editprofil') }}" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="{{ route('izin.presensi') }}" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="{{ route('histori.presensi') }}" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensihariini != null)
                                        @php
                                            $path = Storage::url('uploads/presensi/' . $presensihariini->foto_in);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w64 mr-1">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ $presensihariini != null ? $presensihariini->jam_in : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent ">
                                <div class="iconpresence ">
                                    @if ($presensihariini != null && $presensihariini->jam_out != null)
                                        @php
                                            $path = Storage::url('uploads/presensi/' . $presensihariini->foto_out);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w64 mr-1">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>{{ $presensihariini != null && $presensihariini->jam_out != null ? $presensihariini->jam_out : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="rekappresensi">
            <h5><strong>Rekap Presensi Bulan {{ $namabulan[$bulanini] }} Tahun {{ $tahunini }}</strong></h5>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important;">
                            @if ($rekappresensi->jmlhadir > 0)
                                <span class="badge badge-danger"
                                    style="position: absolute; top:3px; right:10px; font-size:0.6rem; z-index:999;">{{ $rekappresensi->jmlhadir }}</span>
                            @endif

                            <ion-icon name="accessibility-outline" style="font-size: 1.6rem;"
                                class="text-primary"></ion-icon>
                            <br>
                            <small style="font-weight: bold">Hadir</small>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important;">

                            @if ($reqkapizin->jmlizin > 0)
                                <span class="badge badge-danger"
                                    style="position: absolute; top:3px; right:10px; font-size:0.6rem; z-index:999;">{{ $reqkapizin->jmlizin }}</span>
                            @endif

                            <ion-icon name="newspaper-outline" style="font-size: 1.6rem;" class="text-success"></ion-icon>
                            <br>
                            <small style="font-weight: bold">Izin</small>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important;">

                            @if ($reqkapizin->jmlsakit > 0)
                                <span class="badge badge-danger"
                                    style="position: absolute; top:3px; right:10px; font-size:0.6rem; z-index:999;">{{ $reqkapizin->jmlsakit }}</span>
                            @endif

                            <ion-icon name="medkit-outline" style="font-size: 1.6rem;" class="text-warning"></ion-icon>
                            <br>
                            <small style="font-weight: bold">Sakit</small>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important;">

                            @if ($rekappresensi->jamterlambat > 0)
                                <span class="badge badge-danger"
                                    style="position: absolute; top:3px; right:10px; font-size:0.6rem; z-index:999;">{{ $rekappresensi->jamterlambat }}</span>
                            @endif

                            <ion-icon name="alarm-outline" style="font-size: 1.6rem;" class="text-danger"></ion-icon>
                            <br>
                            <small style="font-weight: bold">Telat</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        <li>

                            @forelse ($historibulanini as $presensi)
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="finger-print-outline" role="img" class="md hydrated"
                                            aria-label="finger-print-outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{ date('d-m-Y', strtotime($presensi->tgl_presensi)) }}</div>
                                        <span class="badge badge-success">{{ $presensi->jam_in }}</span>
                                        <span
                                            class="badge badge-danger">{{ $presensi != null && $presensi->jam_out != null ? $presensi->jam_out : '-' }}</span>
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

                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        <li>
                            @forelse ($leaderboard as $lb)
                                <div class="item">
                                    <img src="{{ asset('assets') }}/img/sample/avatar/avatar1.jpg" alt="image"
                                        class="image">
                                    <div class="in">
                                        <div>
                                            <strong>{{ $lb->nama_lengkap }}</strong><br>
                                            <small class="text-muted">{{ $lb->jabatan }}</small>
                                        </div>
                                        <span
                                            class="badge {{ $lb->jam_in < '07:30' ? 'badge-success' : 'badge-danger' }}">{{ $lb->jam_in }}</span>
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
        </div>
    </div>
@endsection
