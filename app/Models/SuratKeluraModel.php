<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratKeluraModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SK_ttd_SuratMasuk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
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

    function cekNoSurat(string $iduser, int $timefilter = 2629743)
    {
        $timefilter = time() - $timefilter;
        return $this
            ->select('SK_JenisSurat.name as namaJenisSurat,SK_ttd_SuratMasuk.NoSurat,SK_ttd_SuratMasuk.TimeStamp,SK_ttd_SuratMasuk.SuratIdentifier')
            ->where('mshw_id', $iduser)
            ->where('SK_ttd_SuratMasuk.TimeStamp >', $timefilter)
            ->join('SK_JenisSurat', 'SK_JenisSurat.id=SK_ttd_SuratMasuk.JenisSurat_id')
            ->orderBy('SK_ttd_SuratMasuk.TimeStamp', 'DESC')
            ->find();
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

        $namaMHS = $builder->select('mhsw.Nama')->where('Login', $surat[0]['mshw_id'])->get()->getResultArray();

        if (!count($namaMHS) > 0) {
            helper('datacall');
            $data['NoSurat']      = $surat[0]['NoSurat'];
            $data['DataTambahan'] = base64_decode($surat[0]['DataTambahan']);
            $data['TimeStamp']    = $surat[0]['TimeStamp'];
            $data['namaMHS']      = $namaMHS[0]['Nama'];
            $data['name']         = resMas('e');
            $data['isiSurat']     = base64_decode($surat[0]['isiSurat']);
            $data['form']         = base64_decode($surat[0]['form']);
            return $data;
        }

        $data['NoSurat']      = $surat[0]['NoSurat'];
        $data['DataTambahan'] = base64_decode($surat[0]['DataTambahan']);
        $data['TimeStamp']    = $surat[0]['TimeStamp'];
        $data['namaMHS']      = $namaMHS[0]['Nama'];
        $data['name']         = $surat[0]['name'];
        $data['isiSurat']     = base64_decode($surat[0]['isiSurat']);
        $data['form']         = base64_decode($surat[0]['form']);
        return $data;
    }

    function seeAllnoNoSurat()
    {
        $db = \Config\Database::connect("siautama", false);
        $builder = $db->table('mhsw');


        $data = $this->select('
            SK_ttd_SuratMasuk.id,
            SK_ttd_SuratMasuk.NoSurat,
            SK_ttd_SuratMasuk.SuratIdentifier,
            SK_ttd_SuratMasuk.TimeStamp,
            SK_ttd_SuratMasuk.mshw_id,
            SK_ttd_SuratMasuk.JenisSurat_id,
            SK_JenisSurat.name,
            ')
            ->where('SK_ttd_SuratMasuk.NoSurat', 'Belum_Memiliki_No_Surat')
            ->join('SK_JenisSurat', 'SK_JenisSurat.id=SK_ttd_SuratMasuk.JenisSurat_id')
            ->where('SK_ttd_SuratMasuk.deleteAt', null)
            ->findAll();

        foreach ($data as $key => $value) {
            // $data['value'] = $value;
            // $data['key'] = $key;
            $data[$key]['namaMahasiswa'] = $builder
                ->select('mhsw.Nama')
                ->where('Login', $value['mshw_id'])
                ->get()
                ->getResultArray()[0];
        }


        return $data;
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
}
