<?php 

$dsn = "mysql:host=localhost;dbname=literie3000";
$db = new PDO($dsn, "root", "root");

$query_lits = $db->query("SELECT * from lits;");
$lits = $query_lits->fetchAll(PDO::FETCH_ASSOC);

$query_marques = $db->query("SELECT * from marques;");
$marques = $query_marques->fetchAll(PDO::FETCH_ASSOC);

// var_dump($marques);
// var_dump($lits);

$query_tailles = $db->query("SELECT * from tailles;");
$tailles = $query_tailles->fetchAll(PDO::FETCH_ASSOC);

if (!empty($_POST)) {
    $nom = trim(strip_tags($_POST["nom"]));
    $marque = (int)$_POST["marque"];
    $taille = (int)$_POST["taille"];
    $prix = trim(strip_tags($_POST["prix"]));
    $promo = trim(strip_tags($_POST["promo"]));
    $image = trim(strip_tags($_POST["image"]));

    var_dump($marque);
    var_dump($taille);
   
    $errors = [];

    if (empty($nom)) {
        $errors["nom"] = "Le nom du lit est obligatoire";
    }
    if (empty($marque)) {
        $errors["marque"] = "La marque du lit est obligatoire";
    }
    if (empty($taille)) {
        $errors["taille"] = "La taille du lit est obligatoire";
    }
    if (empty($prix)) {
        $errors["prix"] = "Le prix du lit est obligatoire";
    }

    if ($prix < 0) {
       $errors["prix"] = "Le prix ne peut pas être inférieur à zéro";
    }
    if ($promo < 0 || $promo >= $prix) {
       $errors["promo"] = "La promo ne peut pas être inférieur à zéro ou inférieur au prix d'origine";
    }

    if (empty($errors)) {
        $dsn = "mysql:host=localhost;dbname=literie3000";
        $db = new PDO($dsn, "root", "root");

        // Ajout dans la table lits
        $query_add = $db->prepare("
        INSERT INTO lits
        (nom, prix, promo, image)
        VALUES
        (:nom, :prix, :promo, :image)
        ");

        $query_add->bindParam(":nom", $nom);
        $query_add->bindParam(":prix", $prix);
        $query_add->bindParam(":promo", $promo);
        $query_add->bindParam(":image", $image);

        // Ajout dans la table lits_marques
        $query_add_marque = $db->prepare("
        INSERT INTO lits_marques
        (lit_id, marque_id)
        VALUES
        (:lit_id, :marque_id)
        ");

        $lit_to_new_id = count($lits) + 1;
        $query_add_marque->bindParam(":lit_id", $lit_to_new_id);
        $query_add_marque->bindParam(":marque_id", $marque);

        // Ajout dans la table lits_tailles
        $query_add_taille = $db->prepare("
        INSERT INTO lits_tailles
        (lit_id, taille_id)
        VALUES
        (:lit_id, :taille_id)
        ");
        $query_add_taille->bindParam(":lit_id", $lit_to_new_id);
        $query_add_taille->bindParam(":taille_id", $taille);


        // Et on execute le tout !
        if ($query_add->execute() && $query_add_marque->execute() && $query_add_taille->execute()) {
            header("Location: index.php");
        }
    }
}

include("header.php");
?>

<section id="add">
    <div class="container">
        <h1>Ajouter un nouveau lit</h1>
        <form action="" method="post">
        
            <div class="form-group form-group-lg">
                <label for="input-nom">Nom du lit</label>
                <input type="text" id="input-nom" name="nom">
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
                <input type="number" id="input-prix" name="prix">
                <?php if (isset($errors["prix"])) { ?>
                    <span class="info-error"><?= $errors["prix"] ?></span>
                <?php } ?>
            </div>
            <div class="form-group">
                <label for="input-promo">Promo</label>
                <input type="number" id="input-promo" name="promo">
                <?php if (isset($errors["promo"])) { ?>
                    <span class="info-error"><?= $errors["promo"] ?></span>
                <?php } ?>
            </div>
            <div class="form-group form-group-lg">
                <label for="input-image">image du lit</label>
                <input type="text" id="input-image" name="image" placeholder="test.webp pour le dev">
            </div>

            <input type="submit" value="Ajouter le lit" class="btn">
        </form>
    </div>
</section>




<?php include("footer.php"); ?>