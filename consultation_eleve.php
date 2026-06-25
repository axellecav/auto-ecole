<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Ajouter un thème</title>
        <link rel="stylesheet" href="style.css">
    </head>
<body>
    <h1> Consulter les informations d'un élève : </h1>
    <h2> Sélectionnez un élève dont consulter les informations </h2>
    <div>
    <?php
    // connexion à la BDD
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p015';
    $dbpass = 'IeqTr7s1e4D0';
    $dbname = 'nf92p015';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    mysqli_set_charset($connect, 'utf8');

    //Sélection de tous les élèves pour les afficher
    $query = "SELECT * FROM eleves ORDER BY nom";
    //echo "<br>requête : $query";
    //retourne : ideleve, nom, prenom, dateNaiss, dateInscription
    $result = mysqli_query($connect, $query);
    if (!$result){
        echo "<p>Requête invalide et voici le code erreur de mysql : </p>".mysqli_error($connect);
        exit;
    }

    //Génération d'un formulaire par le PHP
    echo "<form method='post' action='consulter_eleve.php'";
    echo "<p>Veuillez sélectionner un élève</p>";
    echo "<select name='ideleve' size='4' required>";

    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){ // pour chaque élève dans la base, affiche nom prénom et dateNaiss
        echo "<option value=$row[0]>$row[1] $row[2], naissance le : $row[3]</option>";
    }//row0 : ideleve, row1 : nom, row2 : prenom, row3 : dateNaiss
    echo "</select>";

    echo "<br>";
    echo "<input type='submit' value='Valider'>";

    echo "</FORM>";

    mysqli_close($connect);
    ?>
    </div>
</body>