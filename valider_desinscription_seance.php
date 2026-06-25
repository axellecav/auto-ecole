<head>
    <meta charset="utf-8">
    <title>Désinscription séance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1> Désinscrire un élève d'une séance </h1>
    <h2> Sélectionnez la séance à laquelle vous désinscrivez l'élève</h2>
    <?php
    //connexion à la base de données
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p015';
    $dbpass = 'IeqTr7s1e4D0';
    $dbname = 'nf92p015';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8

    $ideleve = $_POST["ideleve"];

    //sélection des inscriptions de l'élève portant le ideleve
    $query = "SELECT * FROM inscription 
              INNER JOIN seances 
              ON seances.idseance=inscription.idseance 
              INNER JOIN themes ON seances.Idthemes=themes.idtheme 
              WHERE DateSeance>=CURDATE() AND ideleve=$ideleve
              ORDER BY seances.DateSeance";
    //echo "<br>$query<br>";

    //dans l'ordre, résultat retourné : idseance, ideleve, note, idseance, Dateseance, Effmax, idtheme, idtheme, nom, supprime, descriptif
    $result = mysqli_query($connect, $query);

    if (!$result){
        echo "<p>Requête invalide et voici le code erreur de mysql :</p>".mysqli_error($connect);
        exit;
    }

    if (mysqli_num_rows($result)==0){ // il n'y a pas de séance dans le futur pour vet élève
        echo"<p>Cet élève n'est encore inscrit à aucune séance dans le futur !<p>";
        exit;
    }
    // Sinon, génère un formulaire avec toutes les séances où sont inscrites l'élève dans le futur
    echo "<form method='post' action='desinscrire_seance.php'>";
    echo "Sélectionnez la séance d'où désinscrire l'élève";
    echo "<select name='idseance' id='idseance' size='4' required>";
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){// pour chaque séance affiche son thème et sa date
        echo "<option value='$row[0]'> $row[8] : $row[4]</option>";
        }
    echo"</select>";

    echo "<input type='hidden' value='$ideleve' name='ideleve'>"; // transmet l'id de l'élève
    echo "<br>";
    echo "<input type='submit' value='Valider'>";

    echo "</form>";

    mysqli_close($connect)

    ?>
</body>