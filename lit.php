<?php
    $find = false;
    $data = array("nom" => "Lit introuvable");
    if (isset($_GET["id"])) {
        $dsn = "mysql:host=localhost;dbname=literie3000";
        $db = new PDO($dsn, "root", "root");
        $leid = $_GET["id"];

        $query = $db->prepare("
        SELECT lits.id, lits.nom, marques.nom as marque, tailles.valeur as taille, lits.prix, lits.promo, lits.image FROM lits
        INNER JOIN lits_marques
        ON lits.id = lits_marques.lit_id 
        INNER JOIN marques
        ON lits_marques.marque_id = marques.id

        INNER JOIN lits_tailles
        ON lits.id = lits_tailles.lit_id 
        INNER JOIN tailles
        ON lits_tailles.taille_id = tailles.id

        WHERE lits.id = :id;
        ");
        $query->bindParam(":id", $leid, PDO::PARAM_INT);
        $query->execute();
        $lit = $query->fetch();

        if ($lit) {
            $find = true;
            $data = $lit;
        }
        
    }
    include("header.php");
?>

<section id="lit">
    <div class="container">

    <h1><?= $data["nom"] ?></h1>

    <?php if ($find) { ?>
        <img src="images/lits/<?= $lit["image"] ?>" alt="">
        <div class="informations">
            <div class="row">
                <h3><?= $lit["marque"] ?></h3>
                <p><?= $lit["taille"] ?></p>
            </div>
            <div class="row">
                <?php if (empty($lit["promo"])) {
                    ?>
                    <p class="normal"><?= $lit["prix"] ?> €</p>
                    <?php
                } else {
                ?>

                <p class="off"><?= $lit["prix"] ?> €</p>
                <p class="promo"><?= $lit["promo"] ?> €</p>

                <?php } ?>
            </div>
        </div>
    <?php } ?>
    </div>
</section>

<?php
include("footer.php");
?>