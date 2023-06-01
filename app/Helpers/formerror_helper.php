<?php

function display_error($validation, $inputform)
{
    if ($validation->hasError($inputform)) {
        return "<span class='danger' style='color:#dc3545'>*" . $validation->getError($inputform) . "</span>";
    } else {
        return false;
    }
}
function backbutton(String $link)
{
    return "<span><a href='" . base_url() . $link . "' class='previous' >&laquo;</a></span>";
}
