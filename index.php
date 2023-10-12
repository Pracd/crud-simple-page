<?php
    require "process.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD PDO</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <!-- navbar-  -->
    <div class="row">
        <div class="col">
        <nav class="navbar bg-body-tertiary">
            <div class="container">
                <a class="navbar-brand">CRUD PHP PDO</a>
                <form class="d-flex" role="search" method="post" action="index.php">
                    <input class="form-control me-2" type="search" name="keyword" placeholder="Search" aria label="Search">
                    <button class="btn btn-outline-success" type="submit" name="cari">Search</button>
                </form>
            </div>
        </nav>
    </div>  
</div>

<!-- awal card form -->
<div class="card mt-3 custom-container">
    <div class="card-header bg-primary text-white">
        Form Input Data Siswa
    </div>
    <div class="card-body">
        <form method="post" action="">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" value="<?=@$nama?>" class="form-control" id="nama" placeholder="Input nama!" required>
            </div>
            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <input type="text" name="kelas" value="<?=@$kelas?>" class="form-control" id="kelas" placeholder="Input Kelas!" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" name="alamat" id="alamat" placeholder="Input Alamat anda disini!"><?=@$alamat?></textarea>
            </div>
            <button type="reset" class="btn btn-danger" name="reset">Kosongkan</button>
            <button type="submit" class="btn btn-success" name="simpan">Simpan</button> 
        </form>
    </div>
</div>
<!-- Akhir Card Form -->

<!-- Awal Card Tabel - -->
<div class="card mt-3">
    <div class="card-header bg-success text-white">
        Daftar Siswa
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <th>No.</th>
                <th>Nana</th>
                <th>Kelas</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
            <?php
                    if (isset($_POST["cari"])) {
                    $keyword="%". $_POST['keyword'] . "%";
                    $stmt = $koneksi->prepare("SELECT * FROM students
                                            WHERE
                                                nama LIKE :keyword OR
                                                kelas LIKE :keyword OR 
                                                alamat LIKE :keyword");
                    $stmt->bindParam(":keyword", $keyword);
                    $stmt->execute();
                } else {
                    $stmt = $koneksi->prepare("SELECT * from students order by id desc");
                    $stmt->execute();
                }
                $no = 1;
                while($data = $stmt->fetch(PDO:: FETCH_ASSOC)) :
            ?>
            <tr>
                <td><?=$no++; ?></td>
                <td><?=$data['nama']?></td>
                <td><?=$data['kelas']?></td> 
                <td><?=$data['alamat']?></td>
                <td>
                    <a href="index.php?hal=edit&id=<?=$data['id']?>" class="btn btn-warning">Edit</a>
                    <a href="index.php?hal=hapus&id=<?=$data['id']?>" 
                        onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger"> Hapus </a>
                </td>
            </tr> 
        <?php endwhile; //penutup perulangan while ?>
        </table>
    </div>
</div>
<!-- Akhir Card Tabel -->
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js
"></script>
</body>
</html>