<?php

function cek_foto($foto)
{
    $file = 'file-soal/' . $foto;
    if (is_file($file)) {
        return ' <img src="' . url('file-soal') . '/' . $foto . ' " width="90px" alt="">  </img>';
    }
}

function foto_soal($foto)
{
    $file = 'file-soal/' . $foto;
    if (is_file($file)) {
        return ' <img class="mb-4" src="' . url('file-soal') . '/' . $foto . ' " width="60%" alt="">';
    }
}


function kode_unik($nominal)
{
    // $nominal = 1238000; // jumlah nominal awal
    $sub = substr($nominal, -3);
    $sub2 = substr($nominal, -2);
    $sub3 = substr($nominal, -1);

    $total =  randomString(3);
    $total2 =  randomString(2);
    $total3 =  randomString(1);

    if ($sub == 0) {
        return $hasil =  $nominal + $total;
        // echo "No Unik :" . $total . "<br>";
        // echo "Nominal Transfer : Rp. " . number_format($hasil, 0, ",", ".");
    } else if ($sub2 == 0) {
        $hasil = $nominal + $total2;
        $no = substr($hasil, -3);
        // echo "No Unik :" . $no . "<br>";
        // echo "Nominal Transfer : Rp. " . number_format($hasil, 0, ",", ".");
        return $hasil;
    } else if ($sub3 == 0) {
        $hasil = $nominal + $total3;
        $no = substr($hasil, -3);
        // echo "No Unik :" . $no . "<br>";
        // echo "Nominal Transfer : Rp. " . number_format($hasil, 0, ",", ".");
        return $hasil;
    }
    // else {
    //     echo "No Unik :" . $sub . "<br>";
    //     echo "Nominal Transfer : Rp. " . number_format($nominal, 0, ",", ".");
    // }
}


function randomString($length)
{
    $str        = "";
    $characters = '123456789';
    // $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
    $max        = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}
