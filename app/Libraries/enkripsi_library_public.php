<?php

namespace App\Libraries;

/**
 * ?enkripsi_library Version 5
 * ?tanggal  30 - 9 - 2023
 */

class enkripsi_library_public
{
    protected $superkey;
    protected $IV;
    protected $algo;

    public function __construct()
    {
        $this->superkey = hash("sha256", $_ENV["enkripsi.SuperKey"]);
        $this->IV = substr(hash("sha256", $_ENV["enkripsi.IV"]), 0, 16);
        $this->algo = $_ENV["enkripsi.ALGO"];
    }

    /**
     * memanggil data enkripsiTTD
     * 
     * @param string $noSurat
     * @param string $idmhs
     * 
     * @return string
     */
    public function get_EnkripsiTTD(string $noSurat, string $idmhs, $idPenandaTangan = null, $NamaTTD = null): string
    {
        return $this->enkripsiTTD($noSurat, $idmhs, $idPenandaTangan, $NamaTTD);
    }

    /**
     * memanggil data dekripsiTTD
     * 
     * @param string $text
     * 
     * @return array
     */
    public function get_DekripsiTTD(string $text): array
    {
        $dataTTD = $this->pecahkan($text);
        return $this->dekripsiTTD($dataTTD[2]);
    }

    /**
     * Men Hash password
     * 
     * @param string $password
     * 
     * @return string
     */
    public function get_HashPass(string $password): string
    {
        return $this->enkripsiPass($password);
    }





    /**
     * Men enkripsi TandaTangan
     */
    private function enkripsiTTD($noSurat, $idmhs, $idPenandaTangan = null, $NamaTTD = null)
    {
        helper('textsurat');

        if (is_null($idPenandaTangan)) {
            $idPenandaTangan = userInfo()['id'];
        }

        if (is_null($NamaTTD)) {
            $NamaTTD         = userInfo()['NamaUser'];
        }

        $RandomNumber    = generateIdentifier(16, 'unix');

        $text = $noSurat . "_" . $RandomNumber . "_" . $idPenandaTangan . "_" . $idmhs;
        $hasilhash = $this->TwoWayEncryption('enkripsi', $text);
        $textenkripsi = "DiTandaTanganiOleh_$NamaTTD" . "_" . $hasilhash;

        return $textenkripsi;
    }

    /**
     * Men dekripsi TandaTangan
     */
    private function dekripsiTTD(string $text)
    {
        $datadekripsi = $this->TwoWayEncryption('dekripsi', $text);
        return $this->pecahkan($datadekripsi);
    }

    private function enkripsiPass(string $password)
    {
        $env = $_ENV['AUTH_ENVIRONMENT'];
        if ($env == 'development') {
            return $password;
        }



        // !Something Something algo



        $hashPass = $password;




        return $hashPass;
    }

    /**
     * untuk men enkripsi dan dekripsi data
     */
    private function TwoWayEncryption(string $mode, string $msg)
    {
        $superkey = $this->superkey;
        $IV = $this->IV;
        $algo = $this->algo;

        switch ($mode) {
            case 'enkripsi':
                return base64_encode(openssl_encrypt($msg, $algo, $superkey, 0, $IV));
                break;

            case 'dekripsi':
                return openssl_decrypt(base64_decode($msg), $algo, $superkey, 0, $IV);
                break;

            default:
                helper('datacall');
                FlashException(resMas('e.param.enkrip.n.valid'));
                break;
        }
    }



    private function enkripsiToken()
    {
        //
    }

    ///
    public function validasiTTD(string $data, string $noSurat)
    {
        helper('datacall');

        // !panggil Model yang memiliki datahash dengan noSurat yang sama
        $model = model('TandaTangan');
        $dataa['validasi'] = $model->cekvalidasi($noSurat, $data);

        if ($dataa['validasi']['NoSurat'] == $noSurat) {
            $dataa['validasi']['valid'] = resMas('TTD.exist.db');
            return $dataa['validasi'];
        }

        // !bila data dihash tidak ada di dalam DB maka dekripsikan hash nya
        $dataa['hashraw'] = $this->pecahkan($data);
        if (count($dataa['hashraw']) !== 3) {
            $dataa['validasi'] = [
                'NoSurat'     => resMas('e'),
                'TimeStamp'   => resMas('e'),
                'pendattg_id' => resMas('e'),
                'mshw_id'     => resMas('e'),
                'jenisSurat'  => resMas('e'),
                'valid'       => resMas('TTD.n.valid')
            ];
            return $dataa['validasi'];
        }

        $dataa['hash'] = $this->dekripsiTTD($dataa['hashraw'][2]);

        if (count($dataa['hash']) > 2) {
            $dataa['validasi'] = [
                'NoSurat'     => $dataa['hash'][0],
                'TimeStamp'   => explode('-', $dataa['hash'][1])[1],
                'pendattg_id' => $dataa['hash'][2],
                'mshw_id'     => $dataa['hash'][3],
                'jenisSurat'  => resMas('e'),
                'valid'       => resMas('TTD.valid.t.n.exist.db.!2'),
            ];
            return $dataa['validasi'];
        }

        $dataa['validasi'] = [
            'NoSurat'     => resMas('e'),
            'TimeStamp'   => resMas('e'),
            'pendattg_id' => resMas('e'),
            'mshw_id'     => resMas('e'),
            'jenisSurat'  => resMas('e'),
            'valid'       => resMas('TTD.n.valid')
        ];
        return $dataa['validasi'];
    }

    ///
    public function pecahkan(string $text, $seperator = '_')
    {
        return explode($seperator, $text);
    }

    public function get_TwoWayEncryption(string $mode, string $msg)
    {
        return 0;
        // return $this->TwoWayEncryption($mode, $msg);
    }
}
