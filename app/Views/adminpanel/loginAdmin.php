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
    <form class="inputform" action="<?= base_url('/Admin-Panel/login'); ?>" method="post">
        <?= csrf_field() ?>
        <div>
            <label for="pass">Password:</label>
            <input id="pass" name="pass" type="password" placeholder="Password">
        </div>

        <input type="submit" value="Login">
    </form>
</div>



<?= $this->endSection() ?>