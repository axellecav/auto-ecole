<head>
    <meta charset="utf-8">
    <title>Ajouter un thème</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1> Consulter les informations d'un élève : </h1>
    <h2>Informations de l'élève</h2>
    <?php
    //connexion à la BDD
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p015';
    $dbpass = 'IeqTr7s1e4D0';
    $dbname = 'nf92p015';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8

    //transmission du ideleve du formulaire
    $ideleve = $_POST["ideleve"];
    //echo "ideleve sélectionné : $ideleve";

    //sélection de l'élève demandé
    $query = "SELECT * FROM eleves WHERE ideleve = '$ideleve'";
    //retourne pour l'élève avec l'id sélectionné dans le form d'avant : ideleve, nom, prenom, dateNaiss, dateInscription
    //echo "requête : $query";
    $result = mysqli_query($connect, $query);
    if (!$result){
        echo "<p>Requête invalide et voici le code erreur de mysql :r</p>".mysqli_error($connect);
        exit;
    }

    //affichage des informations de l'élève dans un tableau
    echo "<table class='table' border=1>";
    echo "<tr> <th>identifiant</th> <th>Nom</th> <th>Prénom</th> <th>Date de naissance</th> <th>Date d'inscription</th></tr>"; //ajoute des titres
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){ // affiche  les informations de l'élève
        echo "<tr>";
        echo "  <td>$row[0]</td>"; //ideleve
        echo "  <td>$row[1]</td>"; //nom
        echo "  <td>$row[2]</td>"; //prenom
        echo "  <td>$row[3]</td>"; //dateNaiss
        echo "  <td>$row[4]</td>"; //dateInscription
        echo "</tr>";
    }
    echo "</table>";

    mysqli_close($connect);

    ?>
</body>