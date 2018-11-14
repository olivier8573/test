<?php


// Déclaration des constantes (DSN = Data Source Name) qui vont permettre ensuite la connexion plus bas (gérée par l'extension PDO (interface PHP / MySQL))
const DSN = 'mysql:host=localhost;dbname=classicmodels;charset=UTF8';
const DB_USER = 'root';
const DB_PASS = 'troiswa';


$results = [];

// Tentative d'exécution 'try' qui sous-entend qu'une alternative 'catch' peut être précisée (afin notamment d'éviter d'afficher le mot de passe en clair en cas d'échec) / La flèche correspond à l'équivalent du "." de Javascript suivie d'une fonction qui est propre à l'objet PDO
try {

        // Etape 1 : connexion avec création d'une variable dbh (database handler (gestionnaire de base de données)) qui utilise les constantes définies plus haut (PDO = PHP Data Object) / La deuxième ligne attribue des caractéristiques pour gérer les éventuelles erreurs : s'il n'y a pas d'erreur, cette ligne n'est pas nécessaire
        $dbh = new PDO(DSN,DB_USER,DB_PASS);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Etape 2 : préparation de la requête
        $sth = $dbh->prepare('SELECT orderNumber, orderDate, requiredDate, status FROM orders');

        // Etape 3 : exécution de la requête (pas de paramètres supplémentaires à transmettre dans les parenthèses)
        $sth->execute();

        // Etape 4 : stockage des résultats dans la variable $results (l'attribut fetchAll permet de préciser que l'on veut le résultat sous la forme d'un tableau ASSOCIATIF, on aurait pu mettre FETCH_NUM pour avoir un tableau avec des index classés par numéros)
        $results = $sth->fetchAll(PDO::FETCH_ASSOC);

}

// Alternative en cas d'échec au 'try'
catch(PDOException $e) {

    $error = 'Une erreur de connexion a eu lieu'.$e->getMessage();
}

include('tpl/index.phtml');