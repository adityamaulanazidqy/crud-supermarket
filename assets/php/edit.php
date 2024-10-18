<?php
include 'config.php'; // Pastikan koneksi database benar

// Periksa jika ada ID yang diberikan
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data produk berdasarkan ID
    $query = "SELECT * FROM barang WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Data tidak ditemukan.";
        exit();
    }
}

if (isset($_POST['update'])) {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    // Update data produk
    $query = "UPDATE barang SET nama_produk='$nama_produk', harga='$harga', jumlah='$jumlah' WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: ../../index.php"); // Arahkan kembali setelah berhasil
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Edit Produk</title>
</head>

<body>
    <div class="container">
        <h1>Edit Produk</h1>
        <form action="" method="POST">
            <input type="text" name="nama_produk" value="<?php echo $row['nama_produk']; ?>" required>
            <input type="number" name="harga" value="<?php echo $row['harga']; ?>" required>
            <input type="number" name="jumlah" value="<?php echo $row['jumlah']; ?>" required>
            <button type="submit" name="update">Update Produk</button>
        </form>
    </div>
</body>

</html>