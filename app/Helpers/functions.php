<?php


function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
{
    $earth_radius = 6371;

    $dLat = deg2rad($latitude2 - $latitude1);
    $dLon = deg2rad($longitude2 - $longitude1);

    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * asin(sqrt($a));
    $d = $earth_radius * $c;

    return $d * 1000;

    // $distance = getDistance(-5.16822309043619, 119.43464980464627, -5.168415424332763, 119.43578706126858);
    // echo $distance * 1000; // km * 1000
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
