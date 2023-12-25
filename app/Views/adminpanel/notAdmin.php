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
    <h4>Request Access</h4>
    <button>Hide Admin Panel?</button>
    <script>
        document.querySelector("button").addEventListener("click", function() {
            localStorage.setItem("showadmin", "false");
            window.location = "/";
        });
    </script>
</div>



<?= $this->endSection() ?>