<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/css/tablestyle.css'); ?>">

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
</style>

<?= $this->endSection() ?>


<?= $this->section('main') ?>

<div class="filter">
    <p class="first">Filter:</p>
    <?= timedecor() ?>
</div>

<form action="<?= base_url('/Staff/test-proses/Master-Surat'); ?>" method="get" id="inputisi" target="_blank">
    <?= csrf_field() ?>

    <input hidden type="text" name="id" value="<?= esc($id) ?>">
    <br>
    <hr>
    <h4>Input Form</h4>
    <hr id="untuktambahdata">

    <button type="submit" id="submit">Test Surat</button>
</form>
<br>
<hr>
<button onClick="addInput()" class="tomboladd">
    add input
</button>
<hr>


<?= view_cell('TombolIdCell', [
    'link'              => '/staff/Preview/' . $id,
    'tombolsubmitclass' => 'Actions',
    'textsubmit'        => 'Preview Surat',
    'target'            => '_blank',
    'method'            => 'get'
]) ?>

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

        br.setAttribute('id', 'br_' + idinput);

        id++
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