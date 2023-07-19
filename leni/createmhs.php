<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $nim = isset($_POST['nim']) && !empty($_POST['nim']) && $_POST['nim'] != 'auto' ? $_POST['nim'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nama_mhs = isset($_POST['nama_mhs']) ? $_POST['nama_mhs'] : '';
    $tgl_lahir = isset($_POST['tgl_lahir']) ? $_POST['tgl_lahir'] : '';
    $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO mahasiswa VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$nim, $nama_mhs, $tgl_lahir, $alamat, $jenis_kelamin]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Create Data</h2>
    <form action="createmhs.php" method="post">
        <label for="nim">Nim</label>
        <label for="nama_mhs">Nama</label>
        <input type="text" name="id" value="auto" id="nim">
        <input type="text" name="nama_mhs" id="nama_mhs">
        <label for="tgl_lahir">Tanggal Lahir</label>
        <label for="alamat">Alamat</label>
        <input type="date" name="tgl_lahir" id="tgl_lahir">
        <input type="text" name="alamat" id="alamat">
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <input type="text" name="jenis_kelamin" id="jenis_kelamin">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>