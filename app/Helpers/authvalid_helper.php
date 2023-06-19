<?php

use App\Models\AuthUserGroup;

function in_group($group)
{
    $AuthUserGroup = model(AuthUserGroup::class);
    foreach ($group as $namagrup) {
        if ($namagrup == $AuthUserGroup->cekgroupbyuserid(user_id())['name']) {
            return true;
            break;
        }
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
    if (!in_group($group)) {
        throw new \CodeIgniter\Router\Exceptions\RedirectException("error_perm");
    }
}
