<?php

function timedecor()
{
    return '<p class="Time">Tanggal: <span class="waktu-sekarang"></span></p>';
}

function moreInfo($text)
{
    return '<span class="morInpo">' . esc($text) . '</span>';
}

/**
 * @param $target = _self,_blank
 */
function TombolTo(
    $link,
    $valueTombol,
    $Tombolclass = '',
    $target = "_self"
) {
    return '<a target="' . $target . '" class="' . $Tombolclass . '" href="' . $link . '">' . $valueTombol . '</a>';
}

// !Tombol

function TombolIDcheck($yesno, $link, $valueinput, $confirmText = "Apakah Anda Yakin?",)
{
    switch ($yesno) {
        case '0':
            return '<form action="' . base_url('/') . $link . '" method="POST">' . csrf_field() . '<label>' .
                '<input hidden type="submit" name="id" value="' . $valueinput . '"onclick="return confirm(\'' . $confirmText . '\');">' .
                '<svg class="pointer" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M32.5 5H7.5C6.83696 5 6.20107 5.26339 5.73223 5.73223C5.26339 6.20107 5 6.83696 5 7.5V32.5C5 33.163 5.26339 33.7989 5.73223 34.2678C6.20107 34.7366 6.83696 35 7.5 35H32.5C33.163 35 33.7989 34.7366 34.2678 34.2678C34.7366 33.7989 35 33.163 35 32.5V7.5C35 6.83696 34.7366 6.20107 34.2678 5.73223C33.7989 5.26339 33.163 5 32.5 5ZM7.5 32.5V7.5H32.5V32.5H7.5Z" fill="black" /></svg>' .
                '</label></form>';
            break;

        case '1':
            return '<form action="' . base_url('/') . $link . '" method="POST">' . csrf_field() . '<label>' .
                '<input hidden type="submit" name="id" value="' . $valueinput . '" onclick="return confirm(\'' . $confirmText . '\');">' .
                '<svg class="pointer" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M31.6667 5H8.33333C7.44928 5 6.60143 5.35119 5.97631 5.97631C5.35119 6.60143 5 7.44928 5 8.33333V31.6667C5 32.5507 5.35119 33.3986 5.97631 34.0237C6.60143 34.6488 7.44928 35 8.33333 35H31.6667C32.5507 35 33.3986 34.6488 34.0237 34.0237C34.6488 33.3986 35 32.5507 35 31.6667V8.33333C35 7.44928 34.6488 6.60143 34.0237 5.97631C33.3986 5.35119 32.5507 5 31.6667 5ZM31.6667 8.33333V31.6667H8.33333V8.33333H31.6667ZM16.6667 28.3333L10 21.6667L12.35 19.3L16.6667 23.6167L27.65 12.6333L30 15" fill="black" /></svg>' .
                '</label></form>';
            break;
        default:
            return '<form action="' . base_url('/') . $link . '" method="POST">' . csrf_field() . '<label>' .
                '<input hidden type="submit" name="id" value="' . $valueinput . '" onclick="return confirm(\'' . $confirmText . '\');">' .
                '<svg class="pointer" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M32.5 5H7.5C6.83696 5 6.20107 5.26339 5.73223 5.73223C5.26339 6.20107 5 6.83696 5 7.5V32.5C5 33.163 5.26339 33.7989 5.73223 34.2678C6.20107 34.7366 6.83696 35 7.5 35H32.5C33.163 35 33.7989 34.7366 34.2678 34.2678C34.7366 33.7989 35 33.163 35 32.5V7.5C35 6.83696 34.7366 6.20107 34.2678 5.73223C33.7989 5.26339 33.163 5 32.5 5ZM7.5 32.5V7.5H32.5V32.5H7.5Z" fill="black" /></svg>' .
                '</label></form>';
            break;
    }
}

// !Validasi
function Validasi_Foto()
{
    // data ada
    // apakah ini image
    // apakah file ini adalah jpg,jpeg,png
    // apakah ukuran ini tidak lebih dari 1025 kb
    return [
        'foto' => [
            'label' => 'Image File',
            'rules' => [
                'uploaded[foto]',
                'is_image[foto]',
                'mime_in[foto,image/jpg,image/jpeg,image/png]',
                'max_size[foto,1024]',
            ],
        ],
    ];
}

function Validasi_FilePDF()
{
    // data ada
    // apakah file ini adalah pdf
    // apakah ukuran ini tidak lebih dari 10 mb
    return [
        'filepdf' => [
            'rules' => [
                'uploaded[filepdf]',
                'mime_in[filepdf,application/pdf]',
                // 'max_size[filepdf,10240]',
            ],
        ],
    ];
}

function Validasi_Input($field)
{
    return [
        "$field" => [
            'rules'    => 'required',
            'errors'   => [
                'required'    => '{field} is required.'
            ]
        ],
    ];
}
