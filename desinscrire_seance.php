<head>
    <meta charset="utf-8">
    <title>Désinscription séance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1> Désinscrire un élève d'une séance </h1>
    <h2> Désinscription de l'élève à la séance demandée </h2>
    <div>
    <?php
    //connexion à la BDD
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p015';
    $dbpass = 'IeqTr7s1e4D0';
    $dbname = 'nf92p015';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8

    //transmission de sdonnées du formulaire
    $ideleve = $_POST["ideleve"];
    //echo "id de l'élève sélectionné : $ideleve";
    $idseance = $_POST["idseance"];
    //echo "id de la séance sélectionnée : $idseance";

    //suppression de l'inscription
    $query = "DELETE FROM inscription WHERE ideleve='$ideleve' AND idseance='$idseance'";
    $result = mysqli_query($connect, $query);

    if (!$result){
    echo "<p>Requête invalide et voici le code erreur de mysql : </p>".mysqli_error($connect);
    }else{
    echo "<p>L'élève a bien été désinscrit de la séance !</p>";
    }
    
    mysqli_close($connect);
    ?>
    </div>
</body>