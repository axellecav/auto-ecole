<head>
    <meta charset="utf-8">
    <title>Supprimer un thème</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1> Supprimer un thème : </h1>
    <h2> Suppression du thème </h2>
    <?php
    //connexion à la bas de données
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p015';
    $dbpass = 'IeqTr7s1e4D0';
    $dbname = 'nf92p015';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8

    //transmission des données du formulaire
    $idtheme = $_POST["idtheme"];
    //echo "id du thème choisi : $idtheme";

    //suppression du thème dans la base de données
    $query = "UPDATE themes SET supprime = 1 WHERE idtheme = '$idtheme'";
    //echo "<br>$query<br>";
    $result = mysqli_query($connect, $query);

    if (!$result){
        echo "<p>Requête invalide et voici le code erreur de mysql :</p>".mysqli_error($connect);
        exit;
    }
    echo "<p>Le thème a bien été supprimé !</p>";
    ?>
</body>