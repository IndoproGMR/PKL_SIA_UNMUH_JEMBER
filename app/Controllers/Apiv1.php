<?php

namespace App\Controllers;

use App\Libraries\enkripsi_library;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Apiv1 extends ResourceController
{
    use ResponseTrait;

    public function ValidasiQRDetail()
    {
        $dataGet = $this->request->getGet([
            'nosurat',
            'qrcode'
        ]);

        if (is_null($dataGet['nosurat']) || is_null($dataGet['qrcode'])) {

            helper('datacall');

            $data['respond'] = [
                'nosurat'       => resMas('e'),
                'JenisSurat'    => resMas('e'),
                'Mahasiswa'     => resMas('e'),
                'penandatangan' => resMas('e'),
                'TimeStamp'     => resMas('e'),
                'valid'         => resMas('e.param.n.exist'),
            ];
            return $this->respond($data['respond']);
        }

        helper(['textsurat', 'datacall', 'authvalid']);

        // !==================================================================>>
        // cek apakah tandaTanga nya Valid
        $prefix = "Query_validasiqrdetail_" . $dataGet['qrcode'] . "_" . $dataGet['nosurat'];
        if (cekCacheData($prefix, '')) {
            $validasienkripsi = new enkripsi_library;
            $data['dataJson'] = $validasienkripsi->validasiTTD($dataGet['qrcode'], $dataGet['nosurat']);
            setCacheData($prefix, $data['dataJson'], 60, '');
        } else {
            $data['dataJson'] = getCachaData($prefix, '');
        }

        // Bila tidak valid out kan error
        if ($data['dataJson']['pendattg_id'] == resMas('e')) {
            $data['respond'] = [
                'nosurat'       => resMas('e'),
                'JenisSurat'    => resMas('e'),
                'Mahasiswa'     => resMas('e'),
                'penandatangan' => resMas('e'),
                'TimeStamp'     => resMas('e'),
                'valid'         => resMas('e.param.n.exist'),
            ];
            return $this->respond($data['respond']);
        }
        // !==================================================================<<

        // !==================================================================>>
        // cek info mahasiswa dan penandatangan
        $prefix = "Query_cekdoseninfo_" . $data['dataJson']['pendattg_id'];
        if (cekCacheData($prefix)) {
            $model = model('AuthUserGroup');
            $penandatangan = $model->cekdoseninfo($data['dataJson']['pendattg_id']);


            setCacheData($prefix, $penandatangan, 360, '');
        } else {
            $penandatangan = getCachaData($prefix);
        }

        $prefix = "Query_cekmahasiswainfo_" . $data['dataJson']['mshw_id'];
        if (cekCacheData($prefix)) {

            $model = model('AuthUserGroup');
            $Mahasiswa = $model->cekmahasiswainfo($data['dataJson']['mshw_id']);
            setCacheData($prefix, $Mahasiswa, 360, '');
        } else {
            $Mahasiswa = getCachaData($prefix);
        }
        // !==================================================================<<

        $data['respond']['nosurat']       = $data['dataJson']['NoSurat'];
        $data['respond']['JenisSurat']    = $data['dataJson']['jenisSurat'];
        $data['respond']['Mahasiswa']     = $Mahasiswa['NamaUser'];
        $data['respond']['penandatangan'] = $penandatangan['NamaUser'] . ' ' . $penandatangan['Gelar'];
        $data['respond']['TimeStamp']     = timeconverter($data['dataJson']['TimeStamp']);
        $data['respond']['valid']         = $data['dataJson']['valid'];

        return $this->respond($data['respond']);
    }

    function cekNoSurat()
    {
        $token = $this->request->getHeaderLine('X-token');
        helper(['datacall', 'authvalid']);

        // cek Token apakah dikirim?
        if (is_null($token) || $token == 'null' || $token == '') {
            $data = [
                'massage_status'  => '1',
                'massage' => resMas('f.:.perm.n.valid')
            ];
            return $this->respond($data, 401, 'access_denied');
        }

        $dataGet = $this->request->getGet(['NoSurat']);

        if (is_null($dataGet['NoSurat'])) {
            $data = [
                'massage_status'  => '2',
                'massage' => 'API PARAM ERROR'
            ];
            // return $this->respond($data);
            return $this->fail($data);
        }

        // cek apakah token ada di dalam redis
        if (cekCacheData($token, '')) {
            $data = [
                'massage_status'  => '-1',
                'massage' => resMas('f.n')
            ];
            // return $this->respond($data);
            return $this->failUnauthorized();
        }

        $prefix = 'Query_cekNoSurat_';
        if (cekCacheData($prefix, $dataGet['NoSurat'])) {
            $model = model('SuratKeluraModel');
            $dataSurat['respond'] = $model->cekExistNoSurat(base64_decode($dataGet['NoSurat']));
            setCacheData($prefix, $dataSurat, 360, $dataGet['NoSurat']);
        } else {
            $dataSurat = getCachaData($prefix, $dataGet['NoSurat']);
        }

        return $this->respond($dataSurat['respond'], 200);
    }

    public function imagecache($imagename)
    {
        $image = \Config\Services::image();
        // return 'asset/logo/unmuh.png';
        $path = '';
        $data['imagepath'] = match ($imagename) {
            'logo'  => 'asset/logo/unmuh.png',
            default => 'asset/logo/error_img.png',
        };

        $binary = readfile($data['imagepath']);
        $options = [
            'max-age'  => 2592000,
            's-maxage' => 2592000,
            'etag'     => 'abcde',
        ];

        return $this->response

            ->setHeader('Content-Type', 'image/png')
            ->setCache($options)
            // ->setHeader('Content-Type', $file->getMimeType())
            // ->setHeader('Content-disposition', 'inline; filename="' . $file->getBasename() . '"')
            ->setStatusCode(200)
            ->setBody($binary);
        // return $data['imagepath'];
    }



    /**
     * @deprecated
     */
    public function validasiqr()
    {
        $data['respond'] = [
            'massage_status'  => '-1',
            'massage' => 'API Deprecated'
        ];
        return $this->respond($data['respond'], 410);

        $dataGet = $this->request->getGet([
            'nosurat',
            'qrcode'
        ]);

        if (is_null($dataGet['nosurat']) || is_null($dataGet['qrcode'])) {
            helper('datacall');

            $data['respond'] = [
                'valid' => resMas('e.param.n.exist')
            ];
            return $this->respond($data['respond'], 400, 'invalid_request');
        }

        helper('datacall');

        $validasienkripsi = new enkripsi_library;
        $data['dataJson'] = $validasienkripsi->validasiTTD($dataGet['qrcode'], $dataGet['nosurat']);

        $data['respond'] = [
            'valid' => $data['dataJson']['valid']
        ];

        return $this->respond($data['respond']);
    }
}
