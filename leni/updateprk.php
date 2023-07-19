<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact nim exists, for example update.php?nim=1 will get the contact with the nim of 1
if (isset($_GET['nim'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $nim = isset($_POST['nim']) ? $_POST['nim'] : NULL;
        $kode_matakuliah = isset($_POST['kode_matakuliah']) ? $_POST['kode_matakuliah'] : '';
        $nidn = isset($_POST['nidn']) ? $_POST['nidn'] : '';
        $nilai = isset($_POST['nilai']) ? $_POST['nilai'] : '';

        // Update the record
        $stmt = $pdo->prepare('UPDATE perkuliahan SET nim = ?, kode_matakuliah = ?, nidn = ?, nilai = ? WHERE nim = ?');
        $stmt->execute([$nim, $kode_matakuliah, $nidn, $nilai, $_GET['nim']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM perkuliahan WHERE nim = ?');
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
    <form action="updateprk.php?nim=<?=$contact['nim']?>" method="post">
        <label for="nim">Nim</label>
        <label for="kode_matakuliah">Kode Matakuliah</label>
        <input type="text" name="nim" value="<?=$contact['nim']?>" id="nim">
        <input type="text" name="kode_matakuliah" value="<?=$contact['kode_matakuliah']?>" id="kode_matakuliah">
        <label for="nidn">NIDN</label>
        <label for="nilai">nilai</label>
        <input type="text" name="nidn" value="<?=$contact['nidn']?>" id="nidn">
        <input type="text" name="nilai" value="<?=$contact['nilai']?>" id="nilai">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>