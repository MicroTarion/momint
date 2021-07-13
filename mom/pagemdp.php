<!DOCTYPE html>
<!--Page d'accueil du site : 
Cache l'adresse de la deuxième page pour obliger la connexion avant de pouvoir y accéder
Utilise une base de donnée pour stocker les identifiants (username et password)
Le hashage aurait pu être utilisé mais j'ai pas trop compris comment j'aurai pu l'incorporer directement dans la base de données
je serai plus expérimenté une fois que j'aurai eu mes premiers cours de cybersécurité.
Pour la réalisation du site j'ai utilisé MAMP avec MySQL inclus avec.
-->
<html>

<head>
    <meta charset="utf-8" />
    <title>Page protégée par mot de passe</title>
    <LINK href="css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
        <a href="https://www.mom-packaging.com/"><img src="img/logomom.png"></a>
    </header>
    <?php
    
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $
        $connected = false;
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
            $query = $bdd->prepare("SELECT * FROM user where username='$user' and password='$pass' ");   //Récupère la requête sql qui vérifie la compatibilité avec la database
            $query->execute(array(
            'username'=>$user,
            'password'=>$pass));
            // Exécution de la query et récupération de celle ci dans $result
            $result = $query->fetch();
            //Vérification de la concordance entre les identifiants entrés et ceux stockés dans la base de données
            $Usernamecorrect = ($_POST['user']==$result['username']);
            $PasswordCorrect = ($_POST['pass']==$result['password']);
            if ((!$result)&&(!$connected)){
                echo 'Veuillez entrez votre username et votre mot de passe';
            }
            else{
                if ($Usernamecorrect&&$PasswordCorrect) {
                    $user = htmlspecialchars($_POST['user']);
                    $pass = htmlspecialchars($_POST['pass']);
                    echo 'Vous êtes connecté !';
                    $connected = true;
                }
            else {
                echo 'Mauvais identifiant ou mot de passe !';
            } 
        }
            if ($connected){
                echo  'Vous allez être rediriger sur la page reliée à la base de donnée.'."\r\n";
                ?>
            <!--Création du bouton qui permet de changer de page-->
            <div id=coscreen>
                <form action="pagebdd.php" method="POST">
                <?php
                    session_start();
                $_SESSION['authenticated'] = 'yes';
                ?>
                    <input type="submit" value="Appuyer pour continuer" class=boutonval />
                </form>
            </div>
            <?php
            }
            else{
            ?>
            <!-- Création du formulaire de connexion -->
            <form method="POST" action="pagemdp.php" id=idenscreen>
                <br />
                Username <input type="text" name="user"></input><br />
                Password <input type="password" name="pass"></input><br />
                <br />
                <input class=boutonval type="submit" name="submit" value="Valider"></input>
            </form>
            <?}
        //Fermeture du flux de données
        $query->closeCursor();
        ?>
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