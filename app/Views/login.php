<?php

$datacoba = [
    '1' => [
        'login' => 'yuni',
        'password' => '*FDF3D0567'
    ],
    '2' => [
        'login' => '99111084',
        'password' => '*6947C77DB'
    ],
    '3' => [
        'login' => 'yasin',
        'password' => '*30C2AA2CF'
    ],
    '4' => [
        'login' => '0000001',
        'password' => '*638F025EF'
    ],
    '5' => [
        'login' => '0001016602',
        'password' => '*3FB29F57B'
    ],
    '6' => [
        'login' => '1210652011',
        'password' => '*3E5287812'
    ],
    '7' => [
        'login' => '20110168',
        'password' => '*1D90AF5D1'
    ],
    '8' => [
        'login' => '00063007',
        'password' => '*EE624E607'
    ],
    '9' => [
        'login' => '0001096501',
        'password' => '*F1DBCC704'
    ],
    '10' => [
        'login' => generateIdentifier(16, 'time'),
        'password' => generateIdentifier()
    ],
];



?>

<style>
    a {
        padding: 10px;
        background-color: #ccc;
        border-radius: 5px;
        color: #000;
    }

    a:hover {
        background-color: #aaa;
    }

    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
    }

    th,
    td {
        text-align: left;
        padding: 16px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>

<h3>Login Sebagai</h3>
<table>
    <tr>
        <th>Username</th>
        <th>login</th>
    </tr>
    <?php foreach ($datacoba as $key => $value) : ?>
        <tr>
            <td><?= $value['login'] ?></td>
            <td>
                <form action="" method="post">
                    <?= csrf_field() ?>
                    <input hidden type="text" name="dataLogin" placeholder="login" value="<?= $value['login'] ?>">
                    <input hidden type="text" name="dataPassword" placeholder="password" value="<?= $value['password'] ?>">
                    <input type="submit" value="login">
                </form>
            </td>
        </tr>
    <?php endforeach ?>


</table>