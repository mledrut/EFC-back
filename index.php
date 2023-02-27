<?php

$dsn = "mysql:host=localhost;dbname=literie3000";
$db = new PDO($dsn, "root", "root");

$query = $db->query("
SELECT lits.id, lits.nom, marques.nom as marque, tailles.valeur as taille, lits.prix, lits.promo, lits.image  FROM lits

INNER JOIN lits_marques
ON lits.id = lits_marques.lit_id 
INNER JOIN marques
ON lits_marques.marque_id = marques.id

INNER JOIN lits_tailles
ON lits.id = lits_tailles.lit_id 
INNER JOIN tailles
ON lits_tailles.taille_id = tailles.id

ORDER BY lits.nom;
");
$lits = $query->fetchAll(PDO::FETCH_ASSOC);

include("header.php");
?>
<section id="home">
    <div class="container">
        <h1>Nos lits</h1>
        <ul class="lits-list">
        <?php
        foreach ($lits as $lit) {
        ?>
            <li>
                <div class="left">
                    <div class="image">
                        <img src="images/lits/<?= $lit["image"] ?>" alt="">
                    </div>
                    <div class="infos">
                        <div class="texts">
                            <h2><?= $lit["nom"] ?></h2>
                            <h3><?= $lit["marque"] ?></h3>
                            <p><?= $lit["taille"] ?></p>
                        </div>
                        <div class="actions">
                            <a href="modifier.php?id=<?= $lit["id"] ?>"><button class="btn btn-blue">Modifier</button></a>
                            <button class="btn btn-yellow" href="#">Supprimer</button>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="prix">
                        <p class="off"><?= $lit["prix"] ?> €</p>
                        <p class="promo"><?= $lit["promo"] ?> €</p>
                    </div>
                </div>
            </li>
        <?php
        }
        ?>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>