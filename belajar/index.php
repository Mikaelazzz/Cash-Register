<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Register</title>
</head>

<body>
    <form action="proses.php" method="post">
        <label for="nama">Nama Pelanggan:</label><br>
        <input type="text" name="nama" required><br>
        <label for="tanggal">Tanggal Pemesanan:</label><br>
        <input type="date" name="tanggal" required><br>
        <label for="jam">Jam Pemesanan:</label><br>
        <input type="time" name="jam" required><br><br>
        <input type="submit" name="submit" value="Lanjutkan ke Pemesanan">
    </form>
</body>

</html>
