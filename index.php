<?php

// ETAPES 1 et 2 : La connexion et la sélection de la BDD :

/*
Pour établir la connexion à ma base de donnée, il va falloir que j'instancie un objet PDO, qui est nécessaire pour tout ce que je veux ensuite (ex CRUD)

LE DSN c'est ce qui nous permet de décrire la base de données à laquelle nous allons nous connecter et son type. Dans le DSN, j'ai en premier le nom du pilote (mysql:) ; host suivi du nom ou adresse ip de l'hôte de la bdd, ensuite dbname suivi du nom de la base de données auxquelle je veux me connecter. 
 On va avoir aussi besoin de l'utilisateur et de son login

$mon-objet-pdo = new PDO(DSN, utilisateur, mot-de-passe)

*/

/*
$dsn = 'mysql:host=localhost;dbname=chiencool';
$user = 'chiencool';
$mdp = 'chiencool';
*/

//$connexionDB = new PDO($dsn, $user, $mdp);


// on va améliorer ce principe de connexion en ajoutant une structure de test en try and catch qui va nous permettre de savoir s'il y a un problème à la connexion et si oui lequel problème afin de plus facilement le corriger.

/*
try {
    $connexionDB = new PDO($dsn, $user, $mdp);
} catch (PDOException $erreur){
    echo 'Connexion échouée car'.$erreur->getMessage();
}
*/

// Une bonne pratique, étant donné que nous allons utiliser la connexion à notre base de données sur différentes pages de notre site et que nous ne voulons pas modifier par erreur les valeurs contenues dans nos variables, $dsn, $user et $mdp, c'est donc d'utiliser les constantes plutôt que des variables. 


define('DSN', 'mysql:host=localhost;dbname=chiencool');
define('USER', 'chiencool');
define('MDP', 'chiencool');

//$connexionDB = new PDO(DSN, USER, MDP);

try {
    $connexionDB = new PDO(DSN, USER, MDP);
} catch (PDOException $erreur){
    echo 'Connexion échouée car'.$erreur->getMessage();
}

/* ETAPE 3 : La REQUETE */

// Une fois qu'on a notre connextion, on va pouvoir communiquer avec notre base de données afin de créer, lire, supprimer, modifier des données. On va passer par le langague SQL

$sql = "SELECT * from article";

$pdoStatement = $connexionDB->query($sql);

var_dump($pdoStatement);





