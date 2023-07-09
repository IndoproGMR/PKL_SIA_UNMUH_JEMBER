<?php

namespace App\Models;

use CodeIgniter\Model;

class Suratmasuk extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SM_ttd_SuratMasuk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'NoSurat',
        'DataTambahan',
        'TimeStamp',
        'JenisSurat_id',
        'mshw_id'
    ];

    function addSuratMasuk($data)
    {
        return $this->save($data);
    }

    function cekNoSurat(string $iduser, int $timefilter = 2629743)
    {
        $timefilter = time() - $timefilter;
        return $this
            ->select('SM_JenisSurat.name as namaJenisSurat,SM_ttd_SuratMasuk.NoSurat,SM_ttd_SuratMasuk.TimeStamp')
            ->where('mshw_id', $iduser)
            ->where('SM_ttd_SuratMasuk.TimeStamp >', $timefilter)
            ->join('SM_JenisSurat', 'SM_JenisSurat.id=SM_ttd_SuratMasuk.JenisSurat_id')
            ->orderBy('SM_ttd_SuratMasuk.TimeStamp', 'DESC')
            ->find();
    }

    function cekSuratByNo(string $noSurat)
    {
        $db = \Config\Database::connect("siautama", false);
        $builder = $db->table('mhsw');
        $surat = $this
            ->select('
        SM_ttd_SuratMasuk.NoSurat,
        SM_ttd_SuratMasuk.DataTambahan,
        SM_ttd_SuratMasuk.TimeStamp,
        SM_ttd_SuratMasuk.mshw_id,
        SM_JenisSurat.name,
        SM_JenisSurat.isiSurat,
        SM_JenisSurat.form,
        ')
            ->join('SM_JenisSurat', 'SM_JenisSurat.id=SM_ttd_SuratMasuk.JenisSurat_id')
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
}
