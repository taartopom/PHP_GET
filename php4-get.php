<!DOCTYPE html>
<html>
    <head>
        <title>PHP passer des valeurs du client vers le serveur</title>
    </head>

    <body>
        <h1>Passer des valeurs en GET</h1>

        <a href="php4-get.php?nom=test">Passer paramètre nom</a>
        <br>
        <a href="php4-get.php?ville=valenciennes">Passer paramètre ville</a>
        <br>
        <a href="php4-get.php?ville=valenciennes&nom=fab">Passer paramètres nom et ville</a>
        <br>
        <?php
            if (array_key_exists('nom', $_GET)) {

                // le tableau GET sert à récupérer les valeurs passées dans l'URL
                // pour passer des paramètres dans l'url, il faut séparer la partie url
                // de la partie paramètre par un "?", puis mettre des duo clé/valeur
                // on peut passer plusieurs (donc plusieurs duo) en séparant les duos
                // par des "&"

                $nom = $_GET["nom"];
                echo $nom." ";
            }

            if (array_key_exists('ville', $_GET)) {
                $ville = $_GET["ville"];
                echo $ville;
            }

            echo "<br>salut";
        ?>

        <h1>Passer des paramètres depuis un formulaire</h1>
        <form action="php4-get.php" method="GET">
            <input type="text" name="chiffre"/>
            <input type="submit" value="Afficher"/>
        </form>
        <?php
            if (isset($_GET['chiffre'])) {

                // intval force la conversion en type entier de la valeur passée
                // les chaines de caractères sont donc converties en 0
                // toto est converti en 0
                // 423toto est converti en 423

                $chiffre = intval($_GET['chiffre']);

                // si on a tapé du texte ou le chiffre 0,
                // on ne calcule de table de multiplication

                if ($chiffre == 0) {
                    echo "Veuillez saisir un chiffre > 0";
                }

                // sinon on affiche la table correspondante

                else {
                    $table = [];
                    for ($i=0;$i<=9;$i++) {
                        $table[] = $i * $chiffre;
                    }

                    echo "<h1>Table de multiplication de ".$chiffre."</h1>";
                    echo "<table style=\"border:1px solid;margin-bottom:20px;\">";

                    foreach ($table as $indice => $valeur) {
                        echo "<tr>
                                <td>".$indice." * ".$chiffre." =</td>
                                <td style='border:1px solid'>".$valeur."</td>
                                </tr>";
                    }
                    echo "</table>";
                }

            }
        ?>

        <h1>Formulaire d'inscription</h1>

        <form action="php4-get.php" method="GET">

            <!-- vérification côté client :
                type="email" : permet de ne pas valider le formulaire
                                si le champ ne contient pas une chaine au format email
                type="tel" : permet juste sur mobile d'afficher directement le clavier numérique
                required : le champ est obligatoire, le formulaire n'est pas soumis si
                            aucune valeur n'est saisie dans le champ
                pattern : précise que le champ attend un format de chaine particulier (voir expression régulière)
                            le formulaire n'est pas validé si la saisie ne correspond pas au format attendu
                Les vérifications côté client ne sont pas fiables, elles sont là uniquement
                pour aider l'utilisateur à ne pas se tromper, mais ces vérifications peuvent
                facilement être sautées
            -->

            <input type="text" placeholder="Nom" name="nom" required/>
            <br>
            <label>Email:</label>
            <input type="email" name="email"/>
            <br>
            <input type="tel" placeholder="Téléphone" name="telephone" pattern="\d{10}"/>
            <br>
            <input type="number" placeholder="Année de naissance" name="annee"/>
            <br>
            <input type="submit" value="S'inscrire" name="form_inscription"/>
        </form>

        <?php

            /*
             * nom était obligatoire
             * email au format email
             * telephone doit contenir 10 chiffres
             */

            if (isset($_GET['form_inscription'])) {
                // récupérer les valeurs envoyées
                $nom = $_GET['nom'];
                $email = $_GET['email'];
                $phone = $_GET['telephone'];
                $anneNaissance = $_GET['annee'];

                // vérification des champs obligatoires et des formats de données
                // dans l'ordre que vous voulez

                $errors = [];
                if ($nom == "") {
                    $errors[] = "Veuillez saisir un nom";
                }
                //if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {

                if ($email != "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Veuillez saisir un email valide";
                }

                if ($phone != "" && !preg_match("/\d{10}/", $phone)) {
                    $errors[] = "Veuillez saisir un téléphone valide à 10 chiffres";
                }

                if (count($errors) > 0) {
                    // afficher les erreurs
                    foreach ($errors as $error) {
                        echo $error."<br>";
                    }
                }
                else {

                    // par exemple ici, enregistrement en bdd des informations
                    
                    echo "Merci, votre inscription a bien été prise en compte";
                }
            }

        ?>


    </body>

</html>