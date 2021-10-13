<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            #validasi input
            // $validator =  $request->validate([
            //     'email' => 'required|email',
            //     'password' => 'required'
            // ]);

            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'pass' => 'required',
                'kd_perangkat' => 'required',
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error([
                    "error" => 'validation_error',
                    "message" => $validator->errors(),
                ], 'Authentication Failed', 422);
            }


            # mengecek credentials (login)
            $credentials = request(['username', 'pass']);



            // if (!Auth::attempt($credentials)) {
            //     return ResponseFormatter::error([
            //         'message' => 'Unauthorized'
            //     ], 'Authentication Failed', 500);
            // }

            # Jika hash tidak sesuai
            $user = User::where('username', $request->username);
            $kd_perangkat = randomString(10);
            # cek perangkat yang digunakan
            if ($user->first()['kd_perangkat'] ==  null || $user->first()['kd_perangkat'] ==  '') {
                User::where('id', $user->first()['id'])
                    ->update([
                        'kd_perangkat' => $kd_perangkat,
                    ]);
            } else {
                if ($user->first()['kd_perangkat'] !=  $request->kd_perangkat) {
                    return ResponseFormatter::error([
                        'message' => 'Silahkan gunakan perangkat pribadi anda',
                    ], 'Device not found', 501);
                }
            }


            $md5 = md5($user->first()['id']);
            $hash = hash('sha256', $md5 . $request->pass);

            if ($user->first()['pass'] != $hash) {
                throw new \Exception('Invalid Credentials');
            }

            // if (!Hash::check($request->password, $user->password, [])) {
            //     throw new \Exception('Invalid Credentials');
            // }


            # jika berhasil maka loginkan
            $tokenResult = $user->first()->createToken($user->first()['full_name']);
            $token = $tokenResult->token;
            $token->save();
            return ResponseFormatter::success([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'user' => $user->first()
            ], 'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went error',
                'error' => $error,

            ], 'Authentication Failed', 500);
        }
    }

    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'Data profile user berhasil diambil');
    }

    public function logout(Request $request)
    {

        $token =  $request->user()->token()->revoke();

        return ResponseFormatter::success($token, 'Token Revoked');
    }
}
