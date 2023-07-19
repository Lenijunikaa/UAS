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
    $kode_matakuliah = isset($_POST['kode_matakuliah']) ? $_POST['kode_matakuliah'] : '';
    $nidn = isset($_POST['nidn']) ? $_POST['nidn'] : '';
    $nilai = isset($_POST['nilai']) ? $_POST['nilai'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO mahasiswa VALUES (?, ?, ?, ?)');
    $stmt->execute([$nim, $kode_matakuliah, $nidn, $nilai]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Create Data</h2>
    <form action="createprk.php" method="post">
        <label for="nim">Nim</label>
        <label for="kode_matakuliah">Kode Matakuliah</label>
        <input type="text" name="id" value="auto" id="nim">
        <input type="text" name="kode_matakuliah" id="kode_matakuliah">
        <label for="nidn">NIDN</label>
        <label for="nilai">Nilai</label>
        <input type="text" name="nidn" id="nidn">
        <input type="text" name="nilai" id="nilai">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>