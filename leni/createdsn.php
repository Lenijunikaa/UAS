<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $nidn = isset($_POST['nidn']) && !empty($_POST['nidn']) && $_POST['nidn'] != 'auto' ? $_POST['nidn'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nama_dosen = isset($_POST['nama_dosen']) ? $_POST['nama_dosen'] : '';

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO dosen VALUES (?, ?)');
    $stmt->execute([$nidn, $nama_dosen]);
    // Output message
    $msg = 'Created Successfully!';
}
?>


<?=template_header('Create')?>

<div class="content update">
	<h2>Create Data</h2>
    <form action="createdsn.php" method="post">
        <label for="nidn">NIDN</label>
        <label for="nama_dosen">Nama Dosen</label>
        <input type="text" name="nidn" value="auto" id="nidn">
        <input type="text" name="nama_dosen" id="nama_dosen">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>