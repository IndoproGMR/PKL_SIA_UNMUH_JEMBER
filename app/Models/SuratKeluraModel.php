<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratKeluraModel extends Model
{
    // protected $DBGroup          = 'default';
    protected $table            = 'SK_ttd_MintaSurat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'NoSurat',
        'SuratIdentifier',
        'DataTambahan',
        'MasterSurat_id',
        'mshw_id',
        'Status',
        'Report_diskripsi',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function addSuratKeluar($data)
    {
        return $this->save($data);
    }

    function cekNotifPerluNoSurat()
    {
        return $this->select('count("*") as totalCount')
            ->where('SK_ttd_MintaSurat.NoSurat', 'Belum_Memiliki_No_Surat')
            ->join('SK_MasterSurat', 'SK_MasterSurat.id=SK_ttd_MintaSurat.MasterSurat_id')
            ->join('Server_MHSW_BlackList', 'Server_MHSW_BlackList.mshw_id=SK_ttd_MintaSurat.mshw_id', 'left')
            ->groupStart()
            ->orwhere('Server_MHSW_BlackList.Status', NULL)
            ->orWhere('Server_MHSW_BlackList.Status !=', 0)
            ->groupEnd()

            // ->where('Server_MHSW_BlackList.Status', 0)

            // ->where('SK_ttd_MintaSurat.deleted_at', null)
            ->findAll()[0]['totalCount'];
    }

    function cekNoSurat(string $iduser, $showall = false, $jenisSurat = 'all', $dateS = null, $dateE = null, $limit = 10)
    {
        $quary = $this
            ->select('
                SK_MasterSurat.name as namaJenisSurat,
                SK_ttd_MintaSurat.NoSurat,
                SK_ttd_MintaSurat.created_at,
                SK_ttd_MintaSurat.Status as StatusSurat,
                SK_ttd_MintaSurat.SuratIdentifier
            ')
            ->join('SK_MasterSurat', 'SK_MasterSurat.id=SK_ttd_MintaSurat.MasterSurat_id')

            ->groupStart()
            ->where('SK_ttd_MintaSurat.mshw_id', $iduser)
            ->groupEnd()

            ->where('SK_ttd_MintaSurat.deleted_at', null)
            ->orderBy('SK_ttd_MintaSurat.created_at', 'DESC');

        if ($jenisSurat !== 'all') {
            $quary->groupStart()
                ->where('SK_ttd_MintaSurat.MasterSurat_id', $jenisSurat)
                ->groupEnd();
        }

        if ($showall) {
            return $quary
                ->findAll($limit);
        }


        if (!is_null($dateS)) {
            $dateS = $dateS . " 00:00:01";
            $textquery = 'SK_ttd_MintaSurat.created_at BETWEEN "' . $dateS . '"';

            if (!is_null($dateE)) {
                $dateE = '"' . $dateE . " 23:59:59" . '"';
            } else {
                helper('textsurat');
                $dateE = '"' . getDateTime() . '"';
            }

            $textquery = $textquery . " AND " . $dateE;

            $quary->groupStart()
                ->where($textquery)
                ->groupEnd();
        }

        return $quary
            ->where('SK_ttd_MintaSurat.NoSurat !=', 'Belum_Memiliki_No_Surat')
            ->findAll($limit);
    }

    function cekSuratByNo($noSurat)
    {
        $db = \Config\Database::connect("siautama", false);
        $builder = $db->table('mhsw');

        $surat = $this
            ->select('
            SK_ttd_MintaSurat.NoSurat,
            SK_ttd_MintaSurat.DataTambahan,
            SK_ttd_MintaSurat.created_at,
            SK_ttd_MintaSurat.mshw_id,
            SK_ttd_MintaSurat.SuratIdentifier,
            SK_MasterSurat.name,
            SK_MasterSurat.isiSurat,
            SK_MasterSurat.form,
            ')
            ->join('SK_MasterSurat', 'SK_MasterSurat.id=SK_ttd_MintaSurat.MasterSurat_id')
            ->where('SK_ttd_MintaSurat.NoSurat', $noSurat)
            ->orWhere('SK_ttd_MintaSurat.id', $noSurat)
            ->find();

        if (!count($surat) > 0) {
            helper('datacall');
            $data['NoSurat']      = resMas('e');
            $data['DataTambahan'] = resMas('e');
            $data['created_at']    = resMas('e');
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
            $data['created_at']       = $surat[0]['created_at'];
            $data['namaMHS']         = $namaMHS[0]['Nama'];
            $data['SuratIdentifier'] = $surat[0]['SuratIdentifier'];
            $data['name']            = resMas('e');
            $data['isiSurat']        = base64_decode($surat[0]['isiSurat']);
            $data['form']            = base64_decode($surat[0]['form']);
            return $data;
        }

        $data['NoSurat']         = $surat[0]['NoSurat'];
        $data['DataTambahan']    = base64_decode($surat[0]['DataTambahan']);
        $data['created_at']      = $surat[0]['created_at'];
        $data['namaMHS']         = $namaMHS[0]['Nama'];
        $data['mshw_id']         = $surat[0]['mshw_id'];
        $data['SuratIdentifier'] = $surat[0]['SuratIdentifier'];
        $data['name']            = $surat[0]['name'];
        $data['isiSurat']        = base64_decode($surat[0]['isiSurat']);
        $data['form']            = base64_decode($surat[0]['form']);

        return $data;
    }

    function cekIdSuratByIdenti($identi)
    {
        $data = $this->select('id')->where('SuratIdentifier', $identi)->findAll(2);
        if (count($data) !== 1) {
            return 0;
        }
        return $data[0]['id'];
    }

    function cekSuratByIdenti($identi, $idMshw = null)
    {
        helper('authvalid');

        $prefix = "Query_DataSurat_" . $identi;
        if (cekCacheData($prefix, '')) {

            $db = \Config\Database::connect("siautama", false);
            $builder = $db->table('mhsw');

            $surat = $this
                ->select('
            SK_ttd_MintaSurat.NoSurat,
            SK_ttd_MintaSurat.DataTambahan,
            SK_ttd_MintaSurat.created_at,
            SK_ttd_MintaSurat.mshw_id,
            SK_ttd_MintaSurat.SuratIdentifier,
            SK_MasterSurat.name,
            SK_MasterSurat.isiSurat,
            SK_MasterSurat.form,
            ')
                ->join('SK_MasterSurat', 'SK_MasterSurat.id=SK_ttd_MintaSurat.MasterSurat_id')
                ->Where('SK_ttd_MintaSurat.SuratIdentifier', $identi)
                ->orWhere('SK_ttd_MintaSurat.NoSurat', $identi)
                ->find();




            if (!count($surat) > 0) {
                $data['error']        = 'y';
                return $data;
            }

            $namaMHS = $builder
                ->select('mhsw.Nama')
                ->where('Login', $surat[0]['mshw_id'])
                ->get()
                ->getResultArray();

            $data['NoSurat']         = $surat[0]['NoSurat'];
            $data['DataTambahan']    = base64_decode($surat[0]['DataTambahan']);
            $data['created_at']      = $surat[0]['created_at'];
            $data['namaMHS']         = $namaMHS[0]['Nama'];
            $data['SuratIdentifier'] = $surat[0]['SuratIdentifier'];
            $data['name']            = $surat[0]['name'];
            $data['isiSurat']        = base64_decode($surat[0]['isiSurat']);
            $data['form']            = base64_decode($surat[0]['form']);
            $data['error']           = 'n';

            setCacheData($prefix, $data, 30, '');
        } else {
            $data = getCachaData($prefix, '');
        }

        if (!is_null($idMshw)) {
            if ($data['namaMHS'] !== $idMshw) {
                $data['error'] = 'y';
                return $data;
            }
        }

        return $data;
    }

    function seeAllnoNoSuratWithJenis($jenisSurat = 'all', $TextF = null, $dateS = null, $dateE = null, $BL = 1)
    {
        $db = \Config\Database::connect("siautama", false);
        $builder = $db->table('mhsw');


        $quary = $this
            ->select('
            SK_ttd_MintaSurat.id,
            SK_ttd_MintaSurat.NoSurat,
            SK_ttd_MintaSurat.SuratIdentifier,
            SK_ttd_MintaSurat.created_at,
            SK_ttd_MintaSurat.mshw_id,
            SK_ttd_MintaSurat.MasterSurat_id,
            SK_MasterSurat.name,
            ')
            ->groupStart()
            ->where('SK_ttd_MintaSurat.NoSurat', 'Belum_Memiliki_No_Surat')
            // ->where('SK_ttd_MintaSurat.deleted_at', null)
            ->join('SK_MasterSurat', 'SK_MasterSurat.id=SK_ttd_MintaSurat.MasterSurat_id')
            ->join('Server_MHSW_BlackList', 'Server_MHSW_BlackList.mshw_id=SK_ttd_MintaSurat.mshw_id', 'left')
            // ->where('Server_MHSW_BlackList.Status', $BL)
            ->groupStart()
            ->where('Server_MHSW_BlackList.Status', NULL)
            ->orWhere('Server_MHSW_BlackList.Status', $BL)
            ->groupEnd()

            ->where('SK_MasterSurat.deleted_at', null)
            ->orderBy('SK_ttd_MintaSurat.created_at', 'ASC')
            ->groupEnd();

        if ($jenisSurat !== 'all') {
            $quary
                ->groupStart()
                ->where('MasterSurat_id', $jenisSurat)
                ->groupEnd();
        }

        if (!is_null($TextF)) {
            $quary
                ->groupStart()
                ->like('SK_ttd_MintaSurat.mshw_id', $TextF)
                ->orLike('SK_ttd_MintaSurat.SuratIdentifier', $TextF)
                ->groupEnd();
        }

        if (!is_null($dateS)) {
            $dateS = $dateS . " 00:00:01";
            $textquery = 'SK_ttd_MintaSurat.created_at BETWEEN "' . $dateS . '"';

            if (!is_null($dateE)) {
                $dateE = '"' . $dateE . " 23:59:59" . '"';
            } else {
                helper('textsurat');
                $dateE = '"' . getDateTime() . '"';
            }

            $textquery = $textquery . " AND " . $dateE;

            $quary->groupStart()
                ->where($textquery)
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
        return $this->select('count("*") as totalCount')->where('SK_ttd_MintaSurat.NoSurat', 'Belum_Memiliki_No_Surat')
            ->join('SK_MasterSurat', 'SK_MasterSurat.id=SK_ttd_MintaSurat.MasterSurat_id')
            ->where('SK_ttd_MintaSurat.deleted_at', null)
            ->findAll()[0]['totalCount'];
    }


    function updateNoSurat(int $id, $NoSurat)
    {
        $cek = $this->where('NoSurat', $NoSurat)->findAll();

        if (count($cek) > 0) {
            return false;
        }

        // d($cek);
        // helper('authvalid');
        // $prefix = "Query_DataSurat_" . $cek[0]['Query_DataSurat_'];
        // delCacheData($prefix, '');

        return $this->update($id, ['NoSurat' => $NoSurat]);
    }

    function deleteSurat($id)
    {
        return $this->delete($id);
        // return $this->update($id, ['deleted_at' => getUnixTimeStamp()]);
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

    // !Report
    function addReport($id, $diskripsi)
    {
        $data = [
            'Status' => 1,
            'Report_diskripsi' => base64_encode(json_encode($diskripsi))
        ];
        return $this->update($id, $data);
    }

    function seeAllReport($search = null, $limit = 10)
    {
        $query = $this->select(
            'SK_ttd_MintaSurat.SuratIdentifier,
            SK_ttd_MintaSurat.NoSurat,
            SK_MasterSurat.name as JenisSurat,
            SK_ttd_MintaSurat.mshw_id,
            SK_ttd_MintaSurat.Report_diskripsi,
            SK_ttd_MintaSurat.updated_at'
        )
            ->join('SK_MasterSurat', 'SK_MasterSurat.id = SK_ttd_MintaSurat.MasterSurat_id')
            ->where('SK_ttd_MintaSurat.Status', 1);

        if (!is_null($search)) {

            $query
                ->groupStart()
                ->like('SK_ttd_MintaSurat.mshw_id', $search)
                ->orLike('SK_ttd_MintaSurat.SuratIdentifier', $search)
                ->groupEnd();
        }

        $query = $query->findAll($limit);
        return $query;
    }

    // !delete
    function SeeDel()
    {
        return $this->where('deleted_at !=', null)->withDeleted()->findAll();
    }
}
