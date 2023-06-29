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
    </tr>
    <?php
    foreach ($datacoba as $key => $value) {
        echo "<tr>";
        foreach ($value as $key2) {
            echo "<td>" . $key2 . "</td>";
        }
        echo "</tr>";
    }
    ?>


</table>

<form action="" method="post">
    <?= csrf_field() ?>
    <input type="text" name="dataLogin" placeholder="login">
    <input type="text" name="dataPassword" placeholder="password">
    <input type="submit" value="login">
</form>