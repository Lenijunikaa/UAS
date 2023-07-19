<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;


// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM matakuliah ORDER BY kode_matakuliah LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM matakuliah')->fetchColumn();
?>


<?=template_header('Read')?>

<div class="content read">
	<h2>Data Matakuliah</h2>
	<a href="createmtk.php" class="create-contact">Create Data</a>
	<table>
        <thead>
            <tr>
                <td>Kode Matakuliah</td>
                <td>Nama Matakuliah</td>
                <td>Sks</td>
                <td>Opsi</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['kode_matakuliah']?></td>
                <td><?=$contact['nama_matakuliah']?></td>
                <td><?=$contact['sks']?></td>
                <td class="actions">
                    <a href="updatemtk.php?kode_matakuliah=<?=$contact['kode_matakuliah']?>" class="edit">edit</a>
                    <a href="deletemtk.php?kode_matakuliah=<?=$contact['kode_matakuliah']?>" class="trash">hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="readmtk.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="readmtk.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>