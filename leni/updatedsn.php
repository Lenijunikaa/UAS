<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact nim exists, for example update.php?nim=1 will get the contact with the nim of 1
if (isset($_GET['nidn'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $nidn = isset($_POST['nidn']) ? $_POST['nidn'] : NULL;
        $nama_dosen = isset($_POST['nama_dosen']) ? $_POST['nama_dosen'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE dosen SET nidn = ?, nama_dosen = ? WHERE nidn = ?');
        $stmt->execute([$nidn, $nama_dosen, $_GET['nidn']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM dosen WHERE nidn = ?');
    $stmt->execute([$_GET['nidn']]);
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
	<h2>Update Data #<?=$contact['nidn']?></h2>
    <form action="updatedsn.php?nidn=<?=$contact['nidn']?>" method="post">
        <label for="nidn">NIDN</label>
        <label for="nama_dosen">Nama Dosen</label>
        <input type="text" name="nidn" value="<?=$contact['nidn']?>" id="nim">
        <input type="text" name="nama_dosen" value="<?=$contact['nama_dosen']?>" id="nama_dosen">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>