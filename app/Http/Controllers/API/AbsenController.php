<?php

namespace App\Http\Controllers\API;

use App\AbsenData;
use App\AbsenLog;
use App\AbsenRadius;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\JamKerja;
use App\Pegawai;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = AbsenLog::with('dataAbsen')->where('nip', Auth::user()->username)->orderBy('id', 'DESC')->get();
        return ResponseFormatter::success([
            "list" => $data,
        ], 'Authenticated', 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * lat
     * long
     * gambar
     */
    public function store(Request $request)
    {
        // $jam_awal = '19:30';
        // $jam_akhir = '20:30';
        $jam_skrang =  date('H:i:s');
        $jamKerja = JamKerja::all();

        # cek data pengawai
        $pegawai = Pegawai::where('nip_pegawai', Auth::user()->username)->first();
        if (!isset($pegawai)) return ResponseFormatter::error(["message" => "Lokasi Absen tidak ditemukan"], 'Authenticated');

        # get lokasi absensi
        $absenRadius = AbsenRadius::where('kd_skpd', $pegawai['kd_skpd'])->get();

        $lat = $request->lat;
        $long = $request->long;

        # cek absensi
        $id_lokasi = '';
        foreach ($absenRadius as $abr) {

            $distance = getDistance($abr->lat, $abr->long, $lat, $long);
            if ($distance <= $abr->radius) {
                $id_lokasi = $abr->id;
                break;
            }
            // if ($distance > $absenRadius->radius) return ResponseFormatter::error(["message" => "Anda berada di luar area absensi"], 'Authenticated');
        }
        # jika id lokasi kosong maka berada di luar lokasi absensi
        if ($id_lokasi == '') return ResponseFormatter::error(["message" => "Anda berada di luar area absensi"], 'Authenticated');

        foreach ($jamKerja as $jam) {


            if ($jam->jam_awal <= $jam_skrang && $jam->jam_akhir >= $jam_skrang) {
                $absen = AbsenLog::whereDate('tanggal', '=', date('Y-m-d'))->where('nip', Auth::user()->username);
                if ($absen->count() == 0) AbsenLog::create(['tanggal' => date('Y-m-d'), 'kd_skpd' => Auth::user()->kd_skpd, 'nip' => Auth::user()->username]);

                $log = AbsenLog::whereDate('tanggal', '=', date('Y-m-d'))->where('nip', Auth::user()->username);

                $gambar = $request->file('gambar');
                $filename_gambar = time() . '.' . $gambar->getClientOriginalExtension();

                $dt = new AbsenData;
                $dt->lat = $lat;
                $dt->long = $long;
                $dt->foto = $filename_gambar;
                $dt->absen_id = $log->first()['id'];

                if ($jam->kd_absen == 0 && $absen->first()['masuk'] == "") {
                    $log->first()->update(['masuk' => $jam_skrang]);

                    $gambar->move('dokumen/', $filename_gambar);

                    $dt->kd_absen = $jam->kd_absen;
                    $dt->save();

                    return ResponseFormatter::success(["message" => "Berhasil absen"], 'Authenticated', 200);
                } elseif ($jam->kd_absen == 1 && $absen->first()['istirahat'] == "") {
                    $log->first()->update(['istirahat' => $jam_skrang]);

                    $gambar->move('dokumen/', $filename_gambar);

                    $dt->kd_absen = $jam->kd_absen;
                    $dt->save();

                    return ResponseFormatter::success(["message" => "Berhasil absen"], 'Authenticated', 200);
                } elseif ($jam->kd_absen == 2 && $absen->first()['masuk2'] == "") {
                    $log->first()->update(['masuk2' => $jam_skrang]);

                    $gambar->move('dokumen/', $filename_gambar);

                    $dt->kd_absen = $jam->kd_absen;
                    $dt->save();

                    return ResponseFormatter::success(["message" => "Berhasil absen"], 'Authenticated', 200);
                } elseif ($jam->kd_absen == 3 && $absen->first()['pulang'] == "") {
                    $log->first()->update(['pulang' => $jam_skrang]);

                    $gambar->move('dokumen/', $filename_gambar);


                    $dt->kd_absen = $jam->kd_absen;
                    $dt->save();

                    return ResponseFormatter::success(["message" => "Berhasil absen"], 'Authenticated', 200);
                } elseif ($jam->kd_absen == 4 && $absen->first()['masuk'] == "") {
                    $log->first()->update(['masuk' => $jam_skrang]);

                    $gambar->move('dokumen/', $filename_gambar);

                    $dt->kd_absen = $jam->kd_absen;
                    $dt->save();

                    return ResponseFormatter::success(["message" => "Berhasil absen"], 'Authenticated', 200);
                } elseif ($jam->kd_absen == 5 && $absen->first()['pulang'] == "") {
                    $log->first()->update(['pulang' => $jam_skrang]);


                    $dt->kd_absen = $jam->kd_absen;
                    $dt->save();

                    return ResponseFormatter::success(["message" => "Berhasil absen"], 'Authenticated', 200);
                } else {
                    return ResponseFormatter::error(["message" => "Anda sudah absen"], 'Authenticated');
                }

                // return $log->first()['id'];
                // if ($log->first()['id'] != '') {
                //     $filename_gambar = null;
                //     if ($request->file('gambar')) {
                //         $gambar = $request->file('gambar');
                //         $filename_gambar = time() . '.' . $gambar->getClientOriginalExtension();
                //         $gambar->move('dokumen/', $filename_gambar);
                //     }

                //     AbsenData::create([
                //         'absen_id' => $log->first()['id'],
                //         'foto' => $filename_gambar,
                //         'kd_absen' => $jam->kd_absen,
                //         'lat' => $request->lat,
                //         'long' => $request->long,
                //     ]);

                // }


            }
        }

        return ResponseFormatter::error([
            "message" => "Diluar jam kerja",
        ], 'Authenticated');




        // $awal =   strtotime($jam_awal);
        // $skrang =   strtotime($jam_skrang);

        // return date('H:i', $awal);

        // echo date('h:i:s A');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function static()
    {
    }
}
