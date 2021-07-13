<!DOCTYPE html>
<!--Page de recherche de pièce
Page innaccessible sans passer par la page d'avant.
-->
<html>
    <head>
        <meta charset="utf-8" />
        <title>Page d'accès à la base de données</title>
        <LINK href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <header>
			<a href="https://www.mom-packaging.com/"><img src="img/logomom.png"></a>
        </header>
        <?php
        // Si tentative d'accès sans être loggé
        session_start();
        if($_SESSION['authenticated'] != 'yes') {
            ?>
            <a href="pagemdp.php" class=trying>YEP, c'était prévu</a>
            <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class=trying>Rick roll obligatoire</a> 
            <?php
            exit("Nice try but no" );
            ?>
        <?php
        }
         //Connexion à la base de donnée.
            try{
	        $bdd = new PDO('mysql:host=localhost;dbname=momdb;charset=utf8', 'root', 'root');
            }
            catch(Exception $e){
                die('Erreur dans le try catch: '.$e->getMessage());
            }
        ?>
    <main>
        <div id=middle>
            <?php
            $query = $bdd->prepare(" SELECT * FROM merc ");   //Préparation de la query
            ?>
            <datalist id = "look4piece">
                <?php
                // Exécution de la query
                    $query->execute();
                    //loop pour Créer la datalist et afficher correctement les valeurs à afficher à partir de la database
                    while ($row =$query->fetch()){  ?>
                        <option value="<?php echo $row['ID']. " - ". $row['nom'];?>"></option>
                    <?php } ?>
            </datalist>

            <form action="" id="formpiece"> <!--Création du Formulaire en récupérant la datalist crée   -->
                Choisir un produit :
                <input type="text" list="look4piece" autocomplete="off"/>
            </form>
        </div>
    </main>

    
        <!-- /Footer de la page -->
	<footer>	
		<p>Site fait par J S-G, tous droits réservés, en espérant travailler pour vous</p>
			<!-- /Copyright -->
	</footer>
    <a href="pagemdp.php" id=goofed>Au cas où</a>
    </body>
</html>