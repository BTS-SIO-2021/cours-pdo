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

// La methode query ne renvoie pas directement les données prêtes à être affichées. Pour faire cela une dernière opérations, utiliser soit la méthode fetch() soit la méthode fetchAll();

// La méthode fetch() lit ligne par ligne les résultats. Elle est donc moins "gourmande" en ressources. Evidement si je veux lire tous les résultats, il faut que je créé une boucle. Elle est particulièrement utilisée pour traiter les résultats très nombreux.
$resultats = $pdoStatement->fetch(PDO::FETCH_ASSOC);

var_dump($resultats);

// La méthode fetchAll() récupère d'un coup tous les résultats. C'est pratique car on a tout d'un seul coup. L'inconvénient c'est que du coup, on peut vite saturé (si trop de données) nos ressources. 
$autresResultats = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

var_dump($autresResultats);

$sql = "INSERT INTO article (title, content, author, date, category) VALUES ('Les chiens sont les meilleurs amis des humains', 'blalblalbalbla bbbalalala', 'Mathilde', '202é-03-21', 'Loisirs')";

$lignesModifiees = $connexionDB->exec($sql);

var_dump($lignesModifiees); 

// Les requêtes préparées <3 c'est la même chose que ci-dessus sauf que ça nous protège d'attaques éventuelles, notamment les injections SQL : https://fr.wikipedia.org/wiki/Injection_SQL

$author = "Clement";
$title = "Les poils des chiens c'est chiant";


$sql = "INSERT INTO article (title, content, author, date, category) VALUES (:title, 'blalblalbalbla bbbalalala', :author, '202é-03-21', 'Loisirs')";

$requetePrepare = $connexionDB->prepare($sql);
$requetePrepare->bindValue(':title', $title);
$requetePrepare->bindValue(':author', $author);
$resultats = $requetePrepare->execute();
var_dump($resultats);

/*
RECAPITULATIF

Pour me connecter à la base de données, j'utilise la classe PDO. Une fois que j'ai un objet PDO, je peux : 
- écrire des requêtes SQL
1) si je veux lire des données présentes dans ma BDD, j'utilise la méthode query() sur mon objet PDO. Pour ensuite récupérer les résulats (pour par exemple les afficher), j'utilise les méthodes fetch ou fetchAll sur l'objet PDOStatement que me retourne la méthode query().

2) si je veux modifier, supprimer, créer des données dans ma bdd j'utilise la méthode exec() sur mon objet PDO. SAUUUUUF si les données que je veux modifier, supprimer, créer viennent de formulaires remplis par des utilisateurs lambda. DANS CE CAS j'utilise les requetes preparées. Soit sur mon objet PDO, la méthode prepare() puis je "lie" mes jetons à mes valeurs via la méthode bindValue(), enfin j'appelle la méthode execute();
*/



