# Modul 1
## 1 : Mempersiapkan Proyek dan Koneksi Database
- Download XAMPP untuk terhubung dengan database dan menjalankan server local
  - Jalankan Apache dan MySQL
- Membuat file `config.php` untuk koneksi ke database menggunakan MySQLi

```php
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "supermarket";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```
Pengecekan, jika ada yang error saat menghubungkan ke database, maka akan muncul pesan `Connection failed`

# Modul 2
## 2 : Membuat code html dan css
Pada modul ini, kita akan fokus pada cara membuat struktur dasar halaman web menggunakan HTML dan memberikan gaya visual menggunakan CSS. Halaman web ini akan menampilkan form input untuk menambahkan produk serta tabel yang akan menampilkan data produk dari database.

```html
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
```
- Di dalam tabel, kode PHP digunakan untuk berinteraksi dengan database. mysqli_fetch_assoc($result) mengambil setiap baris data dari database, kemudian data tersebut ditampilkan di dalam tabel HTML.
- Loop PHP: Kita menggunakan loop while untuk menampilkan semua data yang diambil dari database dengan query SELECT * FROM barang. Jika tidak ada data, kita menampilkan pesan "Tidak ada data".

# Modul 3 : Fungsi Create
## 3 : Proses Menyimpan Data Produk ke Database
Pada langkah ini, kita akan membuat file `proses.php` untuk menangani data yang dikirimkan dari form di `index.php`. Tujuannya adalah agar data produk bisa disimpan ke dalam database.

### Langkah-langkah:
1. Buat file bernama `proses.php` di dalam folder assets/php/.
2. Isi file tersebut dengan script PHP yang akan mengambil data dari form dan menyimpannya ke database.

```php
<?php
include 'config.php'; // Menghubungkan ke file koneksi database

if (isset($_POST['submit'])) {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];

    // Query untuk menambahkan data produk ke tabel barang
    $query = "INSERT INTO barang (nama_produk, harga, jumlah) VALUES ('$nama_produk', '$harga', '$jumlah')";

    if (mysqli_query($conn, $query)) {
        // Redirect kembali ke halaman utama setelah berhasil menambah data
        header("Location: ../../index.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>
```
### Penjelasan
- `if (isset($_POST['submit']))`: Mengecek apakah tombol submit di form sudah diklik.
- `mysqli_query($conn, $query)`: Menjalankan query SQL untuk menyimpan data ke tabel barang.
- `header("Location: ../../index.php")`: Mengarahkan pengguna kembali ke halaman utama setelah data berhasil ditambahkan.

### Latihan
- Siswa dapat mencoba menambahkan beberapa produk melalui form di `index.php` dan melihat apakah data berhasil ditampilkan di tabel.
- Diskusikan error yang mungkin muncul, misalnya terkait penulisan query SQL atau koneksi database yang bermasalah.

# Modul 4: Fungsi Read
## 4: Menampilkan Data dari Database
- Setelah data berhasil ditambahkan, kita akan menampilkan semua data produk di halaman utama (`index.php`).
- Data akan diambil dari tabel `barang` di database.

### Langkah-langkah:
- Pastikan bahwa pada `index.php`, kita telah menambahkan kode untuk menampilkan data dari database ke tabel.
- Data ditampilkan di dalam tag `<tbody>` yang sudah kita buat sebelumnya.
 ```php
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
  ```
### Penjelasan:
- Pada `index.php`, query `SELECT * FROM barang` akan mengambil semua data dari tabel `barang`.
- `mysqli_fetch_assoc()` digunakan untuk mengambil data dalam bentuk `array asosiatif`, sehingga kita bisa menampilkan setiap kolom data.

Modul 5: Fungsi Update
5: Membuat Fitur Edit Data Produk
Pada modul ini, siswa akan belajar cara mengedit data yang ada di database. Kita akan menambahkan fitur untuk mengedit data produk yang sudah ada.

Langkah-langkah:
Buat file edit.php di dalam folder assets/php/.
Di index.php, tambahkan tombol Edit di setiap baris produk.
