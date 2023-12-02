<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('/css/style.css'); ?>">
    <script src="<?= base_url('/js/Cookie_Lib.js'); ?>"></script>
    <title>Server Failed</title>
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

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 5px;
        min-width: 400px;
        min-height: 300px;
        margin: 0 auto;
        text-align: center;
        z-index: 100;
    }

    .modal-close {
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .msg {
        margin-top: 10px;
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
            <h1>Mohon Maaf Terjadi Masalah Dengan Server</h1>
            <!-- Bila Img di click maka akan menampilkan pop up ErrorMSG -->
            <div class="scheduled-maintenance">
                <img id="showmsg" src="<?= base_url('/asset/svg/Round-Error.svg'); ?>" alt="" srcset="">
            </div>

            <div class="redirec">
                <p>Kembali ke
                    <span><a href="<?= base_url('/'); ?>">Dashboard</a></span>
                    <span id="countdown">10</span>S
                </p>
            </div>

        </div>
    </div>

    <!-- Pop Up Yang Memberitahukan Apa masalahnya -->
    <div id="errorModal" class="modal">
        <div class="modal-content" id="modal-content">
            <!-- <span id="closeModal" class="modal-close">&times;</span> -->
            <h4>Masalah Pada Server</h4>
            <hr>
            <div class="msg">
                <!-- <p>Data Error</p> -->
                <p id="errorContent"><?= esc(FlashException('', 'get')) ?></p>
            </div>
        </div>
    </div>



</body>

</html>


<script>
    // Show modal function
    function showModal() {
        var modal = document.getElementById('errorModal');
        modal.style.display = 'flex';
    }

    // Hide modal function
    function hideModal() {
        var modal = document.getElementById('errorModal');
        modal.style.display = 'none';
    }

    // Show the modal when the page loads
    window.onload = function() {
        // showModal();
    };

    var showmsg = document.getElementById('showmsg');
    showmsg.addEventListener('click', showModal);

    // Set up the close modal event
    var closeModal = document.getElementById('errorModal');
    closeModal.addEventListener('click', hideModal);


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