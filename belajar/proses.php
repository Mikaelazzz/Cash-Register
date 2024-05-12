<?php
session_start();

$timeout = 1;
$logout = "index.php";

$timeout = $timeout * 30;
if (isset($_SESSION['start_session'])) {
    $elapsed_time = time() - $_SESSION['start_session'];
    if ($elapsed_time >= $timeout) {
        session_destroy();
        echo "<script type='text/javascript'>alert('Sesi telah berakhir');window.location='$logout'</script>";
    }
}
$_SESSION['start_session'] = time();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $_SESSION["nama"] = $_POST["nama"];
    $_SESSION["tanggal"] = $_POST["tanggal"];
    $_SESSION["jam"] = $_POST["jam"];
}
$nama = isset($_SESSION["nama"]) ? $_SESSION["nama"] : "";
$tanggal = isset($_SESSION["tanggal"]) ? $_SESSION["tanggal"] : "";
$jam = isset($_SESSION["jam"]) ? $_SESSION["jam"] : "";

if (!isset($_SESSION["pesanan"])) {
    $_SESSION["pesanan"] = array();
}

function tambahPesanan($menu_id, $jumlah)
{
    $item_ditemukan = false;
    foreach ($_SESSION["pesanan"] as &$item) {
        if (isset($item["menu_id"]) && $item["menu_id"] == $menu_id) {
            $item["jumlah"] += $jumlah;
            $item_ditemukan = true;
            break;
        }
    }

    if (!$item_ditemukan) {
        array_push($_SESSION["pesanan"], array("menu_id" => $menu_id, "jumlah" => $jumlah));
    }
}

function kurangiPesanan($menu_id, $jumlah)
{
    foreach ($_SESSION["pesanan"] as $key => &$item) {
        if (isset($item["menu_id"]) && $item["menu_id"] == $menu_id) {
            $item["jumlah"] -= $jumlah;
            if ($item["jumlah"] <= 0) {
                unset($_SESSION["pesanan"][$key]);
            }
            break;
        }
    }
}

if (isset($_POST["tambah"])) {
    tambahPesanan($_POST["menu_id"], $_POST["jumlah"]);
} elseif (isset($_POST["kurangi"])) {
    kurangiPesanan($_POST["menu_id"], $_POST["jumlah"]);
}

echo "Selamat datang, " . $nama . "<br><br>";
echo "Tanggal pemesanan : " . $tanggal . " - " . $jam;
?>
<br>
<hr>
<?php
echo "Daftar Pesanan Anda:<br>";

$total_harga = 0;
foreach ($_SESSION["pesanan"] as $item) {
    if (isset($item["menu_id"])) {
        $menu_id = $item["menu_id"];
        $jumlah = $item["jumlah"];
        $harga_menu = 0;
        switch ($menu_id) {
            case 1:
                $nama_menu = "Ayam Mayo";
                $harga_menu = 14000;
                break;
            case 2:
                $nama_menu = "Ayam Katsu";
                $harga_menu = 15000;
                break;
            case 3:
                $nama_menu = "Ayam Koloke";
                $harga_menu = 16000;
                break;
            case 4:
                $nama_menu = "Ayam Bakar";
                $harga_menu = 17000;
                break;
        }
        $jumlah = intval($jumlah);
        $harga_menu = intval($harga_menu);
        $total_harga += $harga_menu * $jumlah;
        echo "ID : $menu_id, Pilihan : $nama_menu, Jumlah : $jumlah, Harga : Rp. $harga_menu<br>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan</title>
</head>

<style>
    * {
        font-family: monospace;
        ;
    }
</style>

<body>

    <br>
    ========== Menu ========== <br>
    1. Ayam Mayo Rp. 14000<br>
    2. Ayam Katsu Rp. 15000<br>
    3. Ayam Koloke Rp. 16000<br>
    4. Ayam Bakar Rp. 17000<br>
    ========== Menu ========== <br>

    Pilih nomor menu untuk menambah atau mengurangi pesanan :
    <br><br>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Nomor Menu : <input type='number' name='menu_id' min='1' max='4'><br><br>
        Jumlah: <input type='number' name='jumlah' min='1'><br><br>
        <input type='submit' name='tambah' value='Tambah'><br><br>
        <input type='submit' name='kurangi' value='Kurangi'>
        <br><br>
        <hr>
        <label for="total_harga">Total Harga:</label>
        <input type="text" name="total_harga" value="<?php echo isset($total_harga) ? $total_harga : ''; ?>"
            readonly><br><br>
        <label for="pembayaran">Pembayaran:</label>
        <input type="text" name="pembayaran"><br><br>
        <input type='submit' name='bayar' value='Bayar'><br>
        <hr>
        <?php
        if (isset($_POST["bayar"])) {
            $pembayaran = intval($_POST["pembayaran"]);
            $kembalian = $pembayaran - $total_harga;
            if ($kembalian < 0) {
                echo "Mohon masukkan uang dengan jumlah yang mencukupi.<br>";
            } else {
                ?>
                <label for="kembalian">Kembalian:</label>
                <input type="text" name="kembalian" value="<?php echo isset($kembalian) ? $kembalian : ''; ?>" readonly>
                <br><br>
                <?php
                echo "Terima kasih $nama telah berbelanja <br>Tanggal Pembelian : $tanggal - $jam" . "<br>Semoga harimu menyenangkan ^ ◡ ^";
            }
        }
        ?>
    </form>
</body>

</html>
