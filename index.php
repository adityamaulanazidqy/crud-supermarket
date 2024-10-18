<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Data Produk Supermarket</title>
</head>

<body>
    <div class="container">
        <h1>Data Produk Supermarket</h1>

        <!-- Form Input -->
        <form action="assets/php/proses.php" method="POST">
            <input type="text" name="nama_produk" placeholder="Nama Produk" required>
            <input type="number" name="harga" placeholder="Harga" required>
            <input type="number" name="jumlah" placeholder="Jumlah" required>
            <button type="submit" name="submit">Tambah Produk</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'assets/php/config.php'; // Pastikan ini terhubung dengan benar

                $query = "SELECT * FROM barang ORDER BY id"; // Urutkan berdasarkan ID
                $result = mysqli_query($conn, $query);
                $counter = 1; // Variabel untuk menghitung ID yang terurut

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $counter++ . "</td>"; // Tampilkan ID terurut
                        echo "<td>" . $row['nama_produk'] . "</td>";
                        echo "<td>" . $row['harga'] . "</td>";
                        echo "<td>" . $row['jumlah'] . "</td>";
                        echo "<td class='actions'>
                    <a href='assets/php/edit.php?id=" . $row['id'] . "' class='edit'>Edit</a>
                    <a href='assets/php/proses.php?delete=" . $row['id'] . "' class='delete'>Hapus</a>
                  </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>