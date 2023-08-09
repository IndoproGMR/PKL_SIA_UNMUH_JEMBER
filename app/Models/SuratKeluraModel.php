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
        'mshw_id'
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

    function cekSuratByNo(string $noSurat)
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
            ->where('NoSurat', $noSurat)
            ->find();

        if (!count($surat) > 0) {
            helper('datacall');
            $data['NoSurat']      = datacallRespond('e');
            $data['DataTambahan'] = datacallRespond('e');
            $data['TimeStamp']    = datacallRespond('e');
            $data['namaMHS']      = datacallRespond('e');
            $data['name']         = datacallRespond('e');
            $data['isiSurat']     = datacallRespond('e');
            $data['form']         = datacallRespond('e');
            return $data;
        }

        $namaMHS = $builder->select('mhsw.Nama')->where('Login', $surat[0]['mshw_id'])->get()->getResultArray();

        if (!count($namaMHS) > 0) {
            helper('datacall');
            $data['NoSurat']      = $surat[0]['NoSurat'];
            $data['DataTambahan'] = base64_decode($surat[0]['DataTambahan']);
            $data['TimeStamp']    = $surat[0]['TimeStamp'];
            $data['namaMHS']      = $namaMHS[0]['Nama'];
            $data['name']         = datacallRespond('e');
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
        $data = $this->select('id,NoSurat,SuratIdentifier,TimeStamp,mshw_id')
            ->where('SK_ttd_SuratMasuk.NoSurat', 'Belum_Memiliki_No_Surat')
            ->where('deleteAt', null)
            ->findAll();
        return $data;
    }

    function updateNoSurat(int $id, $NoSurat)
    {
        return $this->update($id, ['NoSurat' => $NoSurat]);
    }
}
