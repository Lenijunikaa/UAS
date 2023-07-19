<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 5;


// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM mahasiswa ORDER BY nim LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM mahasiswa')->fetchColumn();
?>


<?=template_header('Read')?>

<div class="content read">
	<h2>Data Mahasiswa</h2>
	<a href="createmhs.php" class="create-contact">Create Data</a>
	<table>
        <thead>
            <tr>
                <td>Nim</td>
                <td>Nama</td>
                <td>Tanggal Lahir</td>
                <td>Alamat</td>
                <td>Jenis Kelamin</td>
                <td>Opsi</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?=$contact['nim']?></td>
                <td><?=$contact['nama_mhs']?></td>
                <td><?=$contact['tgl_lahir']?></td>
                <td><?=$contact['alamat']?></td>
                <td><?=$contact['jenis_kelamin']?></td>
                <td class="actions">
                    <a href="updatemhs.php?nim=<?=$contact['nim']?>" class="edit">edit</a>
                    <a href="deletemhs.php?nim=<?=$contact['nim']?>" class="trash">hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="readmhs.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_contacts): ?>
		<a href="readmhs.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>