<?php

namespace App\Libraries;

/**
 * ?enkripsi_library Version 7
 * ?tanggal  25 - 12 - 2023
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
     * Encrypts signature data for storage.
     *
     * Encrypts the signature text containing the letter number, 
     * random number, signer ID and student ID.  
     * Uses the TwoWayEncryption method for encryption.
     *
     * @param string $noSurat Letter number
     * @param string $idmhs Student ID 
     * @param string $idPenandaTangan Signer ID, defaults to current user
     * @param string $NamaTTD Signer name, defaults to current user
     * @return string The encrypted signature text
     */
    public function get_EnkripsiTTD(string $noSurat, string $idmhs, $idPenandaTangan = null, $NamaTTD = null): string
    {
        return $this->enkripsiTTD($noSurat, $idmhs, $idPenandaTangan, $NamaTTD);
    }

    /**
     * Decrypts encrypted signature data.
     * 
     * Takes an encrypted signature text and decrypts it to retrieve the original signature data.
     * Uses the TwoWayEncryption method for decryption.
     *
     * @param string $text The encrypted signature text
     * @return array An array containing the decrypted signature data:
     *               [0] => Letter number 
     *               [1] => Random number 
     *               [2] => Signer ID  
     *               [3] => Student ID
     */
    public function get_DekripsiTTD(string $text): array
    {
        $dataTTD = $this->pecahkan($text);
        return $this->dekripsiTTD($dataTTD[2]);
    }

    /**
     * Hashes a password using encryption.
     *
     * Takes a plaintext password string, encrypts it using the 
     * enkripsiPass() method, and returns the encrypted hash.
     * 
     * @param string $password The plaintext password to hash
     * 
     * @return string The encrypted password hash
     */
    public function get_HashPass(string $password): string
    {
        return $this->enkripsiPass($password);
    }



    /**
     * Encrypts signature data for storage.
     * 
     * Encrypts the signature text containing the letter number, 
     * random number, signer ID and student ID. 
     * Uses the TwoWayEncryption method for encryption.
     * 
     * @param string $noSurat Letter number 
     * @param string $idmhs Student ID
     * @param string $idPenandaTangan Signer ID, defaults to current user
     * @param string $NamaTTD Signer name, defaults to current user
     * @return string The encrypted signature text 
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
     * Decrypts an encrypted signature text.
     * 
     * Takes an encrypted signature text and decrypts it using the TwoWayEncryption 
     * method. The decrypted text contains the letter number, random number, 
     * signer ID and student ID, which are extracted and returned.
     * 
     * @param string $text The encrypted signature text to decrypt.
     * @return array The decrypted data containing letter number, random number,
     *               signer ID and student ID.
     */
    private function dekripsiTTD(string $text)
    {
        $datadekripsi = $this->TwoWayEncryption('dekripsi', $text);
        return $this->pecahkan($datadekripsi);
    }

    /**
     * Encrypts a password string for secure storage.
     * 
     * Checks if environment is development and returns plaintext password, 
     * otherwise encrypts password using a hashing algorithm before returning.
     * 
     * @param string $password The plaintext password to encrypt
     * @return string The encrypted password string
     */
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
     * Encrypts or decrypts a message using OpenSSL.
     *
     * @param string $mode Either 'enkripsi' or 'dekripsi'. 
     * @param string $msg The message to encrypt or decrypt.
     * @return string The encrypted or decrypted message.
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

    /**
     * Validates a digital signature data string against a document number.
     * 
     * Decrypts the signature data and checks if the document number matches. 
     * If no match, tries to decrypt and validate the raw signature data.
     * 
     * Returns a validation result object indicating if signature is valid
     * and extracted metadata if valid.
     *
     * @param string $data The encrypted digital signature data.
     * @param string $noSurat The document number to validate against.  
     * @return array Validation result object.
     */
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
                'TimeStamp'   => explode('-', $dataa['hash'][1])[0],
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

    /** Splits a string into an array by a given separator.
     *
     * @param string $text The string to split. 
     * @param string $separator The separator to split on. Defaults to '_'.
     * @return array The split string as an array.
     */
    public function pecahkan(string $text, $seperator = '_')
    {
        return explode($seperator, $text);
    }

    // !deprecated
    public function get_TwoWayEncryption(string $mode, string $msg)
    {
        return 0;
        // return $this->TwoWayEncryption($mode, $msg);
    }

    private function enkripsiToken()
    {
        //
    }
}
