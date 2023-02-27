<?php

$dsn = "mysql:host=localhost;dbname=literie3000";
$db = new PDO($dsn, "root", "root");

$query = $db->query("SELECT * FROM lits");
$recipes = $query->fetchAll(PDO::FETCH_ASSOC);

include("header.php");
?>

<div class="container">
    <h1>Nos lits</h1>
</div>

<?php include("footer.php"); ?>