<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['kode_matakuliah'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM matakuliah WHERE kode_matakuliah = ?');
    $stmt->execute([$_GET['kode_matakuliah']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM matakuliah WHERE kode_matakuliah = ?');
            $stmt->execute([$_GET['kode_matakuliah']]);
            $msg = 'You have deleted the contact!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: readmtk.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>


<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Data #<?=$contact['kode_matakuliah']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete data #<?=$contact['kode_matakuliah']?>?</p>
    <div class="yesno">
        <a href="deletemtk.php?kode_matakuliah=<?=$contact['kode_matakuliah']?>&confirm=yes">Yes</a>
        <a href="deletemtk.php?kode_matakuliah=<?=$contact['kode_matakuliah']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>