<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('/css/style.css'); ?>">
    <title>Authentication Failed</title>
</head>

<style>
    .kontenerUtama {
        display: flex;
        justify-content: center;
        padding-top: 60px;
    }

    .textTitle {
        width: 600px;
    }

    .textTitle>h1 {
        text-align: center;
    }

    .scheduled-maintenance {
        margin-top: 40px;
        display: flex;
        justify-content: center;
        width: 600px;
    }

    .redirec {
        margin-top: 50px;
        text-align: center;
    }

    .redirec a {
        color: black;
    }
</style>

<body>
    <!-- Navbar -->
    <navbar class="">
        <div class="logo">
            <img src="<?= base_url('/asset/logo/small/unmuh-tiny.png'); ?>" alt="logo" class="">
        </div>

        <div class="navbody">
            <div class="navbar">
                <p class="title">Web Surat</p>
                <p class="title">Universitas Muhammadiyah Jember</p>
            </div>

        </div>
    </navbar>
    <!-- End Navbar -->


    <div class="kontenerUtama">
        <div class="textTitle">
            <h1>Anda Tidak Memiliki Akses Ke Halaman ini !!</h1>
            <div class="scheduled-maintenance">
                <img src="<?= base_url('/asset/svg/baseline-do-not-touch.svg'); ?>" alt="" srcset="">
            </div>
            <div class="redirec">
                <p>Kembali ke
                    <span><a href="<?= base_url('/'); ?>">Dashboard</a></span>
                    <span id="countdown">10</span>S
                </p>
            </div>
        </div>
    </div>

</body>

</html>


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