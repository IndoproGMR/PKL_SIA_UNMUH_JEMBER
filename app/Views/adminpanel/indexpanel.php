<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/css/tablestyle.css'); ?>">

<!-- masukan style nya -->
<style>
    .card {
        margin: 50px;
    }

    .card>h1,
    .card>h4 {
        text-align: center;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="card">
    <h1>Admin Panel</h1>

    <?php if (in_admin()) : ?>

        <?php if (!userAdmin()) : ?>

            <form action="<?= base_url('/Admin-Panel/login'); ?>" method="post">
                <?= csrf_field() ?>
                <label for="pass">Password:</label>
                <input id="pass" name="pass" type="password" placeholder="Password">
                <input type="submit" value="Login">
            </form>

        <?php else : ?>

            <h4>Selamat datang</h4>

            <h5>TODO:LIST</h5>
            <ul>
                <li>cek berapa data dari DeleteAt</li>
                <li>pulihkan data dari DeleteAt</li>
                <li>Clear Database dari DeleteAt</li>

                <li>cek berapa banyak Surat yang sudah di minta</li>
                <li>cek berapa banyak Surat yang sudah di Tanda Tangani</li>
            </ul>



            <div>
                <?= view_cell('TombolIdCell', [
                    'link'              => '/Admin-Panel/Input-info',
                    'valueinput'        => '',
                    'tombolsubmitclass' => 'Actions',
                    'textsubmit'        => 'Ubah Informasi Board',
                    'target'            => '_self',
                    'method'            => 'get'
                ]) ?>
            </div>



            <div>
                <?= view_cell('TombolIdCell', [
                    'link'              => '/Admin-Panel/Masukan-akun',
                    'valueinput'        => '',
                    'tombolsubmitclass' => 'Actions',
                    'textsubmit'        => 'Masukan Akun',
                    'target'            => '_self',
                    'method'            => 'get'
                ]) ?>
            </div>


        <?php endif ?>
    <?php else : ?>
        <h4>Request Access</h4>
        <button>Hide Admin Panel?</button>
        <script>
            document.querySelector("button").addEventListener("click", function() {
                localStorage.setItem("showadmin", "false");
                window.location = "/";
            });
        </script>
    <?php endif ?>
</div>



<?= $this->endSection() ?>