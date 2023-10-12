<?php 
//Koneksi Database
$server = "localhost";
$user = "root";
$pass = "";
$database = "db_crud";

//Menangani error / exception handling
//Try catch
//Menggunakan API PDO

try {
    $koneksi = new PDO("mysql:host=$server;dbname=$database", $user, $pass);
    $koneksi ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed : " . $e->getMessage();
}

//Inisialisasi variabel
$nama = $kelas = $alamat = "";

//Cek apakah ada tombol simpan di klik
if(isset($_POST["simpan"])) {
    //Cek apakah data akan diedit atau disimpan baru
    if($_GET['hal'] == "edit" ) {
        //Data akan diedit
        $stmt = $koneksi->prepare("UPDATE students SET nama = :nama, kelas = :kelas, alamat = :alamat WHERE id = :id");

        $stmt->bindParam(':nama', $_POST['nama']);
        $stmt->bindParam(':kelas', $_POST['kelas']);
        $stmt->bindParam(':alamat', $_POST['alamat']);
        $stmt->bindParam(':id', $_GET['id']);

        $stmt ->execute();

        echo "<script>
        alert('Edit data sukses!');
        document.location='index.php';
        </script>";
    }
    else{
        //Data akan disimpan baru
        $stmt = $koneksi->prepare("INSERT INTO students (nama, kelas, alamat) VALUES (:nama, :kelas, :alamat)");

        $stmt->bindParam(':nama', $_POST['nama']);
        $stmt->bindParam(':kelas', $_POST['kelas']);
        $stmt->bindParam(':alamat', $_POST['alamat']);

        $stmt->execute();

        echo "<script>
        alert('Simpan data sukses!');
        document.location='index.php';
        </script>";
    }
}

//Cek apakah ada kata kunci hal untuk hapus data
if(isset($_GET['hal'])) {

    if($_GET['hal'] == "edit") {
        $stmt = $koneksi->prepare('SELECT * FROM students WHERE id = :id');
        $stmt ->bindParam(':id', $_GET['id']);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($data) {
            //Jika ditemukan, maka data ditampung ke dalam variabel
            $nama = $data['nama'];
            $kelas = $data['kelas'];
            $alamat = $data['alamat'];
        }
    }else if ($_GET['hal'] == "hapus"){
        $stmt = $koneksi->prepare('DELETE FROM students WHERE id = :id');
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();

        echo "<script>
        alert('Hapus data sukses!');
        document.location='index.php';
        </script>";
    } 
}

?>