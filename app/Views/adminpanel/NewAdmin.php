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


    <form action="" method="post">
        <?= csrf_field() ?>

        <input hidden type="text" name="pin1" value="<?= esc($pin1) ?>">

        <label for="pin2">Masukan Pin ke 2</label>
        <input id="pin2" name="pin2" type="text" value="">
        <br>
        <label for="password">Masukan Password</label>
        <input type="password" id="password" name="password">
        <br>
        <input type="submit" value="Login">

    </form>




</div>



<?= $this->endSection() ?>