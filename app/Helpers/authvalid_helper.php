<?php

use App\Models\AuthUserGroup;

/**
 * @param array $group 
 * @param int $secure
 * 0 = cek dari session user
 * 1 = cek dari database
 * @return bool
 */
function in_group(array $group, int $secure = 0)
{
    $AuthUserGroup = model(AuthUserGroup::class);
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
            $lvluser = $AuthUserGroup->cekuserinfo(userInfo()['id'])['namaLVL'];
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
function in_admin()
{
    $model = model('AdminPanel');
    return $model->cekAdmin(userInfo()['id']);
    // panggil fungsi di admin panel model cek apakah userinfo()['id'] itu ada didalam db auth_admin-panel
    // userInfo()['namaLVL'] == 'Administrator'
    // if () {
    // return true;
    // };
    // return false;
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
function userInfo()
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
        'Gelar'    => ''
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
    // $Perm = [
    //     "Superuser",
    //     "Administrator",
    //     "Aplikan",
    //     "Staf PMB",
    //     "Ka PMB",
    //     "Presenter",
    //     "Calon Mahasiswa",
    //     "Administrasi Akademik",
    //     "Pengajaran Fakultas",
    //     "Kepala Akademik",
    //     "Administrasi Keuangan",
    //     "Kepala Keuangan",
    //     "Fakultas",
    //     "Biro Umum",
    //     "Dosen",
    //     "Kaprodi / Kajur",
    //     "Mahasiswa",
    //     "Executive Information System",
    //     "Rektorat"
    // ];
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
