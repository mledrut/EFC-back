<?php 

if (isset($_GET["id"])) {
    $dsn = "mysql:host=localhost;dbname=literie3000";
    $db = new PDO($dsn, "root", "root");

    $query_update_marque = $db->prepare("DELETE FROM lits_marques WHERE lit_id = :id;");
    $query_update_marque->bindParam(":id", $_GET["id"]);

    $query_update_taille = $db->prepare("DELETE FROM lits_tailles WHERE lit_id = :id;");
    $query_update_taille->bindParam(":id", $_GET["id"]);

    $query_update_lits = $db->prepare("DELETE FROM lits WHERE id = :id;");
    $query_update_lits->bindParam(":id", $_GET["id"]);

    if ($query_update_marque->execute() && $query_update_taille->execute() && $query_update_lits->execute()) {
        header("Location: index.php");
    }
}

include("header.php");
?>

<section id="delete">
    <div class="container">
        <h1>Supprimé avec succès</h1>
    </div>
</section>



<?php include("footer.php"); ?>