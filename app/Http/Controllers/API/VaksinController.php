<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Vaksin;
use Illuminate\Http\Request;

class VaksinController extends Controller
{
    public function index()
    {
        $data = Vaksin::where('status', 0)->inRandomOrder()->take(30)->get();
        return ResponseFormatter::success($data, 'Authenticated', 200);
    }

    public function store(Request $request)
    {
        Vaksin::where('nik', $request->nik)
            ->update([
                'status' => 1
            ]);
        return ResponseFormatter::success([], 'Authenticated', 200);
    }

    public function show($id)
    {
        $data = Vaksin::where('status', 1)->get();
        return ResponseFormatter::success($data, 'Authenticated', 200);
    }
}
