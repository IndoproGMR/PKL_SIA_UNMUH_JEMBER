<?= $this->extend('templates/layout.php') ?>

<?= $this->section('jsH') ?>

<script src="<?= base_url('/module/tinymce/tinymce/tinymce.min.js'); ?>" referrerpolicy="origin"></script>


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
    .TombolADD {
        display: flex;
        justify-content: space-between;
    }

    .tomboladd {
        flex: 1;
        margin: 0 5px;

        background-color: green;
        color: white;
        margin-right: 16px;
        padding: 12px;
        margin-bottom: 16px;
        margin-top: 6px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .inputclass {
        height: 40px !important;
        width: 75% !important;
    }

    .tomboladd:hover {
        background-color: #aaffaa;
    }

    .Delete {
        background-color: red !important;
        width: 22% !important;
        margin-left: 3% !important;
        height: 40px !important;
    }




    input[type=text] {
        width: 80%;
        padding: 12px;
        margin-bottom: 16px;
        margin-top: 6px;
        border-radius: 4px;
        border: 1px solid #ccc;
        height: 40px !important;
    }

    .informasipenting {
        color: red;
        text-align: center;

    }
</style>

<?= $this->endSection() ?>

<?= $this->section('main') ?>

<br>
<form class="inputform" action="<?= base_url('/Staff/detail/Master-Surat'); ?>" method="post" id="inputisi">
    <h1 style="text-align: center;">Edit isi Surat</h1>
    <hr>
    <br>
    <?= csrf_field() ?>

    <textarea id="mytextarea" name="inputisi">
        <?= $datasurat['isiSurat'] ?>
    </textarea>
    <input type="hidden" name="id" id="id" value="<?= esc($datasurat['id']) ?>">

    <br>
    <hr>
    <br>

    <div>
        <label for="jenisSurat" class="required">Nama Master Surat:</label>
        <input type="text" name="jenisSurat" id="jenisSurat" placeholder="JenisSurat" value="<?= esc($datasurat['name']) ?>">
    </div>
    <div>
        <label for="diskripsi" class="required">Diskripsi Master Surat:</label>
        <input type="text" name="diskripsi" id="diskripsi" placeholder="diskripsi" value="<?= esc($datasurat['description']) ?>">
    </div>

    <input type="submit" id="submit" value="Update">
</form>

<hr>
<br>
<p class="informasipenting">Mohon maaf input form dan ttd masi belum support untuk di edit</p>
<br>
<hr>

<?= $this->endSection() ?>