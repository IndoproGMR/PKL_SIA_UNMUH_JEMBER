<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('/css/style.css'); ?>">
    <title>Server Dalam Maintenance</title>
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
            <h1>Server Dalam Maintenance</h1>
            <h1>Mohon Tunggu Beberapa Saat Lagi</h1>
            <div class="scheduled-maintenance">
                <img src="<?= base_url('/asset/svg/scheduled-maintenance.svg'); ?>" alt="" srcset="">
            </div>
        </div>
    </div>

</body>

</html>