<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact nim exists, for example update.php?nim=1 will get the contact with the nim of 1
if (isset($_GET['nim'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $nim = isset($_POST['nim']) ? $_POST['nim'] : NULL;
        $nama_mhs = isset($_POST['nama_mhs']) ? $_POST['nama_mhs'] : '';
        $tgl_lahir = isset($_POST['tgl_lahir']) ? $_POST['tgl_lahir'] : '';
        $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
        $jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE mahasiswa SET nim = ?, nama_mhs = ?, tgl_lahir = ?, alamat = ?, jenis_kelamin = ? WHERE nim = ?');
        $stmt->execute([$nim, $nama_mhs, $tgl_lahir, $alamat, $jenis_kelamin, $_GET['nim']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM mahasiswa WHERE nim = ?');
    $stmt->execute([$_GET['nim']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update Data #<?=$contact['nim']?></h2>
    <form action="updatemhs.php?nim=<?=$contact['nim']?>" method="post">
        <label for="nim">Nim</label>
        <label for="nama_mhs">Nama</label>
        <input type="text" name="nim" value="<?=$contact['nim']?>" id="nim">
        <input type="text" name="nama_mhs" value="<?=$contact['nama_mhs']?>" id="nama_mhs">
        <label for="tgl_lahir">Tanggal Lahir</label>
        <label for="alamat">Alamat</label>
        <input type="date" name="tgl_lahir" value="<?=$contact['tgl_lahir']?>" id="tgl_lahir">
        <input type="text" name="alamat" value="<?=$contact['alamat']?>" id="alamat">
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <input type="text" name="jenis_kelamin" value="<?=$contact['jenis_kelamin']?>" id="title">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>