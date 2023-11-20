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
</style>

<?= $this->endSection() ?>


<?= $this->section('main') ?>
<br>

<form class="inputform" action="<?= base_url('/Staff/input-proses/master-surat'); ?>" method="post" id="inputisi">
    <h1 style="text-align: center;">Input isi Surat</h1>
    <hr>
    <br>


    <?= csrf_field() ?>

    <textarea id="mytextarea" name="inputisi"></textarea>
    <br>
    <hr>

    <br>
    <div>
        <label for="jenisSurat" class="required">Nama Master Surat:</label>
        <input type="text" name="jenisSurat" id="jenisSurat" placeholder="JenisSurat">
    </div>
    <div>
        <label for="diskripsi" class="required">Diskripsi Master Surat:</label>
        <input type="text" name="diskripsi" id="diskripsi" placeholder="diskripsi">
    </div>

    <hr>
    <h4>Input Form</h4>
    <hr id="untuktambahdata">

    <input type="submit" id="submit" value="upload">
</form>

<br>
<hr>
<div class="TombolADD">
    <button onClick="addInput()" class="tomboladd">
        add input
    </button>
    <button onClick="addfoto()" class="tomboladd">
        add foto
    </button>
    <button onclick="addTTD()" class="tomboladd">
        add ttd
    </button>
</div>
<br>
<hr>
<br>
<!-- Penambahan TTD -->
<select name="" id="TTD">
    <option value="">TTD</option>
    <optgroup label="GroupLVL" title="GroupLVL">
        <?php foreach ($level as $levell) : ?>
            <option value="Group_<?= esc($levell)['Nama'] ?>"><?= esc($levell)['Nama'] ?></option>
        <?php endforeach ?>
    </optgroup>
    <optgroup label="Perorangan" title="Perorangan">
        <?php foreach ($ttd as $ttdd) : ?>
            <option value="Perorangan_<?= esc($ttdd)['login'] ?>"><?= esc($ttdd)['namattd'] ?> - <?= esc($ttdd)['lvl'] ?></option>
        <?php endforeach ?>
    </optgroup>
</select>
<!-- Penambahan TTD -->
<br>
<br>
<hr>
<br>

<?= $this->endSection() ?>




<?= $this->section('jsF') ?>

<script>
    var id = 0;
    var formfield = document.getElementById('inputisi');
    var button = document.getElementById('submit');
    var untuktambahdata = document.getElementById('untuktambahdata');

    function addInput() {
        var br = document.createElement("br");
        var newField = document.createElement('input');

        var delbox = document.createElement('input');
        var idinput = "input_" + id;
        // var idinput = "input[]";
        var delval = "delinputbox(\"" + idinput + "\")";

        newField.setAttribute("id", idinput);
        newField.setAttribute('name', "input[]");
        newField.setAttribute('type', 'text');
        newField.setAttribute('class', 'inputclass');
        newField.setAttribute("placeholder", "{{yang_akan_di_ubah}}");

        delbox.setAttribute("id", "del_" + idinput);
        delbox.setAttribute("type", 'button');
        delbox.setAttribute("onClick", delval);
        delbox.setAttribute('value', 'Delete');
        delbox.setAttribute('class', 'Delete');

        br.setAttribute('id', 'br_' + idinput);

        id++
        formfield.insertBefore(newField, untuktambahdata);
        formfield.insertBefore(delbox, untuktambahdata);
        formfield.insertBefore(br, untuktambahdata);
    }

    function addfoto() {
        const max = 1;
        var countfoto = 0;
        var jumlahfoto = document.getElementsByName('tambahan[]');

        for (var i = 0; i < jumlahfoto.length; i++) {
            var elem = jumlahfoto[i];
            countfoto++;
            if (elem.value === 'foto' && countfoto == max) {
                return;
            }
        }

        var br = document.createElement("br");
        var newField = document.createElement('input');

        var delbox = document.createElement('input');
        var idfoto = "tambahan_" + id;
        var delval = "delinputbox(\"" + idfoto + "\")";

        newField.setAttribute("readonly", "");
        newField.setAttribute("id", idfoto);
        newField.setAttribute('name', 'tambahan[]');
        newField.setAttribute('type', 'text');
        newField.setAttribute('class', 'inputclass');
        newField.setAttribute('value', 'foto');

        delbox.setAttribute("id", "del_" + idfoto);
        delbox.setAttribute("type", 'button');
        delbox.setAttribute("onClick", delval);
        delbox.setAttribute('value', 'Delete');
        delbox.setAttribute('class', 'Delete');

        br.setAttribute('id', 'br_' + idfoto);

        id++
        formfield.insertBefore(newField, untuktambahdata);
        formfield.insertBefore(delbox, untuktambahdata);
        formfield.insertBefore(br, untuktambahdata);
    }

    function addTTD() {
        var datavalue = document.getElementById('TTD').value;
        var br = document.createElement("br");
        var newField = document.createElement('input');

        var delbox = document.createElement('input');
        var idttd = "TTD_" + id;
        var delval = "delinputbox(\"" + idttd + "\")";

        newField.setAttribute("id", "TTD_" + id);
        newField.setAttribute('name', "TTD[]");
        newField.setAttribute('type', 'text');
        newField.setAttribute('class', 'inputclass');
        newField.setAttribute('readonly', '');

        delbox.setAttribute("id", "del_" + idttd);
        delbox.setAttribute("type", 'button');
        delbox.setAttribute("onClick", delval);
        delbox.setAttribute('value', 'Delete');
        delbox.setAttribute('class', 'Delete');

        br.setAttribute('id', 'br_' + idttd);

        id++
        newField.setAttribute("value", datavalue);
        formfield.insertBefore(newField, untuktambahdata);
        formfield.insertBefore(delbox, untuktambahdata);
        formfield.insertBefore(br, untuktambahdata);
    }


    function delinputbox(id) {
        var deleteinput = document.getElementById(id);
        var deletebutton = document.getElementById('del_' + id);
        var deletebr = document.getElementById('br_' + id);
        // console.log(deleteinput);
        formfield.removeChild(deleteinput);
        formfield.removeChild(deletebutton);
        formfield.removeChild(deletebr);
    }
</script>

<?= $this->endSection() ?>