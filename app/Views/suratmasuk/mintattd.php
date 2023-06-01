<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ttd</title>
</head>

<body>
    <form action="" method="post">
        <?= csrf_field() ?>


        <?php
        inputform($dataform);
        // d($foto);
        if (isset($foto)) {
            echo form_input(
                "foto",
                "",
                "class=''",
                'file'
            );
        }

        ?>
        <br>
        <input type="submit" value="sumit">
    </form>

</body>

</html>