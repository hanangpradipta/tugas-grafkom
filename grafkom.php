<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Algoritma Bresenham dengan Bootstrap</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        table {
            border-collapse: collapse;
            margin: auto;
            width: 100%;
        }
        td {
            text-align: center;
            vertical-align: middle;
        }
        .black {
            background-color: black;
        }
        .wave {
            display: inline-block;
            animation: wave-animation 1s;
        }
        @keyframes wave-animation {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 id="title" class="text-center">Algoritma-Bresenham</h1>
        <form method="post" class="form-inline justify-content-center mt-3" onsubmit="animateTitle()">
            <div class="row d-flex align-items-end">
                <div class="form-group mb-2 col">
                    <label for="x1" class="sr-only">X1</label>
                    <input type="number" class="form-control" id="x1" name="x1" placeholder="X1" required>
                </div>
                <div class="form-group mx-sm-3 mb-2 col">
                    <label for="y1" class="sr-only">Y1</label>
                    <input type="number" class="form-control" id="y1" name="y1" placeholder="Y1" required>
                </div>
                <div class="form-group mb-2 col">
                    <label for="x2" class="sr-only">X2</label>
                    <input type="number" class="form-control" id="x2" name="x2" placeholder="X2" required>
                </div>
                <div class="form-group mx-sm-3 mb-2 col">
                    <label for="y2" class="sr-only">Y2</label>
                    <input type="number" class="form-control" id="y2" name="y2" placeholder="Y2" required>
                </div>
                <button type="submit" class="btn btn-primary mb-2 col h-25">Gambar Garis</button>
            </div>
        </form>

        <?php
        // Fungsi untuk menggambar garis menggunakan Algoritma Bresenham
        function drawLine($x1, $y1, $x2, $y2) {
            $dx = abs($x2 - $x1);
            $dy = abs($y2 - $y1);
            $sx = ($x1 < $x2) ? 1 : -1;
            $sy = ($y1 < $y2) ? 1 : -1;
            $err = $dx - $dy;

            $line = [];
            
            while (true) {
                $line[] = ["x" => $x1, "y" => $y1]; // Menyimpan titik saat ini ke dalam array
                if ($x1 == $x2 && $y1 == $y2) {
                    break;
                }
                $e2 = 2 * $err;
                if ($e2 > -$dy) {
                    $err -= $dy;
                    $x1 += $sx;
                }
                if ($e2 < $dx) {
                    $err += $dx;
                    $y1 += $sy;
                }
            }
            
            return $line;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $x1 = intval($_POST['x1']);
            $y1 = intval($_POST['y1']);
            $x2 = intval($_POST['x2']);
            $y2 = intval($_POST['y2']);

            // Menggambar garis berdasarkan input pengguna
            $line = drawLine($x1, $y1, $x2, $y2);

            // Menentukan ukuran grid
            $maxX = max(array_column($line, 'x'));
            $maxY = max(array_column($line, 'y'));
        } else {
            $maxX = $maxY = 20; // Ukuran default grid saat halaman pertama kali dimuat
        }

        // Menampilkan hasil dalam tabel
        echo "<div class='table-container d-none'><table class='mt-5 table table-bordered'>";
        // Sumbu Y
        for ($y = $maxY; $y >= 0; $y--) {
            echo "<tr>";
            // Sumbu X
            for ($x = 0; $x <= $maxX; $x++) {
                if ($y == 0) {
                    echo "<td style='width:calc(100% / ($maxX + 2));'>" . ($x > 0 ? $x : "") . "</td>"; // Angka pada sumbu X
                } else if ($x == 0) {
                    echo "<td style='width:calc(100% / ($maxX + 2));'>" . $y . "</td>"; // Angka pada sumbu Y
                } else {
                    $isLine = false;
                    if (isset($line)) {
                        foreach ($line as $point) {
                            if ($point['x'] == $x && $point['y'] == $y) {
                                $isLine = true;
                                break;
                            }
                        }
                    }
                    if ($isLine) {
                        echo "<td class='bg-primary' style='width:calc(100% / ($maxX + 2));'></td>";
                    } else {
                        echo "<td style='width:calc(100% / ($maxX + 2));'></td>";
                    }
                }
            }
            echo "</tr>";
        }
        echo "</table></div>";
        ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            animateTitle();
        });

        function animateTitle() {
            const h1 = document.getElementById('title');
            h1.innerHTML = h1.textContent.split('').map((char, index) => `<span class="wave" style="animation-delay:${index * 0.1}s">${char}</span>`).join('');
            setTimeout(() => {
                h1.innerHTML = h1.textContent;
            }, 3000);
        }

        function slideDownSlow(selector) {
            $(selector).hide().removeClass('d-none').slideDown('slow');
        }

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        $(document).ready(function() {
            setTimeout(function() {
                slideDownSlow('.table-container');
            }, 3000);
        });
        <?php endif; ?>
    </script>
</body>
</html>
