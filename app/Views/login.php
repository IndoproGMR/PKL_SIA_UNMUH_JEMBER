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
</style>

<h3>Login Sebagai</h3>
<!-- <a href="debuglogin/Mahasiswa/Budi">Mahasiswa Budi</a>
<a href="debuglogin/Mahasiswa/Septian">Mahasiswa Septian</a>
<a href="debuglogin/Dosen/Dedi">Dosen Dedi</a>
<a href="debuglogin/Dosen/Yulianto">Dosen Yulianto</a>
<a href="debuglogin/Pengajaran/Hassan">Pengajaran Hassan</a>
<a href="debuglogin/Pengajaran/Oliver">Pengajaran Oliver</a>
<a href="debuglogin/Dekan/Kevin">Dekan Kevin</a>
<a href="debuglogin/Dekan/Lukas">Dekan Lukas</a> -->

<form action="" method="post">
    <select name="logindengan" id="logindengan">
        <?php foreach ($datalogin as $login) : ?>
            <option value="<?= esc($login['id']) ?>"><?= esc($login['name']) ?></option>
        <?php endforeach ?>
    </select>
    <input type="submit" value="login">
</form>