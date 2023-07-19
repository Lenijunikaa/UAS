<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact nim exists, for example update.php?nim=1 will get the contact with the nim of 1
if (isset($_GET['kode_matakuliah'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $kode_matakuliah = isset($_POST['kode_matakuliah']) ? $_POST['kode_matakuliah'] : NULL;
        $nama_matakuliah = isset($_POST['nama_matakuliah']) ? $_POST['nama_matakuliah'] : '';
        $sks = isset($_POST['sks']) ? $_POST['sks'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE matakuliah SET kode_matakuliah = ?, nama_matakuliah = ?, sks = ? WHERE kode_matakuliah = ?');
        $stmt->execute([$kode_matakuliah, $nama_matakuliah, $sks, $_GET['kode_matakuliah']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM matakuliah WHERE kode_matakuliah = ?');
    $stmt->execute([$_GET['kode_matakuliah']]);
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
	<h2>Update Data #<?=$contact['kode_matakuliah']?></h2>
    <form action="updatemtk.php?kode_matakuliah=<?=$contact['kode_matakuliah']?>" method="post">
        <label for="kode_matakuliah">Kode Matakuliah</label>
        <label for="nama_matakuliah">Nama Matakuliah</label>
        <input type="text" name="kode_matakuliah" value="<?=$contact['kode_matakuliah']?>" id="nim">
        <input type="text" name="nama_matakuliah" value="<?=$contact['nama_matakuliah']?>" id="nama_matakuliah">
        <label for="sks">sks</label>
        <input type="text" name="sks" value="<?=$contact['sks']?>" id="sks">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>