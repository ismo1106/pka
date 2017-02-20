<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author   : Ismo Broto; @ismo1106
 */

if (!function_exists('is_maintenance')) {                                        //##++ Maintenance Helper
    function is_maintenance($status, $user){
        if($user != 'ismo_adm' && $status == TRUE){
            redirect(site_url('error/is_503'));
        }
    }
}

if (!function_exists('encode_str')) {                                           //##++ Encode String
    function encode_str($value, $gembok = '') {
        $skey = (trim($gembok) == '' ? '1234567890qwerty' : $gembok);
        if (!$value) {
            return false;
        }
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim(safe_b64encode($crypttext));
    }
    function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }
}

if (!function_exists('decode_str')) {                                           //##++ Decode String
    function decode_str($value, $gembok = '') {
        $skey = (trim($gembok) == '' ? '1234567890qwerty' : $gembok);
        if (!$value) {
            return false;
        }
        $crypttext = safe_b64decode($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }
    function safe_b64decode($string) {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
}

if (!function_exists('rand_color')) {
    function rand_color(){
        $color = array(
            'primary', 'success', 'info',
            'warning', 'danger', 'purple',
            'pink', 'inverse', 'orange',
            'brown', 'teal'
        );
        return $color[mt_rand(0, count($color) - 1)];
    }
}

if (!function_exists('getJadwalMedical')) {
    function getJadwalMedical($kuota = 0, $no_urut = 0){
        switch ($kuota){
            case 50:
                if ($no_urut > 70 && $no_urut <= 80){
                    return array(
                        'dari' => date('H:i', strtotime('16:00')),
                        'sampai' => date('H:i', strtotime('17:00'))
                    );
                }else if ($no_urut > 60 && $no_urut <= 70){
                    return array(
                        'dari' => date('H:i', strtotime('15:00')),
                        'sampai' => date('H:i', strtotime('16:00'))
                    );
                }else if ($no_urut > 50 && $no_urut <= 60){
                    return array(
                        'dari' => date('H:i', strtotime('14:00')),
                        'sampai' => date('H:i', strtotime('15:00'))
                    );
                }else if ($no_urut > 40 && $no_urut <= 50){
                    return array(
                        'dari' => date('H:i', strtotime('13:00')),
                        'sampai' => date('H:i', strtotime('14:00'))
                    );
                }else if ($no_urut > 30 && $no_urut <= 40){
                    return array(
                        'dari' => date('H:i', strtotime('11:00')),
                        'sampai' => date('H:i', strtotime('12:00'))
                    );
                }else if ($no_urut > 20 && $no_urut <= 30){
                    return array(
                        'dari' => date('H:i', strtotime('10:00')),
                        'sampai' => date('H:i', strtotime('11:00'))
                    );
                }else if ($no_urut > 10 && $no_urut <= 20){
                    return array(
                        'dari' => date('H:i', strtotime('09:00')),
                        'sampai' => date('H:i', strtotime('10:00'))
                    );
                }else{
                    return array(
                        'dari' => date('H:i', strtotime('08:00')),
                        'sampai' => date('H:i', strtotime('09:00'))
                    );
                }
                break;
            default :
                if ($no_urut > 70 && $no_urut <= 80){
                    return array(
                        'dari' => date('H:i', strtotime('16:00')),
                        'sampai' => date('H:i', strtotime('17:00'))
                    );
                }else if ($no_urut > 60 && $no_urut <= 70){
                    return array(
                        'dari' => date('H:i', strtotime('15:00')),
                        'sampai' => date('H:i', strtotime('16:00'))
                    );
                }else if ($no_urut > 50 && $no_urut <= 60){
                    return array(
                        'dari' => date('H:i', strtotime('14:00')),
                        'sampai' => date('H:i', strtotime('15:00'))
                    );
                }else if ($no_urut > 40 && $no_urut <= 50){
                    return array(
                        'dari' => date('H:i', strtotime('13:00')),
                        'sampai' => date('H:i', strtotime('14:00'))
                    );
                }else if ($no_urut > 30 && $no_urut <= 40){
                    return array(
                        'dari' => date('H:i', strtotime('11:00')),
                        'sampai' => date('H:i', strtotime('12:00'))
                    );
                }else if ($no_urut > 20 && $no_urut <= 30){
                    return array(
                        'dari' => date('H:i', strtotime('10:00')),
                        'sampai' => date('H:i', strtotime('11:00'))
                    );
                }else if ($no_urut > 10 && $no_urut <= 20){
                    return array(
                        'dari' => date('H:i', strtotime('09:00')),
                        'sampai' => date('H:i', strtotime('10:00'))
                    );
                }else{
                    return array(
                        'dari' => date('H:i', strtotime('08:00')),
                        'sampai' => date('H:i', strtotime('09:00'))
                    );
                }
        }
    }
}

if (!function_exists('hitung_umur')) {
    function hitung_umur($tgl_lahir = '1970-01-30', $bulan_out = FALSE, $hari_out = FALSE) {
        $day =  date('d', strtotime($tgl_lahir));
        $month =  date('m', strtotime($tgl_lahir));
        $year =  date('Y', strtotime($tgl_lahir));
        
        $cek_jmlhr1 = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $cek_jmlhr2 = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $sshari = $cek_jmlhr1 - $day;
        $ssbln = 12 - $month - 1;
        $hari = 0;
        $bulan = 0;
        $tahun = 0;
        //hari+bulan
        if ($sshari + date('d') >= $cek_jmlhr2) {
            $bulan = 1;
            $hari = $sshari + date('d') - $cek_jmlhr2;
        } else {
            $hari = $sshari + date('d');
        }
        if ($ssbln + date('m') + $bulan >= 12) {
            $bulan = ($ssbln + date('m') + $bulan) - 12;
            $tahun = date('Y') - $year;
        } else {
            $bulan = ($ssbln + date('m') + $bulan);
            $tahun = (date('Y') - $year) - 1;
        }

        if($bulan_out == TRUE && $hari_out == TRUE){
            $selisih = $tahun . " Tahun " . $bulan . " Bulan " . $hari . " Hari";
        }elseif ($bulan_out == TRUE) {
            $selisih = $tahun . " Tahun " . $bulan . " Bulan";
        }else{
            $selisih = $tahun . " Tahun";
        }
        return $selisih;
    }

}

if (!function_exists('terbilang')) {
    function terbilang($angka) {
        $satuan = array(
            1 => 'satu', 2 => 'dua', 3 => 'tiga', 4 => 'empat', 5 => 'lima', 6 => 'enam', 7 => 'tujuh', 8 => 'delapan', 9 => 'sembilan'
        );
        $belasan = array(
            11 => 'sebelas', 12 => 'dua belas', 13 => 'tiga belas', 14 => 'empat belas', 15 => 'lima belas', 16 => 'enam belas', 17 => 'tujuh belas', 18 => 'delapan belas', 19 => 'sembilan belas'
        );
        $puluhan = array(
            1 => 'sepuluh', 2 => 'dua puluh', 3 => 'tiga puluh', 4 => 'empat puluh', 5 => 'lima puluh', 6 => 'enam puluh', 7 => 'tujuh puluh', 8 => 'delapan puluh', 9 => 'sembilan puluh'
        );
        $ratusan = array(
            1 => 'seratus', 2 => 'dua ratus', 3 => 'tiga ratus', 4 => 'empat ratus', 5 => 'lima ratus', 6 => 'enam ratus', 7 => 'tujuh ratus', 8 => 'delapan ratus', 9 => 'sembilan ratus'
        );
        $return = '';
        if ($angka >= 100) {
            $ratus = floor($angka / 100);
            $angka-=$ratus * 100;
            $return = ' ' . $ratusan[$ratus];
        }
        if ($angka > 10 and $angka = 10) {
            $puluh = floor($angka / 10);
            $angka-=$puluh * 10;
            $return.=' ' . $puluhan[$puluh];
        }
        if ($angka >= 1) {
            $return.=' ' . $satuan[$angka];
        }
        return $return;
    }

}