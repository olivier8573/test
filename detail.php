<?php


// Sur cette page, nécessité de se reconnecter (oubli des variables entre deux pages php) avec les quatre étapes (pour exécuter la première requête) puis seulement les trois dernières étapes (si l'on souhaite faire d'autres requêtes)


const DSN = 'mysql:host=localhost;dbname=classicmodels;charset=UTF8';
const DB_USER = 'root';
const DB_PASS = 'troiswa';


$results = [];

// On se sert de $_GET qui a récupéré les paramètres transmis dans l'URL
$numeroCommande = $_GET['id'];


try {

        // Etape 1 : connexion (pas de changement)
        $dbh = new PDO(DSN,DB_USER,DB_PASS);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Etape 2 : il n'est pas possible d'inclure des données dynamiques (comme la variable $numeroCommande), il faut remplacer les données par un ? qui sera renseigné à l'étape 3
        $sth = $dbh->prepare('SELECT * FROM customers INNER JOIN orders ON customers.customerNumber = orders.customerNumber INNER JOIN orderdetails ON orders.orderNumber = orderdetails.orderNumber INNER JOIN products ON orderdetails.productCode = products.productCode WHERE orders.orderNumber = ?');

        // Etape 3 : remplacement du point d'interrogation par la variable souhaitée (s'il y avait plusieurs points d'interrogation dans la requête, il aurait suffit de remplacer les données dans l'ordre des ?)
        $sth->execute(array($numeroCommande));

        // Etape 4
        $results = $sth->fetchAll(PDO::FETCH_ASSOC);

}


catch(PDOException $e) {

    $error = 'Une erreur de connexion a eu lieu'.$e->getMessage();
}

include('tpl/detail.phtml');