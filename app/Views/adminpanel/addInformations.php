<?= $this->extend('templates/layout.php') ?>

<?= $this->section('jsH') ?>


<script src="<?= base_url('/module/tinymce/tinymce/tinymce.min.js'); ?>" referrerpolicy="origin"></script>


<script>
    const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    tinymce.init({
        selector: '#mytextarea',
        branding: false,
        // height: 1600,
        // menubar: false,
        // remove_script_host: false,
        toolbar_sticky: true,
        plugins: [
            'image',
            'preview',
            'pagebreak',
            'quickbars',
            'searchreplace',
            'table',
            'visualchars',
            'wordcount',
            'visualblocks',
            'insertdatetime',
            'importcss',
            'fullscreen',
            'help',
            'emoticons',
            'save',
            'autosave',
            'codesample',
            'code',
            'lists',
            'advlist',
            // 'autoresize',
            'anchor',
            'nonbreaking',
            'directionality',
            'charmap',
            // 'hr',
            // 'contextmenu',
            // 'paste',
            // 'textcolor',
            // 'responsivefilemanager',s
            // 'print',
            // 'autolink',
        ],
        toolbar1: "undo redo | fontfamily fontsize blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | restoredraft",
        toolbar2: "image link unlink anchor | forecolor backcolor  | table | print preview code fullscreen",
        image_advtab: true,
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        // skin: useDarkMode ? 'oxide-dark' : 'oxide',
        // content_css: useDarkMode ? 'dark' : 'default',
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    });
</script>

<?= $this->endSection() ?>

<?= $this->section('style') ?>



<?= $this->endSection() ?>


<?= $this->section('main') ?>
<br>

<form class="inputform" action="<?= base_url('/Admin-Panel/Input-info/upload'); ?>" method="post" id="inputisi">
    <?= csrf_field() ?>

    <h1 style="text-align: center;">Input isi Surat</h1>
    <hr>

    <br>
    <textarea id="mytextarea" name="inputisi">
        <?= $informations ?>
    </textarea>
    <br>

    <hr>
    <input type="submit" id="submit" value="upload">
</form>



<?= $this->endSection() ?>