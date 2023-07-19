<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['nidn'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM dosen WHERE nidn = ?');
    $stmt->execute([$_GET['nidn']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM dosen WHERE nidn = ?');
            $stmt->execute([$_GET['nidn']]);
            $msg = 'You have deleted the contact!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: readdsn.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>


<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Data #<?=$contact['nidn']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete data #<?=$contact['nidn']?>?</p>
    <div class="yesno">
        <a href="deletedsn.php?nidn=<?=$contact['nidn']?>&confirm=yes">Yes</a>
        <a href="deletedsn.php?nidn=<?=$contact['nidn']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>