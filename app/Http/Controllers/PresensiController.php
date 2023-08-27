<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {
        $hari_ini = date('Y-m-d');
        $nik = Auth::guard('karyawan')->user()->nik;

        // cek apakah sudah melakukan presensi sebelumnya
        $cek = DB::table('presensi')
            ->where('tgl_presensi', $hari_ini)
            ->where('nik', $nik)
            ->count();

        return view('presensi.create', compact('cek'));
    }

    public function store(Request $request)
    {
        $nik            = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi   = date("Y-m-d");
        $jam            = date("H:i:s");
        $image          = $request->image;
        $lokasi         = $request->lokasi;

        $lokasiuser     = explode(",", $lokasi);
        $latitudeuser   = $lokasiuser[0];
        $longitudeuser  = $lokasiuser[1];

        // -7.030654, 109.578283 rumah
        // -7.030722, 109.577493 rumah
        // -6.895905, 109.662748 kantor
        $latitudekantor     = -7.030654;
        $longitudekantor    = 109.578283;

        $jarak              = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius             = round($jarak['meters']);

        // cek apakah sudah melakukan presensi sebelumnya
        $cek = DB::table('presensi')
            ->where('tgl_presensi', $tgl_presensi)
            ->where('nik', $nik)
            ->count();

        if ($cek > 0) {
            $ket = 'out';
        } else {
            $ket = 'in';
        }

        $folderPath     = "public/uploads/presensi/";
        $formatName     = $nik . "-" . $tgl_presensi;
        $image_parts    = explode(";base64", $image);
        $image_base64   = base64_decode($image_parts[1]);
        $fileName       = $formatName . "-" . date("Hi") . "-" . $ket .  ".png";
        $file           = $folderPath . $fileName;

        // cek diluar radius kantor atau tidak
        if ($radius > 10) {
            echo "error|Kamu berada diluar radius, jarak anda " . $radius . " meter dari kantor.|radius";
        } else {
            // jika sudah melakukan presensi masuk maka update datanya
            if ($cek > 0) {
                $data2 = [
                    'jam_out'        => $jam,
                    'foto_out'       => $fileName,
                    'lokasi_out'     => $lokasi,
                ];

                $update = DB::table('presensi')
                    ->where('tgl_presensi', $tgl_presensi)
                    ->where('nik', $nik)
                    ->update($data2);

                if ($update) {
                    // simpan gambar
                    Storage::put($file, $image_base64);

                    echo "success|Terimakasih, Hati-hati dijalan..|out";
                } else {

                    echo "error| Presensi gagal, Silahkan hubungi Admin...!|out";
                }
            } else {
                $data = [
                    'nik'           => $nik,
                    'tgl_presensi'  => $tgl_presensi,
                    'jam_in'        => $jam,
                    'foto_in'       => $fileName,
                    'lokasi_in'     => $lokasi,
                ];

                $simpan = DB::table('presensi')->insert($data);

                if ($simpan) {
                    // simpan gambar
                    Storage::put($file, $image_base64);

                    echo "success|Terimakasih, Selamat bekerja..|in";
                } else {
                    echo "error|Presensi gagal, Silahkan hubungi Admin...!|in";
                }
            }
        }
    }

    // menghitung jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofil()
    {
        $nik        = Auth::guard('karyawan')->user()->nik;
        $karyawan   = DB::table('karyawan')->where('nik', $nik)->first();

        return view('presensi.editprofil', compact('karyawan'));
    }

    public function updateprofil(Request $request, $id)
    {
        $karyawan       = DB::table('karyawan')->where('id', $id)->first();
        $nama_lengkap   = $request->nama_lengkap;
        $no_hp          = $request->no_hp;

        if ($request->hasFile('foto')) {
            $foto = $karyawan->nik . "-" . $request->file('foto')->getClientOriginalName();
        }

        if ($request->password != null) {
            $pass       = Hash::make($request->password);
        } else {
            $pass       = $karyawan->password;
        }

        if ($request->hasFile('foto')) {

            $folderPath = "public/uploads/karyawan/";

            if ($karyawan->foto != null) {
                // unlink("public/uploads/karyawan/" . $foto);
                Storage::delete('public/uploads/karyawan/' . $karyawan->foto);
            }

            $request->file('foto')->storeAs($folderPath, $foto);
        }

        $data = [
            'nama_lengkap'  => $nama_lengkap,
            'no_hp'         => $no_hp,
            'foto'          => $foto,
            'password'      => $pass,
        ];

        $update = DB::table('karyawan')->where('id', $id)->update($data);

        if ($update) {

            return redirect()->back()->with('success', 'Data berhasil diubah');
        } else {
            return redirect()->back()->with('error', 'Data gagal diubah');
        }
    }

    public function histori()
    {
        $namabulan = [
            "",
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];

        $data = [
            'namabulan'     => $namabulan,
            'tahunmulai'    => 2023,
            'tahunsekarang' => date('Y'),
        ];

        return view('presensi.histori', $data);
    }

    public function getHistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $nik = Auth::guard('karyawan')->user()->nik;

        $histori = DB::table('presensi')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->where('nik', $nik)
            ->orderBy('tgl_presensi')
            ->get();

        return view('presensi.getHistori', compact('histori'));
    }

    public function izin()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('pengajuan_izin')->where('nik', $nik)->get();

        return view('presensi.izin', compact('dataizin'));
    }

    public function buatizin()
    {
        return view('presensi.buatizin');
    }

    public function storeizin(Request $request)
    {
        $nik        = Auth::guard('karyawan')->user()->nik;
        $tgl_izin   = $request->tgl_izin;
        $status     = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nik'           => $nik,
            'tgl_izin'      => $tgl_izin,
            'status'        => $status,
            'keterangan'    => $keterangan,
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);

        if ($simpan) {
            return redirect()->route('izin.presensi')->with(['success' => 'Data berhasil dikirim']);
        } else {
            return redirect()->route('izin.presensi')->with(['error' => 'Data gagal dikirim']);
        }
    }

    public function showizin($id)
    {
        $data = DB::table('pengajuan_izin')->where('id', $id)->first();

        return response()->json($data);
    }
}
