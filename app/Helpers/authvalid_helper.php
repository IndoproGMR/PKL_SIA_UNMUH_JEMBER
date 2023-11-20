<?php

use App\Models\AuthUserGroup;
use CodeIgniter\Config\Services;

$cache = \Config\Services::cache();

function getToken($TokenName = 'X-token')
{
    $request = \Config\Services::request();
    $token = $request->getHeaderLine($TokenName);

    if (is_null($token) || $token == 'null' || $token == '') {
        $data['status'] = false;
        return $data;
    }

    $data['status'] = true;
    $data['Token'] = $token;
    return $data;
}

/**
 * @param string $prefix
 * @param string $customId null = userID
 * 
 * @return bool null = true
 */
function cekCacheData(string $prefix, string $customId = null): bool
{
    if (is_null($customId)) {
        $namacache = $prefix . userInfo()['id'];
    } else {
        $namacache = $prefix . $customId;
    }

    if (cache($namacache) === null) {
        return true;
    };
    return false;
}

/**
 * @param string $prefix
 * @param mixed $data
 * @param int $ttl
 * @param string $customId null = userID
 * 
 * @return bool
 */
function setCacheData(string $prefix, $data, int $ttl = 30, string $customId = null)
{
    if (is_null($customId)) {
        $namacache = $prefix . userInfo()['id'];
    } else {
        $namacache = $prefix . $customId;
    }

    return cache()->save($namacache, base64_encode(json_encode($data)), $ttl);
}

/**
 * @param string $prefix
 * @param string $customId null = userID
 * 
 * @return mixed
 */
function getCachaData(string $prefix, string $customId = null)
{
    if (is_null($customId)) {
        $namacache = $prefix . userInfo()['id'];
    } else {
        $namacache = $prefix . $customId;
    }

    return json_decode(base64_decode(cache($namacache)), true);
}

/**
 * @param string $prefix
 * @param string $customId null = userID
 * 
 * @return bool
 */
function delCacheData(string $prefix, string $customId = null): bool
{
    if (is_null($customId)) {
        $namacache = $prefix . userInfo()['id'];
    } else {
        $namacache = $prefix . $customId;
    }

    return cache()->delete($namacache);
}

/**
 * @param array $group 
 * @param int $secure
 * 0 = cek dari session user
 * 1 = cek dari database
 * @return bool
 */
function in_group(array $group, int $secure = 0): bool
{
    switch ($secure) {
        case '0':
            foreach ($group as $namagrup) {
                if ($namagrup == userInfo()['namaLVL']) {
                    return true;
                    break;
                }
            }
            break;
        case '1':
            $request = Services::request();
            if (userInfo()['IP'] !== $request->getIPAddress()) {
                return false;
            }

            $prefix = 'AUTH_Group_';
            if (cekCacheData($prefix)) {
                $AuthUserGroup = model('AuthUserGroup');
                $lvluser = $AuthUserGroup->cekuserinfo(userInfo()['id'])['namaLVL'];
                setCacheData($prefix, $lvluser, 360);
            } else {
                $lvluser = getCachaData($prefix);
            }



            foreach ($group as $namagrup) {
                if ($namagrup == $lvluser) {
                    return true;
                    break;
                }
            }
            break;
        default:
            // "terjadi masalah pada perm";
            return false;
            break;
    }
    return false;
}

/**
 * @return bool
 */
function in_admin(): bool
{
    $model = model('AdminPanel');
    return $model->cekAdmin(userInfo()['id']);
}

/**
 * output
 * ['id']
 * ['FotoUser']
 * ['NamaUser']
 * ['namaLVL']
 * ['Gelar']
 * @return array
 */
function userInfo(): array
{
    $session = \Config\Services::session();
    if ($session->has('userdata')) {
        return $session->get('userdata');
    }



    return  [
        'id'       => 'error',
        'FotoUser' => 'img/level/personal.png',
        'NamaUser' => 'mohon login',
        'namaLVL'  => 'mohon login',
        'Gelar'    => '',
        'IP'       => 'error',
        'BL'       => 'Y'
    ];
}

/**
 * @return bool
 */
function userAdmin()
{
    $session = \Config\Services::session();
    if ($session->has('admin')) {
        return $session->get('admin');
    }
    return false;
}

/**
 * @param array $group = [
 *   "Superuser",
 *   "Administrator",
 *   "Aplikan",
 *   "Staf PMB",
 *   "Ka PMB",
 *   "Presenter",
 *   "Calon Mahasiswa",
 *   "Administrasi Akademik",
 *   "Pengajaran Fakultas",
 *   "Kepala Akademik",
 *   "Administrasi Keuangan",
 *   "Kepala Keuangan",
 *   "Fakultas",
 *   "Biro Umum",
 *   "Dosen",
 *   "Kaprodi / Kajur",
 *   "Mahasiswa",
 *   "Executive Information System",
 *   "Rektorat"
 *   ];
 * 
 * @param string $redirect kirim laman bila tidak memiliki perm
 * @param bool $login bila true user harus login tidak memandang level group
 * @param int $secure
 * 0 = cek dari session user
 * 1 = cek daro database
 * 
 * @return void
 */
function PagePerm(array $group, string $redirect = 'error_perm', bool $login = false, int $secure = 0)
{
    // !cek login tanpa perlu melihat di grup mana
    if ($login) {
        if (userInfo()['id'] == 'error') {
            throw new \CodeIgniter\Router\Exceptions\RedirectException("$redirect");
        }
        return;
    }

    // !cek login dan melihat di grup mana
    if (userInfo()['id'] == 'error') {
        throw new \CodeIgniter\Router\Exceptions\RedirectException("$redirect");
    }
    // !cek melihat di grup mana
    if (!in_group($group, $secure)) {
        throw new \CodeIgniter\Router\Exceptions\RedirectException("$redirect");
    }
}

/**
 * @param string $type = fail,warning,success
 * @param array $datainput = ['data','data2']
 * @param string $type = fail,warning,success.unknown
 * @param string $mode = set,get
 */
function FlashMassage(string $link = '', array $datainput = [], $type = 'unknown', string $mode = 'set')
{
    $session = \Config\Services::session();
    $data = [
        'massage' => $datainput,
        'type'    => $type
    ];

    switch ($mode) {
        case 'set':
            $session->setFlashdata('datamassage', $data);

            return redirect()->to($link);
            break;

        case 'get':
            if ($session->getFlashdata('datamassage') !== '') {
                return $session->getFlashdata('datamassage');
            }
            break;

        default:
            return null;
            break;
    }
}
/**
 * @param string $dataError $e->getMe
 */

function FlashException($dataError = "Error Tidak Di Ketahui", $mode = 'set')
{
    $session = \Config\Services::session();

    switch ($mode) {
        case 'set':
            $session->setFlashdata('error', $dataError);
            throw new \CodeIgniter\Router\Exceptions\RedirectException("/Error_Exception");
            // return redirect()->to('/Error_Exception');
            break;

        case 'get':
            return $session->getFlashdata('error');
            break;

        default:
            return null;
            break;
    }
}
