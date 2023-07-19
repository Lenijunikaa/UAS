<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'aplikasi';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}
function template_header($title) {
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>STMIK LOMBOK</h1>
            <a href="index.php"><i class="fas fa-home"></i>Home</a>
    		<a href="readmhs.php"><i class="fas fa-address-book"></i>Mahasiswa</a>
			<a href="readmtk.php"><i class="fas fa-address-book"></i>Matakuliah</a>
			<a href="readprk.php"><i class="fas fa-address-book"></i>Perkuliahan</a>
			<a href="readdsn.php"><i class="fas fa-address-book"></i>Dosen</a>
    	</div>
    </nav>
EOT;
}
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>