<?php
include 'config.php'; // Pastikan koneksi database benar

if (isset($_POST['submit'])) {
    // Kode untuk menambahkan produk
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    $query = "INSERT INTO barang (nama_produk, harga, jumlah) VALUES ('$nama_produk', '$harga', '$jumlah')";
    if (mysqli_query($conn, $query)) {
        header("Location: ../../index.php"); // Arahkan kembali ke index.php setelah berhasil
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Tambahkan ini untuk menangani penghapusan data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM barang WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        // Mengupdate ID setelah penghapusan
        $queryUpdate = "SELECT * FROM barang ORDER BY id"; // Ambil semua barang untuk update ID
        $result = mysqli_query($conn, $queryUpdate);

        $counter = 1; // Variabel untuk menghitung ID baru
        while ($row = mysqli_fetch_assoc($result)) {
            $updateQuery = "UPDATE barang SET id='$counter' WHERE id=" . $row['id'];
            mysqli_query($conn, $updateQuery);
            $counter++;
        }

        header("Location: ../../index.php"); // Arahkan kembali setelah berhasil
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
