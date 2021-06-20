<!-- include disini untuk memanggil file yang inc -->
<?php include("inc_header.php") ?>
<!-- jika katakunci diklik dan jika ada isisan dikata kunci
maka akan dikembalikan kevariable kata kunci. dan jika tidak ada isinya maka akan menampilkan data kosong -->
<?php
  // Notice: Undefined index adalah pesan error yang terjadi karena kita langsung menampilkan variabel $_GET[’nama’] dan $_GET[’email’] yang memang belum diset sebelumnya.
// Untuk memeriksa apakah sebuah objek form telah didefenisikan atau telah di-set sebelumnya, kita bisa menggunakan fungsi bawaan PHP: isset(). Fungsi isset() akan menghasilkan nilai true jika sebuah variabel telah didefenisikan, dan false jika variabel tersebut belum dibuat.

// untuk variabel delet = sukses
$sukses = "";

$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";
// ini merupakan perintah untuk delet
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1   = "delete from halaman where id = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses     = "Berhasil hapus data";
    }
}
?>
<h1>Halaman Admin</h1>
<p>
 <!-- fungsi a href yaitu kode tersebut merujuk pada atribut html yang berguna 
  sederhananya untuk membuat suatu hyperlink antar halaman HTML.
   jadi kode ini memungkinkan kita dapat
   membuat istilahnya teks yang dapat diklik yang akan membawa kita ke halaman baru. -->
    <a href="halaman_input.php">
        <input type="button" class="btn btn-primary" value="Buat Halaman Baru" />
    </a>
</p>
<?php

//ini untuk tampilan dari delet diambil dari dokumentasi bosstrep
if ($sukses) {
?>
    <div class="alert alert-primary" role="alert">
        <?php echo $sukses ?>
    </div>
<?php
}
?>
<form class="row g-3" method="get">
    <div class="col-auto">
        <input type="text" class="form-control" placeholder="Masukkan Kata Kunci" name="katakunci" value="<?php echo $katakunci ?>" />
    </div>
    <div class="col-auto">
        <input type="submit" name="cari" value="Cari Tulisan" class="btn btn-secondary" />
    </div>
</form>
<table class="table table-striped">
    <thead>
        <tr>
            <th class="col-1">#</th>
            <th>Judul</th>
            <th>Kutipan</th>
            <th class="col-2">Aksi</th>
        </tr>
    </thead>
    <!-- membuat data dummy untuk percobaan -->
    <tbody>
      <!--Menampilkan data dari tabel mysqli  -->
        <?php
        $sqltambahan = "";

        //perhalaman untuk pagination
        $per_halaman = 2;
        if ($katakunci != '') {
            $array_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($array_katakunci); $x++) {
                $sqlcari[] = "(judul like '%" . $array_katakunci[$x] . "%' or kutipan like '%" . $array_katakunci[$x] . "%' or isi like '%" . $array_katakunci[$x] . "%')";
            }
            $sqltambahan    = " where " . implode(" or ", $sqlcari);
        }
          // akan urut berdasar id
        $sql1   = "select * from halaman $sqltambahan";

        //dibawah ini untuk membuat pagination yaitu untuk membuat jika isinya banyak maka hanya
        //menmapilkan beberapa
        $page   = isset($_GET['page'])?(int)$_GET['page']:1;
        $mulai  = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
        $q1     = mysqli_query($koneksi,$sql1);
        $total  = mysqli_num_rows($q1);
        $pages  = ceil($total / $per_halaman);
      //  supaya nomor dipaginationya berubah
        $nomor  = $mulai + 1;
        $sql1   = $sql1." order by id desc limit $mulai,$per_halaman";

        $q1     = mysqli_query($koneksi, $sql1);
      
        while ($r1 = mysqli_fetch_array($q1)) {
        ?>
            <tr>
                <td><?php echo $nomor++ ?></td>
                <td><?php echo $r1['judul'] ?></td>
                <td><?php echo $r1['kutipan'] ?></td>
                <td>

                <!-- untuk edit -->
                    <a href="halaman_input.php?id=<?php echo $r1['id']?>">
                        <span class="badge bg-warning text-dark">Edit</span>
                    </a>

                    <!-- untuk konfirmasi delet -->
                    <a href="halaman.php?op=delete&id=<?php echo $r1['id'] ?>" onclick="return confirm('Apakah yakin mau hapus data bro?')">
                        <span class="badge bg-danger">Delete</span>
                    </a>
                </td>
            </tr>
        <?php
        }
        ?>

    </tbody>
</table>

<!-- page navigation yuntuk berupa angka -->
<nav aria-label="Page navigation example">
          <!-- //pagination untuk tampilannya horizaontal kotaknya -->
    <ul class="pagination">
        <?php 
        $cari = isset($_GET['cari'])? $_GET['cari'] : "";

        for($i=1; $i <= $pages; $i++){
            ?>
            <li class="page-item">
            <!-- //untuk menmpikan angkanya -->
                <a class="page-link" href="halaman.php?katakunci=<?php echo $katakunci?>&cari=<?php echo $cari?>&page=<?php echo $i ?>"><?php echo $i ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>
<?php include("inc_footer.php") ?>