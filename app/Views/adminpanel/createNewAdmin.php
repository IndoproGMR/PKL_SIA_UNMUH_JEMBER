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

    <?php if ($pin2 !== '') : ?>
        <br>
        <hr>
        <br>
        <label for="pin2">Pin ke 2:</label>
        <input readonly name="Pin2" id="pin2" type="text" value="<?= esc($pin2) ?>">
        <br>
    <?php endif ?>
    <br>
    <hr>
    <br>
    <form action="<?= base_url('/Admin-Panel/Masukan-akun/step2'); ?>" method="post">
        <?= csrf_field() ?>
        <input hidden type="text" name="pin" value="<?= esc($pin1) ?>">
        <input type="submit" value="Refresh">
    </form>
    <br>
    <?php if ($pin2 == '') : ?>

        <hr>
        <br>
        <button id="copyButton">
            Copy Link
        </button>
        <br>
        <br>
        <hr>
        <br>
    <?php endif ?>

    <script>
        function copyToClipboard(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
        }

        const copyButton = document.getElementById('copyButton');

        copyButton.addEventListener('click', function() {
            const linkToCopy = "<?= base_url('/Admin-Panel/join'); ?>?pin=<?= esc($pin1) ?>";
            copyToClipboard(linkToCopy);
            alert('Tautan berhasil disalin ke clipboard: ' + linkToCopy);
        });
    </script>
</div>



<?= $this->endSection() ?>