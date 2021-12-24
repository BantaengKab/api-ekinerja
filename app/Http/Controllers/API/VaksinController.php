<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Vaksin;
use App\VaksinLog;
use Illuminate\Http\Request;

class VaksinController extends Controller
{
    public function index()
    {
        $data = Vaksin::where('status', 0)->inRandomOrder()->take(200)->get();
        return ResponseFormatter::success($data, 'Authenticated', 200);
    }

    public function store(Request $request)
    {
        $nik = $request->nik;
        Vaksin::where('nik', $request->nik)
            ->update([
                'status' => 1
            ]);

        try {
            VaksinLog::create([
                'nik' => $nik,

            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return ResponseFormatter::success([], 'Authenticated', 200);
    }

    public function show($id)
    {
        $data = VaksinLog::with('detail')->get();
        return ResponseFormatter::success($data, 'get data vaksin berhasil', 200);
    }

    public function login(Request $request)
    {
        $username = 'Admin';
        $password =  'admin';
        if ($username != $request->username)  return ResponseFormatter::error([], 'Authentication Failed', 500);
        if ($password != $request->password)  return ResponseFormatter::error([], 'Authentication Failed', 500);

        return ResponseFormatter::success([], 'Authenticated', 200);
    }
}
