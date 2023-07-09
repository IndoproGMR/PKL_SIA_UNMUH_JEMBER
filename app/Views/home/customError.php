<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>

<body>
    <div style="
    position: absolute;
    left: 50%;
    top: 50%;">
        <p>Error Terdeteksi:</p>
        <p><?= esc(FlashException('', 'get')) ?></p>
        <p>Halaman akan diarahkan ke <span><a href="<?= base_url('/'); ?>">Dashboard</a></span> dalam <span id="countdown">10</span> detik.</p>
    </div>
</body>
<script>
    var count = 10;

    function countdown() {
        if (count == 0) {
            window.location.href = "<?= base_url('/'); ?>";
        } else {
            document.getElementById("countdown").textContent = count;
            count--;
            setTimeout(countdown, 1000);
        }
    }

    setTimeout(countdown, 1);
</script>

</html>