<?php

function display_error($validation, $inputform)
{
    if ($validation->hasError($inputform)) {
        return "<span class='danger' style='color:#dc3545'>*" . $validation->getError($inputform) . "</span>";
    } else {
        return false;
    }
}

function TombolID(
    $link,
    $valueinput,
    $submitclass = "",
    $valuesubmit = "submit",
    $formclass = "",
    $confirmText = "Apakah Anda Yakin?",
    $name = "id",
    $idinput = "",
    $inputclass = ""
) {
    $data = '<form action="' . $link . '" method="post" class="' . $formclass . '">' .
        csrf_field() .
        '<input hidden type="text" name="' . $name . '" value="' . $valueinput . '" id="' . $idinput . '" class="' . $inputclass . '">' .
        '<input type="submit" value="' . $valuesubmit .
        '" class="' . $submitclass .
        '" onclick="return confirm(\'' . $confirmText . '\');">' .
        '</form>';

    return $data;
}
