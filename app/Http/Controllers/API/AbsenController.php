<?php

namespace App\Http\Controllers\API;

use App\AbsenData;
use App\AbsenLog;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\JamKerja;
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
        $data = AbsenLog::get();
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




        $jamKerja = JamKerja::all();


        // $jam_awal = '19:30';
        // $jam_akhir = '20:30';
        $jam_skrang =  date('H:i:s');
        // return $jam_skrang;
        foreach ($jamKerja as $jam) {
            //return 1;
            if ($jam->jam_awal <= $jam_skrang && $jam->jam_akhir >= $jam_skrang) {
                $absen = AbsenLog::whereDate('tanggal', '=', date('Y-m-d'))->where('nip', Auth::user()->username);
                if ($absen->count() == 0) AbsenLog::create(['tanggal' => date('Y-m-d'), 'kd_skpd' => Auth::user()->kd_skpd, 'nip' => Auth::user()->username]);

                $log = '';
                if ($jam->kd_absen == 0 && $absen->first()['masuk'] == "") {
                    $log = AbsenLog::where(['nip' => Auth::user()->username, 'tanggal' => date('Y-m-d')])->update(['masuk' => $jam_skrang]);
                } elseif ($jam->kd_absen == 1 && $absen->first()['istirahat'] == "") {
                    $log = AbsenLog::where(['nip' => Auth::user()->username, 'tanggal' => date('Y-m-d')])->update(['istirahat' => $jam_skrang]);
                } elseif ($jam->kd_absen == 2 && $absen->first()['masuk2'] == "") {
                    $log = AbsenLog::where(['nip' => Auth::user()->username, 'tanggal' => date('Y-m-d')])->update(['masuk2' => $jam_skrang]);
                } elseif ($jam->kd_absen == 3 && $absen->first()['pulang'] == "") {
                    $log = AbsenLog::where(['nip' => Auth::user()->username, 'tanggal' => date('Y-m-d')])->update(['pulang' => $jam_skrang]);
                } elseif ($jam->kd_absen == 4 && $absen->first()['masuk'] == "") {
                    $log = AbsenLog::where(['nip' => Auth::user()->username, 'tanggal' => date('Y-m-d')])->update(['masuk' => $jam_skrang]);
                } elseif ($jam->kd_absen == 5 && $absen->first()['pulang'] == "") {
                    $log = AbsenLog::where(['nip' => Auth::user()->username, 'tanggal' => date('Y-m-d')])->update(['pulang' => $jam_skrang]);
                }

                if ($log == '') {
                    $filename_gambar = null;
                    if ($request->file('gambar')) {
                        $gambar = $request->file('gambar');
                        $filename_gambar = time() . '.' . $gambar->getClientOriginalExtension();
                        $gambar->move('dokumen/', $filename_gambar);
                    }
                    AbsenData::create([
                        'absen_id' => $log->id,
                        'foto' => $log->$filename_gambar,
                        'kd_absen' => $jam->kd_absen,
                        'lat' => $request->lat,
                        'long' => $request->long,
                    ]);

                    return ResponseFormatter::success([
                        "message" => "Berhasil absen",
                    ], 'Authenticated', 200);
                }
            }
        }

        return ResponseFormatter::error([
            "message" => "Diluar jam kerja",
        ], 'Authenticated', 200);




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
}
