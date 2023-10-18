<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratKeluraModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SK_ttd_SuratMasuk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'NoSurat',
        'SuratIdentifier',
        'DataTambahan',
        'TimeStamp',
        'JenisSurat_id',
        'mshw_id',
        'DeleteAt'
    ];

    function addSuratKeluar($data)
    {
        return $this->save($data);
    }

    function cekNoSurat(string $iduser, $showall = false, $jenisSurat = 'all', int $timefilter = 1)
    {
        // $timefilter = time() - $timefilter;

        $quary = $this
            ->select('
        SK_JenisSurat.name as namaJenisSurat,
        SK_ttd_SuratMasuk.NoSurat,
        SK_ttd_SuratMasuk.TimeStamp,
        SK_ttd_SuratMasuk.SuratIdentifier
        ')
            ->join('SK_JenisSurat', 'SK_JenisSurat.id=SK_ttd_SuratMasuk.JenisSurat_id')

            ->groupStart()
            ->where('SK_ttd_SuratMasuk.mshw_id', $iduser)
            ->groupEnd()

            ->where('SK_ttd_SuratMasuk.DeleteAt', null)
            ->orderBy('SK_ttd_SuratMasuk.TimeStamp', 'DESC');

        if ($jenisSurat !== 'all') {
            $quary->groupStart()
                ->where('SK_ttd_SuratMasuk.JenisSurat_id', $jenisSurat)
                ->groupEnd();
        }

        if ($showall) {
            return $quary
                ->findAll();
        }

        if ($timefilter !== 'all' && $jenisSurat == 'all') {
            $timeNow = getUnixTimeStamp();

            $timeAtas  = $timeNow - (2592000 * ($timefilter));
            $timeBawah = $timeNow - (2592000 * ($timefilter - 1));

            $quary->groupStart()
                ->where('SK_ttd_SuratMasuk.TimeStamp >=', $timeAtas)
                ->where('SK_ttd_SuratMasuk.TimeStamp <=', $timeBawah)
                ->groupEnd();
        }

        return $quary
            ->where('SK_ttd_SuratMasuk.NoSurat !=', 'Belum_Memiliki_No_Surat')
            ->findAll();
    }

    function cekSuratByNo($noSurat)
    {
        $db = \Config\Database::connect("siautama", false);
        $builder = $db->table('mhsw');

        $surat = $this
            ->select('
            SK_ttd_SuratMasuk.NoSurat,
            SK_ttd_SuratMasuk.DataTambahan,
            SK_ttd_SuratMasuk.TimeStamp,
            SK_ttd_SuratMasuk.mshw_id,
            SK_ttd_SuratMasuk.SuratIdentifier,
            SK_JenisSurat.name,
            SK_JenisSurat.isiSurat,
            SK_JenisSurat.form,
            ')
            ->join('SK_JenisSurat', 'SK_JenisSurat.id=SK_ttd_SuratMasuk.JenisSurat_id')
            ->where('SK_ttd_SuratMasuk.NoSurat', $noSurat)
            ->orWhere('SK_ttd_SuratMasuk.id', $noSurat)
            ->find();

        if (!count($surat) > 0) {
            helper('datacall');
            $data['NoSurat']      = resMas('e');
            $data['DataTambahan'] = resMas('e');
            $data['TimeStamp']    = resMas('e');
            $data['namaMHS']      = resMas('e');
            $data['name']         = resMas('e');
            $data['isiSurat']     = resMas('e');
            $data['form']         = resMas('e');
            return $data;
        }

        $namaMHS = $builder
            ->select('mhsw.Nama')
            ->where('Login', $surat[0]['mshw_id'])
            ->get()
            ->getResultArray();

        if (!count($namaMHS) > 0) {
            helper('datacall');
            $data['NoSurat']         = $surat[0]['NoSurat'];
            $data['DataTambahan']    = base64_decode($surat[0]['DataTambahan']);
            $data['TimeStamp']       = $surat[0]['TimeStamp'];
            $data['namaMHS']         = $namaMHS[0]['Nama'];
            $data['SuratIdentifier'] = $surat[0]['SuratIdentifier'];
            $data['name']            = resMas('e');
            $data['isiSurat']        = base64_decode($surat[0]['isiSurat']);
            $data['form']            = base64_decode($surat[0]['form']);
            return $data;
        }

        $data['NoSurat']         = $surat[0]['NoSurat'];
        $data['DataTambahan']    = base64_decode($surat[0]['DataTambahan']);
        $data['TimeStamp']       = $surat[0]['TimeStamp'];
        $data['namaMHS']         = $namaMHS[0]['Nama'];
        $data['SuratIdentifier'] = $surat[0]['SuratIdentifier'];
        $data['name']            = $surat[0]['name'];
        $data['isiSurat']        = base64_decode($surat[0]['isiSurat']);
        $data['form']            = base64_decode($surat[0]['form']);

        return $data;
    }

    function seeAllnoNoSuratWithJenis($jenisSurat = 'all', $TextF = null)
    {
        $db = \Config\Database::connect("siautama", false);
        $builder = $db->table('mhsw');


        $quary = $this
            ->select('
            SK_ttd_SuratMasuk.id,
            SK_ttd_SuratMasuk.NoSurat,
            SK_ttd_SuratMasuk.SuratIdentifier,
            SK_ttd_SuratMasuk.TimeStamp,
            SK_ttd_SuratMasuk.mshw_id,
            SK_ttd_SuratMasuk.JenisSurat_id,
            SK_JenisSurat.name,
            ')
            ->groupStart()
            ->where('SK_ttd_SuratMasuk.NoSurat', 'Belum_Memiliki_No_Surat')
            ->where('SK_ttd_SuratMasuk.deleteAt', null)
            ->join('SK_JenisSurat', 'SK_JenisSurat.id=SK_ttd_SuratMasuk.JenisSurat_id')
            ->orderBy('SK_ttd_SuratMasuk.TimeStamp', 'ASC')
            ->groupEnd();

        if ($jenisSurat !== 'all') {
            $quary
                ->groupStart()
                ->where('JenisSurat_id', $jenisSurat)
                ->groupEnd();
        }
        if (!is_null($TextF)) {
            $quary
                ->groupStart()
                ->like('SK_ttd_SuratMasuk.mshw_id', $TextF)
                ->orLike('SK_ttd_SuratMasuk.SuratIdentifier', $TextF)
                ->groupEnd();
        }

        $data = $quary->findAll();

        foreach ($data as $key => $value) {
            $data[$key]['namaMahasiswa'] = $builder
                ->select('mhsw.Nama')
                ->where('Login', $value['mshw_id'])
                ->get()
                ->getResultArray()[0];
        }

        return $data;
    }


    function seeAllnoNoSuratCount()
    {
        return $this->select('count("*") as totalCount')->where('SK_ttd_SuratMasuk.NoSurat', 'Belum_Memiliki_No_Surat')
            ->join('SK_JenisSurat', 'SK_JenisSurat.id=SK_ttd_SuratMasuk.JenisSurat_id')
            ->where('SK_ttd_SuratMasuk.deleteAt', null)
            ->findAll()[0]['totalCount'];
    }


    function updateNoSurat(int $id, $NoSurat)
    {
        $cek = $this->where('NoSurat', $NoSurat)->findAll();

        if (count($cek) > 0) {
            return false;
        }

        return $this->update($id, ['NoSurat' => $NoSurat]);
    }

    function deleteSurat($id)
    {
        return $this->update($id, ['DeleteAt' => getUnixTimeStamp()]);
    }

    function cekExistNoSurat($noSurat)
    {
        $data = $this->where('NoSurat', $noSurat)->findAll(2);
        helper('datacall');

        if (count($data) > 0) {
            $data = [
                'massage_status'  => '1',
                'massage' => resMas('num.surat.exist.db')
            ];
            return $data;
        }

        $data = [
            'massage_status'  => '0',
            'massage' => resMas('num.surat.n.exist.db')
        ];

        return $data;
    }
}
