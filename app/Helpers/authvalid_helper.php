<?php

use App\Models\AuthUserGroup;

function in_group(String $group)
{
    $AuthUserGroup = model(AuthUserGroup::class);
    $hasil = false;
    if ($group == $AuthUserGroup->cekgroupbyuserid(user_id())['name']) {
        $hasil = true;
    }
    return $hasil;
}

function user_id()
{
    $session = \Config\Services::session();
    return $session->get('userdata')['id'];
}
