<?php

$find = false;
$data = array("nom" => "Lit introuvable");
if (isset($_GET["id"])) {
    
    $dsn = "mysql:host=localhost;dbname=literie3000";
    $db = new PDO($dsn, "root", "root");

    $query = $db->prepare("
    SELECT * FROM lits WHERE id = :id
    ");
    $query->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
    $query->execute();
    $lits = $query->fetch();
    if ($lits) {
        
        $find = true;
        $data = $lits;
    }

    $query_lits = $db->query("SELECT * from lits;");
    $lits = $query_lits->fetchAll(PDO::FETCH_ASSOC);

    $query_marques = $db->query("SELECT * from marques;");
    $marques = $query_marques->fetchAll(PDO::FETCH_ASSOC);

    $query_tailles = $db->query("SELECT * from tailles;");
    $tailles = $query_tailles->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($_POST)) {
        $nom = trim(strip_tags($_POST["nom"]));
        $marque = (int)$_POST["marque"];
        $taille = (int)$_POST["taille"];
        $prix = trim(strip_tags($_POST["prix"]));
        $promo = trim(strip_tags($_POST["promo"]));
        $image = trim(strip_tags($_POST["image"]));
       
        $errors = [];
        if ($prix && $prix < 0) {
           $errors["prix"] = "Le prix ne peut pas être inférieur à zéro";
        }
        if (empty($promo)) {
            $promo = NULL;
        }
    
        if (empty($errors)) {
            $dsn = "mysql:host=localhost;dbname=literie3000";
            $db = new PDO($dsn, "root", "root");
    
            $query_update_lits = $db->prepare("
            UPDATE lits SET
            nom = :nom,
            prix = :prix,
            promo = :promo,
            image = :image
            WHERE lits.id = :id");
            $query_update_lits->bindParam(":nom", $nom);
            $query_update_lits->bindParam(":prix", $prix);
            $query_update_lits->bindParam(":promo", $promo);
            $query_update_lits->bindParam(":image", $image);
            $query_update_lits->bindParam(":id", $data["id"]);
        
            $query_update_marque = $db->prepare("UPDATE lits_marques SET marque_id = :marque WHERE lit_id = :id");
            $query_update_marque->bindParam(":marque", $marque);
            $query_update_marque->bindParam(":id", $data["id"]);
        
            $query_update_taille = $db->prepare("UPDATE lits_tailles SET taille_id = :taille WHERE lit_id = :id");
            $query_update_taille->bindParam(":taille", $taille);
            $query_update_taille->bindParam(":id", $data["id"]);

            if ($query_update_lits->execute() && $query_update_marque->execute() && $query_update_taille->execute()) {
                header("Location: index.php");
            }
        }
    }
    
}

include("header.php");
?>

<section id="modifier">
    <div class="container">
        <h1>Modifier : <?= $data["nom"] ?></h1>
        <?php if ($find) { ?>
        <form action="" method="post">
            <div class="form-group form-group-lg">
                <label for="input-nom">Nom du lit</label>
                <input type="text" id="input-nom" name="nom" value="<?= $data["nom"] ?>">
                <?php if (isset($errors["nom"])) { ?>
                    <span class="info-error"><?= $errors["nom"] ?></span>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="input-marque">Marque</label>
                <select name="marque" id="input-marque">
                    <?php foreach ($marques as $marque) { ?>
                        <option value="<?= $marque["id"]?>"><?= $marque["nom"]?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="input-taille">Taille</label>
                <select name="taille" id="input-taille">
                    <?php foreach ($tailles as $taille) { ?>
                        <option value="<?= $taille["id"]?>"><?= $taille["valeur"]?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="input-prix">Prix</label>
                <input type="number" id="input-prix" name="prix" value="<?= $data["prix"] ?>">
                <?php if (isset($errors["prix"])) { ?>
                    <span class="info-error"><?= $errors["prix"] ?></span>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="input-promo">Promo</label>
                <input type="number" id="input-promo" name="promo" value="<?= $data["promo"] ?>">
                <?php if (isset($errors["promo"])) { ?>
                    <span class="info-error"><?= $errors["promo"] ?></span>
                <?php } ?>
            </div>
            <div class="form-group form-group-lg">
                <label for="input-image">image du lit</label>
                <input type="text" id="input-image" name="image" value="<?= $data["image"] ?>">
            </div>

            <input type="submit" value="Modifier les infos" class="btn btn-blue">
        </form>

        <form action="delete.php?id=<?= $data["id"]?>" method="post" class="delete-form">
            <input type="hidden" name="name" value="<?= $data['id']; ?>">
            <input class="btn btn-red" type="submit" name="submit" value="Supprimer">
        </form>
    <?php } ?>
    </div>
    
</section>


    
<?php include("footer.php"); ?>