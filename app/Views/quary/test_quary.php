<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>quary</title>
</head>
<style>
    #myInput {
        width: 200px;
    }

    #autocomplete-list {
        position: absolute;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        z-index: 9999;
        width: 200px;
        max-height: 150px;
        overflow-y: auto;
    }

    #autocomplete-list div {
        padding: 10px;
        cursor: pointer;
    }

    #autocomplete-list div:hover,
    #autocomplete-list div.selected {
        background-color: #e9e9e9;
    }

    body {
        padding: 5px;
    }
</style>

<body>
    <form action="" method="post">
        <?= csrf_field() ?>
        <div>
            <input name="SearchData" type="text" id="myInput" placeholder="Cari...">
            <div id="autocomplete-list"></div>
        </div>
        <input type="submit" value="cari">
    </form>
    <script>
        <?php helper('datacall'); ?>

        <?= datacallorder(1); ?>

        // Mendapatkan elemen-elemen yang diperlukan
        var input = document.getElementById("myInput");
        var autocompleteList = document.getElementById("autocomplete-list");
        var selectedOptionIndex = -1;
        var maxAutocomplete = 3; // Jumlah maksimal autocompletions yang akan ditampilkan

        // Event listener ketika pengguna mengetik pada input
        input.addEventListener("input", function() {
            var inputValue = this.value.trim();
            selectedOptionIndex = -1;
            closeAutocomplete();

            var words = inputValue.split(" ");
            var lastWord = words[words.length - 1];

            // Mengecek apakah input dimulai dengan tanda "-" (strip)
            var hasDash = words.length > 0 && words[words.length - 1].startsWith("-");
            if (!inputValue || !hasDash) {
                return;
            }





            // Mencari data yang cocok dengan kata terakhir dari input yang diketik
            var matches = data.filter(function(item) {
                return item.toLowerCase().indexOf(lastWord.toLowerCase()) !== -1;
            });

            // Menampilkan hasil autocompletion dengan batasan jumlah
            for (var i = 0; i < matches.length && i < maxAutocomplete; i++) {
                var match = matches[i];
                var option = document.createElement("div");
                option.innerHTML = "<strong>" + match.substr(0, lastWord.length) + "</strong>";
                option.innerHTML += match.substr(lastWord.length);
                option.addEventListener("click", function() {
                    words[words.length - 1] = match;
                    input.value = words.join(" ");
                    closeAutocomplete();
                });
                autocompleteList.appendChild(option);
            }
        });

        // Event listener ketika pengguna menekan tombol pada input
        input.addEventListener("keydown", function(event) {
            if (event.key === "ArrowUp") {
                event.preventDefault();
                navigateOptions("up");
            } else if (event.key === "ArrowDown") {
                event.preventDefault();
                navigateOptions("down");
            } else if (event.key === "Enter") {
                event.preventDefault();
                selectOption();
            }
        });

        // Event listener ketika pengguna mengklik di luar elemen autocompletion
        document.addEventListener("click", function(event) {
            if (event.target !== input) {
                closeAutocomplete();
            }
        });

        // Navigasi pilihan autocompletion menggunakan tombol panah
        function navigateOptions(direction) {
            var options = autocompleteList.querySelectorAll("div");
            var numOptions = options.length;

            if (numOptions === 0) {
                return;
            }

            if (direction === "up") {
                selectedOptionIndex = (selectedOptionIndex - 1 + numOptions) % numOptions;
            } else if (direction === "down") {
                selectedOptionIndex = (selectedOptionIndex + 1) % numOptions;
            }

            options.forEach(function(option, index) {
                if (index === selectedOptionIndex) {
                    option.classList.add("selected");
                } else {
                    option.classList.remove("selected");
                }
            });
        }

        // Memilih opsi autocompletion yang dipilih menggunakan tombol Enter
        function selectOption() {
            var options = autocompleteList.querySelectorAll("div");
            var numOptions = options.length;

            if (numOptions === 0 || selectedOptionIndex === -1) {
                return;
            }

            var selectedOption = options[selectedOptionIndex];
            var inputValue = input.value.trim();
            var words = inputValue.split(" ");
            var lastWord = words[words.length - 1];
            var match = selectedOption.innerText;

            words[words.length - 1] = match;
            input.value = words.join(" ");
            closeAutocomplete();
        }

        // Menutup autocompletion
        function closeAutocomplete() {
            autocompleteList.innerHTML = "";
            selectedOptionIndex = -1;
        }
    </script>
</body>

</html>