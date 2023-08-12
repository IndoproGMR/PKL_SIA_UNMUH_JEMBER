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
        <th>login</th>
        <th>password</th>
        <th>login</th>
    </tr>
    <?php foreach ($datacoba as $key => $value) : ?>
        <tr>
            <td><?= $value['login'] ?></td>
            <td><?= $value['password'] ?></td>
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