<?php

use App\Models\AuthUserGroup;

function in_group(String $group)
{
    $AuthUserGroup = model(AuthUserGroup::class);
    if ($group == $AuthUserGroup->cekgroupbyuserid(user_id())['name']) {
        return true;
    }
    return false;
}

function user_id()
{
    $session = \Config\Services::session();
    if ($session->get('userdata')) {
        return $session->get('userdata')['id'];
    }
    return 0;
}

function PagePerm($group)
{
    $izin = false;
    foreach ($group as $namagrup) {
        if (in_group($namagrup)) {
            $izin = true;
            break;
        }
    }

    if (!$izin) {
        throw new \CodeIgniter\Router\Exceptions\RedirectException("error_perm");
    }
}
