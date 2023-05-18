<!DOCTYPE html>
<html>

<head>
    <title>
        input
    </title>
</head>

<body style="text-align: center;">
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



    <form action="" method="post" name="inputisi" id="inputisi">
        <?= csrf_field() ?>
        <textarea name="isiDariSurat" id="isiDariSurat"></textarea>
        <br>
        <input type="text" name="diskripsi" id="diskripsi">
        <br>
        <select name="jenisSurat" id="jenisSurat">
            <?php foreach ($jenissurat as $datajenissurat) : ?>

                <option value="<?= $datajenissurat['id'] ?>"><?= $datajenissurat['name'] ?> - <?= $datajenissurat['description'] ?></option>
            <?php endforeach ?>
        </select>
        <br>
        <!-- <input hidden type="number" name="total" id="total"> -->
        <input type="submit" value="Submit" id="submit">
    </form>
    <script>
        var id = 0;
        var formfield = document.getElementById('inputisi');
        var button = document.getElementById('submit')

        function add() {
            var br = document.createElement("br");
            var newField = document.createElement('input');
            newField.setAttribute("id", id);
            newField.setAttribute('type', 'text');
            newField.setAttribute('name', id);
            newField.setAttribute('class', 'inputclass');
            id++
            newField.setAttribute("placeholder", "{{yang akan di ubah}}");
            formfield.insertBefore(newField, button);
            formfield.insertBefore(br, button);
            // formfield.appendChild(br);

            // formfield.appendChild(newField);
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
</body>

</html>