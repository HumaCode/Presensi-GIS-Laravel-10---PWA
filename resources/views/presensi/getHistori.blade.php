<ul class="listview image-listview">
    <li>

        @forelse ($histori as $item)
            <div class="item">
                <div class="icon-box bg-primary">
                    <div class="avatar">
                        <img src="{{ Auth::guard('karyawan')->user()->foto == null ? asset('assets/img/sample/avatar/avatar1.jpg') : Storage::url('uploads/karyawan/' . Auth::guard('karyawan')->user()->foto) }}"
                            alt="avatar" class="imaged w32 rounded">
                    </div>
                </div>
                <div class="in">
                    <div>{{ date('d-m-Y', strtotime($item->tgl_presensi)) }}</div>
                    <span class="badge badge-success">{{ $item->jam_in }}</span>
                    <span
                        class="badge badge-danger">{{ $item != null && $item->jam_out != null ? $item->jam_out : '-' }}</span>
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
