<?php

/*
  Function konversi angka  (bahasa indonesia)
  created by: eviriyanti Christina
  created date:13-12-2012

  contoh:

  $nomor= new Konfersi(2453,false);
  echo($nomor->ubah()); //Dua Ribu Empat Ratus Lima Puluh Tiga

  $nomor= new Konfersi(24.53,false);
  echo($nomor->ubah()); //Dua Puluh Empat Koma Lima Puluh Tiga

  $nomor= new Konfersi();
  echo($nomor->ConvertAngka(11000)); // Sebelas Ribu

  $nomor= new Konfersi(8000.51,true);
  echo($nomor->ubah()); //Delapan Ribu Rupiah Lima Puluh Satu Sen

 */

class Konfersi {

    var $angka = 0;
    var $idr = false;
    var $desimal = 0;

    function Convert($angka, $idr = false) {
        $this->angka = $angka;
        $this->idr = $idr;
        $curr = explode('.', $this->angka);
        $len = strlen($curr[1]);
        if ($len == 1) {
// tambah nol belakang angka
            $curr[1] .= '0';
        } elseif ($len > 2) {
// mengambil digit ke tiga setelah koma
            $round_digit = substr($curr[1], 2, 1);
// hapus angka seteleah digit ke dua
            $curr[1] = substr($curr[1], 0, 2);
        }
        $this->desimal = $curr[1];
    }

    function ubah() {
        if ($this->idr) {
            if ($this->desimal && $this->desimal > 0) {
                return Konfersi::ConvertAngka($this->angka) . " Rupiah " . Konfersi::ConvertAngka($this->desimal) . " Sen";
                ;
            } else {
                return Konfersi::ConvertAngka($this->angka) . " Rupiah";
            }
        } else {
            if ($this->desimal && $this->desimal > 0) {
                return Konfersi::ConvertAngka($this->angka) . " Koma " . Konfersi::ConvertAngka($this->desimal);
            } else {
                return Konfersi::ConvertAngka($this->angka);
            }
        }
    }

    static function ConvertAngka($angka) {
        $angka = trim($angka);
        $angka = preg_replace('/^0+/', '', $angka);

        if (($angka > 0) || ($angka < 999999999)) {

            $satuan = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam",
                "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas", "Dua Belas", "Tiga Belas",
                "Empat Belas", "Lima Belas", "Enam Belas", "Tujuh Belas", "Delapan Belas",
                "Sembilan Belas");
            $hasil = "";
            $Jt = floor($angka / 1000000);  /* juta */
            $angka-= $Jt * 1000000;
            if ($Jt) {
                $hasil .= Konfersi::ConvertAngka($Jt) . " Juta";
            }

            $Rb = floor($angka / 1000);     /* ribu */
            $angka-= $Rb * 1000;
            if ($Rb) {
                $hasil .= (empty($hasil) ? "" : " ") . Konfersi::ConvertAngka($Rb) . " Ribu ";
            }
            $Rs = floor($angka / 100);      /* ratusan */
            $angka-= $Rs * 100;

            if ($Rs) {
                $ratus = $satuan[$Rs];
                $hasil.=$ratus . " Ratus ";
            }

            $Pn = floor($angka / 10);  /* puluhan */
            $angka-= $Pn * 10;
            $st = $angka % 10;  /* satuan */

            if ($Pn) {
                if ($Pn > 1) {
                    $Pn = $satuan[$Pn];
                    $hasil.= $Pn . " Puluh ";
                }
            }
            if ($Pn || $st) {
                if ($Pn < 2) {
                    $hasil.= $satuan[$Pn * 10 + $st];
                }
            }
            if (empty($hasil)) {
                $hasil = "";
            }

            $hasil = str_replace("Satu Ribu", "Seribu", $hasil);
            $hasil = str_replace("Satu Ratus", "Seratus", $hasil);
            return $hasil;
        }
    }

}
?>
