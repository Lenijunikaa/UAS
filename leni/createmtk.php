<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $kode_matakuliah = isset($_POST['kode_matakuliah']) && !empty($_POST['kode_matakuliah']) && $_POST['kode_matakuliah'] != 'auto' ? $_POST['kode_matakuliah'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nama_matakuliah = isset($_POST['nama_matakuliah']) ? $_POST['nama_matakuliah'] : '';
    $sks = isset($_POST['sks']) ? $_POST['sks'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO matakuliah VALUES (?, ?, ?)');
    $stmt->execute([$kode_matakuliah, $nama_matakuliah, $sks]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Create Data</h2>
    <form action="createmtk.php" method="post">
        <label for="kode_matakuliah">Kode Matakuliah</label>
        <label for="nama_matakuliah">Nama Matakuliah</label>
        <input type="text" name="kode_matakuliah" value="auto" id="kode_matakuliah">
        <input type="text" name="nama_matakuliah" id="nama_matakuliah">
        <label for="sks">Sks</label>
        <input type="text" name="sks" id="sks">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>