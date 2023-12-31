<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        // $karyawan = DB::table('karyawan')
        //     ->join('departemen', 'karyawan.kode_dept', '=', 'departemen.id')
        //     ->orderBy('nama_lengkap')
        //     ->paginate(10);

        $query = Karyawan::query();
        $query->select('karyawan.*', 'departemen.kode_dept', 'departemen.nama_dept');
        $query->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept');
        $query->orderBy('nama_lengkap');
        if (!empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }
        if (!empty($request->kode_dept)) {
            $query->where('karyawan.kode_dept', $request->kode_dept);
        }

        $karyawan = $query->paginate(10);
        // dd($karyawan);

        $departemen = DB::table('departemen')->get();
        return view('karyawan.index', compact('karyawan', 'departemen'));
    }

    public function store(Request $request)
    {
        $nik            = $request->nik;
        $nama_lengkap   = $request->nama_lengkap;
        $jabatan        = $request->jabatan;
        $no_hp          = $request->no_hp;
        $kode_dept      = $request->kode_dept;
        $password       = Hash::make('12345');

        if ($request->hasFile('foto')) {
            $foto = $nik . "-" . $request->file('foto')->getClientOriginalName();
        } else {
            $foto = null;
        }

        try {
            $data = [
                'nik'           => $nik,
                'nama_lengkap'  => $nama_lengkap,
                'jabatan'       => $jabatan,
                'no_hp'         => $no_hp,
                'kode_dept'     => $kode_dept,
                'foto'          => $foto,
                'password'      => $password,
            ];

            $simpan = DB::table('karyawan')->insert($data);

            if ($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }

                return Redirect::back()->with('success', 'Data berhasil disimpan.');
            }
        } catch (\Throwable $e) {
            return Redirect::back()->with('warning', 'Data gagal disimpan.');
        }
    }
}
