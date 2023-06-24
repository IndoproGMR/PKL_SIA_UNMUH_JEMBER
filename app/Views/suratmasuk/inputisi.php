<?= $this->extend('templates/layout.php') ?>

<?= $this->section('main') ?>
<br>
<div style="text-align: center;">

    <h1 style="color: green;">
        dinamic field
    </h1>
    <p>
        Click on the button to create
        a form dynamically

    </p>

    <button onClick="add()">
        add input
    </button>
    <button onClick="addfoto()">
        add foto
    </button>
    <button onclick="addTTD()">
        add ttd
    </button>
    <br>
    <!-- <br> -->

    <form action="" method="post" name="inputisi" id="inputisi">
        <?= csrf_field() ?>
        <textarea name="isiDariSurat" id="isiDariSurat" placeholder="isi surat"></textarea>
        <br>
        <input type="text" name="diskripsi" id="diskripsi" placeholder="diskripsi">
        <br>
        <input type="text" name="jenisSurat" id="jenisSurat" placeholder="JenisSurat">
        <br>
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
        <!-- <input hidden type="number" name="total" id="total"> -->
        <br>
        <input type="submit" value="Submit" id="submit">
    </form>

</div>

<?= $this->endSection() ?>




<?= $this->section('jsF') ?>

<script>
    var id = 0;
    var formfield = document.getElementById('inputisi');
    var button = document.getElementById('submit')

    function add() {
        var br = document.createElement("br");
        var newField = document.createElement('input');
        newField.setAttribute("id", "input_" + id);
        newField.setAttribute('name', "input_" + id);
        newField.setAttribute('type', 'text');
        newField.setAttribute('class', 'inputclass');
        id++
        newField.setAttribute("placeholder", "{{yang_akan_di_ubah}}");
        formfield.insertBefore(newField, button);
        formfield.insertBefore(br, button);
    }

    function addfoto() {
        var jumlahfoto = document.getElementsByName('tambahan_foto').length
        if (jumlahfoto > 0) {
            return
        }
        var br = document.createElement("br");
        var newField = document.createElement('input');
        newField.setAttribute("readonly", "");
        newField.setAttribute("id", "tambahan_" + id);
        newField.setAttribute('name', 'tambahan_foto');
        newField.setAttribute('type', 'text');
        newField.setAttribute('class', 'inputclass');
        newField.setAttribute('value', 'foto');
        id++
        formfield.insertBefore(newField, button);
        formfield.insertBefore(br, button);
    }

    function addTTD() {
        var datavalue = document.getElementById('TTD').value;
        var br = document.createElement("br");
        var newField = document.createElement('input');
        newField.setAttribute("id", "TTD_" + id);
        newField.setAttribute('name', "TTD_" + id);
        newField.setAttribute('type', 'text');
        newField.setAttribute('class', 'inputclass');
        newField.setAttribute('readonly', '');
        id++
        newField.setAttribute("value", datavalue);
        formfield.insertBefore(newField, button);
        formfield.insertBefore(br, button);
    }

    function remove() {
        var input_tags = formfield.getElementsByTagName('input');
        if (input_tags.length > 2) {
            formfield.removeChild(input_tags[(input_tags.length) - 1]);
        }
    }

    function countclass() {
        let countclass = document.getElementsByClassName("inputclass").length;
        document.getElementById("total").value = countclass;
    }
</script>
<?= $this->endSection() ?>