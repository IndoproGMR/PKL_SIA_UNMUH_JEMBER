<?php

use App\Models\AuthUserGroup;

/**
 * $group array
 * $secure
 * 0 = cek dari session user
 * 1 = cek dari database
 */
function in_group($group, int $secure = 0)
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
 * output
 * ['id']
 * ['FotoUser']
 * ['NamaUser']
 * ['namaLVL']
 */
function userInfo()
{
    $session = \Config\Services::session();
    if (!$session->has('userdata')) {
        return  [
            'id'       => 'error',
            'FotoUser' => 'img/level/personal.png',
            'NamaUser' => 'mohon login',
            'namaLVL'  => 'mohon login'
        ];
    }
    return $session->get('userdata');
}

/**
 * $group = [
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
 * $redirect kirim laman bila tidak memiliki perm
 * $login bila true user harus login tidak memandang level group
 * $secure
 * 0 = cek dari session user
 * 1 = cek daro database
 */
function PagePerm($group, $redirect = 'error_perm', $login = false, $secure = 0)
{
    if ($login) {
        if (userInfo()['id'] == 'error') {
            throw new \CodeIgniter\Router\Exceptions\RedirectException("$redirect");
        }
        return;
    }

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

function FlashException($dataError = "Error Tidak Di Ketahui", $mode = 'set')
{
    $session = \Config\Services::session();

    switch ($mode) {
        case 'set':
            $session->setFlashdata('error', $dataError);
            return redirect()->to('/Error_Exception');
            break;

        case 'get':
            return $session->getFlashdata('error');
            break;

        default:
            return null;
            break;
    }
}


function FlashSuccess($link = '', $data = "something something has success", $mode = 'set')
{
    $session = \Config\Services::session();
    // $session->setFlashdata('data', $data);
    // return redirect()->to($link);



    switch ($mode) {
        case 'set':
            $session->setFlashdata('data', $data);
            return redirect()->to($link);
            break;

        case 'get':
            if ($session->getFlashdata('data') !== '') {
                return $session->getFlashdata('data');
            }
            break;

        default:
            return null;
            break;
    }
}
