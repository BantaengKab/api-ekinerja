<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Pegawai;
use App\Permohonan;
use File;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;
class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $nip = Auth::user()->username;
            $pegawai_id = Pegawai::where('nip_pegawai', $nip)->first();
            $now = date('Y-m');
            $cek = Permohonan::where('pegawai_id', $pegawai_id['id_pegawai'])->where('tgl_mulai', 'LIKE', '%'.$now.'%')->orderBy('id_permohonan', 'desc')->get();
             return ResponseFormatter::success([
                    "list" => $cek,
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    date_default_timezone_set('Asia/Makassar');
        try {
          $validator = Validator::make($request->all(), [
                'long' => 'required',
                'lat' => 'required',
                'gambar' => 'required',
                'jenis_permohonan' => 'required',
           
                
                
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error([
                    "error" => 'validation_error',
                    "message" => $validator->errors(),
                ], 'Authentication Failed', 422);
            }
            
            if ($request->file('gambar')) {
                $gambar = $request->file('gambar');
                $filename_gambar = time() . '.' . $gambar->getClientOriginalExtension();
                $gambar->move('permohonan/', $filename_gambar);
                
            } else {
                $filename_gambar = null;
                    
            }
            
          
            $nip = Auth::user()->username;
            $pegawai_id = Pegawai::where('nip_pegawai', $nip)->first();
            
            
            $now = date('Y-m-d');
            $cek = Permohonan::where('pegawai_id', $pegawai_id['id_pegawai'])->where('tgl_mulai', 'LIKE', '%'.$now.'%')->count();
            
            // if($cek > 0 ){
                
            //     return ResponseFormatter::error([
            //         "error" => 'Data Sudah Ada',
            //         "message" => 'Anda Telah Absen Hari ini',
            //     ], 'Authentication Failed', 400);
            // }
            $input = $request->all();
            $input['pegawai_id']=$pegawai_id['id_pegawai'];
            $input['kd_skpd']=$pegawai_id['kd_skpd'];
            $input['gambar']=$filename_gambar;
            $input['site']="mobile";
            $input['tgl_mulai']=date('Y-m-d');
            $input['tgl_selesai']=date('Y-m-d');
            $input['creation_date']=date('Y-m-d H:i:s');
           
            $data = Permohonan::create($input);
            
                return ResponseFormatter::success([
                    "message" => "Data Berhasil direkam",
                ], 'Authenticated', 200);
            
            
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went error',
                'error' => $error,

            ], 'Authentication Failed', 500);
        } 
            
            
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
