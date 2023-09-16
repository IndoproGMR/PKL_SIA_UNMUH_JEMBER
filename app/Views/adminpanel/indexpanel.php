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
                <input id="pass" name="pass" type="text" placeholder="Password">
                <input type="submit" value="Login">
            </form>

        <?php else : ?>

            <h4>Selamat datang</h4>

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
    <?php endif ?>
</div>



<?= $this->endSection() ?>