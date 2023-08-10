<?= $this->extend('templates/layout.php') ?>

<?= $this->section('jsH') ?>

<script src="<?= base_url('/'); ?>module/tinymce/tinymce/tinymce.min.js" referrerpolicy="origin"></script>


<script>
    const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    tinymce.init({
        selector: '#mytextarea',
        branding: false,
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
            'autoresize',
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

<style>
    .tomboladd {
        background-color: green;
        color: white;
        width: 30%;
        margin-right: 16px;
        padding: 12px;
        margin-bottom: 16px;
        margin-top: 6px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .tomboladd:hover {
        background-color: #aaffaa;
    }


    input[type=text] {
        width: 80%;
        padding: 12px;
        margin-bottom: 16px;
        margin-top: 6px;
        border-radius: 4px;
        border: 1px solid #ccc;

    }

    input[type=button] {
        background-color: red;
        color: white;
        width: 15%;
        padding: 12px;
        margin-bottom: 16px;
        margin-top: 6px;
        border-radius: 4px;
        border: 1px solid #ccc;
        margin-left: 16px;
    }

    input[type=button]:hover {
        background-color: #ffaaaa;
    }

    button[type=submit] {
        background-color: green;
        color: white;
        width: 80%;
        padding: 12px;
        margin-bottom: 16px;
        margin-top: 6px;
        border-radius: 4px;
        border: 1px solid #ccc;
        margin-left: 16px;
    }

    button[type=submit]:hover {
        background-color: #aaffaa;
    }

    .informasipenting {
        color: red;
        text-align: center;

    }
</style>

<?= $this->endSection() ?>

<?= $this->section('main') ?>

<h1 style="text-align: center;">Edit isi Surat</h1>
<hr>
<br>
<form action="<?= base_url('/detail-surat'); ?>" method="post" id="inputisi">
    <?= csrf_field() ?>

    <textarea id="mytextarea" name="inputisi">
        <?= $datasurat['isiSurat'] ?>
    </textarea>
    <input hidden type="text" name="id" id="id" value="<?= esc($datasurat['id']) ?>">
    <br>
    <hr>

    <br>
    <input type="text" name="jenisSurat" id="jenisSurat" placeholder="JenisSurat" value="<?= esc($datasurat['name']) ?>">
    <br>
    <input type="text" name="diskripsi" id="diskripsi" placeholder="diskripsi" value="<?= esc($datasurat['description']) ?>">
    <br>

    <hr>
    <button type="submit" id="submit">upload</button>
</form>

<hr>
<br>
<p class="informasipenting">Mohon maaf input form dan ttd masi belum support untuk di edit</p>
<br>
<hr>

<?= $this->endSection() ?>