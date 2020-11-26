<!-- <html></html> digunakan untuk mengawali setiap halaman code untuk mengidentifikasikan bahwa code tersebut
menggunakan html -->
<!DOCTYPE html>
<html lang="en">
<!-- <head></head> digunakan untuk menuliskan tag-tag yang akan dibaca oleh mesin, seperti title,
    kode CSS, dan lain-lain -->
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <title></title> digunakan untuk menampilkan judul di title bar browser -->
  <title>Data Mahasiswa</title>
  <!-- Tag link untuk menghubungkan halaman web ke halaman css berjudul style.css -->
  <link rel="stylesheet" href="style.css"/>
</head>
<!-- <body></body> digunakan untuk mendefinisikan badan dokumen, wadah untuk semua konten yang terlihat,
    seperti judul, paragraf, gambar, hyperlink, tabel, daftar, dll. -->
<body>
  <!-- header h1 -->
  <h1 class="paragraph">DATA MAHASISWA</h1>
  <?php
    // set error
    ini_set("error_reporting", 0);
    // function start session
    session_start();

    //setelah klik submit, data disimpan
    if(isset($_POST['submit']))
    {
      // data disimpan sebagai array
      $data = array();
      // data nama
      $data['nama_mahasiswa'] = $_POST['nama_mahasiswa'];
      // data nim
      $data['nim_mahasiswa'] = $_POST['nim_mahasiswa'];
      // data nilai 1
      $data['nilai_mahasiswa'] = $_POST['nilai_mahasiswa'];
      // data nilai 2
      $data['nilai2_mahasiswa'] = $_POST['nilai2_mahasiswa'];

      // varibel baru jumlah_nilai untuk menyimpan hasil penumlahan dari nilai 1 dan nilai 2
      $data['jumlah_nilai'] = $data['nilai_mahasiswa'] + $data['nilai2_mahasiswa'];
      // variabel baru rata_rata untuk menampung nilai rata-rata
      $data['rata_rata'] = $data['jumlah_nilai'] / 2;

      // push data ke session
      if($_SESSION['data_mahasiswa']){
        $data_mahasiswa = $_SESSION['data_mahasiswa'];
        array_push($data_mahasiswa,$data);
        $_SESSION['data_mahasiswa'] = $data_mahasiswa;
      }else{
        $_SESSION['data_mahasiswa'][] = $data;
      }
      header("location: ./index.php");
    }
    // menampilkan baris pertama tabel
    if($_SESSION['data_mahasiswa']){ ?>
    <!-- button untuk tambah data -->
      <button class='button'><a href='?act=add'>TAMBAH DATA</a><br></button>
      <table border="1">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>NIM</th>
          <th>Nilai 1</th>
          <th>Nilai 2</th>
          <th>Jumlah nilai</th>
          <th>Rata-Rata</th>
          <th>Hapus Data</th>
        </tr>
      <!-- memebrikan value pada setiap baris sesuai dengan urutan kolom no, nama, nim, nilai 1, nilai 2, jumlah nilai, rata-rata, dan button hapus -->
      <?php $no=0; foreach ($_SESSION['data_mahasiswa'] as $key => $value) { $no++; ?>
        <tr>
          <!-- cetak no -->
          <td><?php echo $no;?></td>
          <!-- cetak nama -->
          <td><?php echo $value['nama_mahasiswa'];?></td>
          <!-- cetak nim -->
          <td><?php echo $value['nim_mahasiswa'];?></td>
          <!-- cetak nilai 1 -->
          <td><?php echo $value['nilai_mahasiswa'];?></td>
          <!-- cetak nilai 2 -->
          <td><?php echo $value['nilai2_mahasiswa'];?></td>
          <!-- cetak jumlah nilai -->
          <td><?php echo $value['jumlah_nilai'];?></td>
          <!-- cetak rata-rata -->
          <td><?php echo $value['rata_rata'];?></td>
          <!-- button untuk menghapus data per baris -->
          <td><button type="button" onclick="window.location='index.php?act=delete&id=<?php echo $key;?>'">Hapus Data</button></td>
        </tr>
      <?php } ?>
      </table>
      
    <?php
    }
    else{ ?>
    <!-- pemberitahuan jika data masih kosong -->
      <p style='margin-left:670px'>DATA MASIH KOSONG!!</p>
      <!-- button untuk menambahkan data mahasiswa -->
      <button class='button'><a href='?act=add'>TAMBAH DATA</a></button>
    <?php
    }
    switch($_GET['act']){
      // menu untuk tambah data
      case "add":
        $form = "<p><form action='' method='post'>";
        // input nama
        $form .= "Nama mahasiswa:<br> <input type='text' name='nama_mahasiswa'><br>";
        // input nim
        $form .= "NIM mahasiswa:<br>  <input type='text' name='nim_mahasiswa'><br>";
        // input nilai 1
        $form .= "Nilai 1:<br>  <input type='number' name='nilai_mahasiswa'><br>";
        // input nilai 2
        $form .= "Nilai 2:<br>  <input type='number' name='nilai2_mahasiswa'><br>";
        // button untuk submit dan menyimpan data yang sudah diinputkan
        $form .= "<br><input type='submit' name='submit'></form><br>";
        echo $form;
        break;
        // menu untuk menghapus data
      case "delete":
        $id = $_GET['id'];
        // meng-unset session agar data mahasiswa per baris dapat terhapus dari tabel
        unset($_SESSION['data_mahasiswa'][$id]);
        header("location: ./index.php");
        break;
      case "default":
      break;
    }
    ?>
</body>
</html>