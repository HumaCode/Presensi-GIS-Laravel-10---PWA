<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $lokasi         = $request->lokasi;
        $image          = $request->image;

        $folderPath     = "public/uploads/presensi/";
        $formatName     = $nik . "-" . $tgl_presensi;
        $image_parts    = explode(";base64", $image);
        $image_base64   = base64_decode($image_parts[1]);
        $fileName       = $formatName . "-" . date("Hi") .  ".png";
        $file           = $folderPath . $fileName;



        // cek apakah sudah melakukan presensi sebelumnya
        $cek = DB::table('presensi')
            ->where('tgl_presensi', $tgl_presensi)
            ->where('nik', $nik)
            ->count();

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
