<?php

use App\Models\AuthUserGroup;

/**
 * $group array
 * $secure
 * 0 = cek dari session user
 * 1 = cek daro database
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
            echo "terjadi masalah pada perm";
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
