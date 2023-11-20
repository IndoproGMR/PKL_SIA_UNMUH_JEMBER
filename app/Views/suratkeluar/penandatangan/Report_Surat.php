<?= $this->extend('templates/layout.php') ?>


<?= $this->section('main') ?>
<form class="inputform" action="<?= base_url('/Update-Proses/Report-Surat'); ?>" method="post">
    <input type="hidden" name="id" value="<?= esc($id); ?>">
    <?= csrf_field() ?>
    <h1>Report Surat</h1>


    <label for="Diskripsi">Ada Apa Dengan Surat ini?</label>
    <br>
    <textarea name="diskripsi" id="Diskripsi" maxlength="254"></textarea>
    <br>
    <br>

    <div>
        <label for="confirmReport">Confirm Report ?</label>
        <input type="checkbox" id="confirmReport">
    </div>

    <br>
    <input type="submit" value="report" class="Actions danger" id="tombolUpdate" disabled>
    <br>
    <br>
</form>

<?= $this->endSection() ?>
<?= $this->section('jsF') ?>
<script>
    // Input field
    document.getElementById('Diskripsi').addEventListener("input", () => {
        document.getElementById("tombolUpdate").classList.add('danger');
        document.getElementById("tombolUpdate").setAttribute('disabled', '');
        document.getElementById("confirmReport").checked = false;
    });

    document.getElementById('confirmReport').addEventListener("click", () => {
        document.getElementById("tombolUpdate").classList.remove('danger')
        document.getElementById("tombolUpdate").removeAttribute('disabled');
    });
</script>
<?= $this->endSection() ?>