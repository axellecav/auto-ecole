<head>
    <meta charset="utf-8">
    <title>Visualisation calendrier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1> Visualiser le calendrier d'un élève : </h1>
    <h2> Calendrier de l'élève </h2>
    <?php
    //connexion à la base de données
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p015';
    $dbpass = 'IeqTr7s1e4D0';
    $dbname = 'nf92p015';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8

    $ideleve=$_POST['ideleve'];
    //echo "id de l'élève sélectionné : $ideleve";

    //sélection des inscriptions de l'élève dans le futur
    $query = "SELECT * FROM inscription 
              INNER JOIN seances ON seances.idseance=inscription.idseance 
              INNER JOIN themes ON seances.Idthemes=themes.idtheme 
              WHERE Dateseance>=CURDATE() AND ideleve=$ideleve";
    //renvoie : idseance, ideleve, note, idseance, Dateseance, Effmax, idtheme, idtheme, nom, supprime, descriptif
    $result = mysqli_query($connect, $query);
    if (!$result){
    echo "<p>Requête invalide et voici le code erreur de mysql :</p>".mysqli_error($connect);
    exit;
    }

    if (mysqli_num_rows($result)==0){ // il n'y a pas d'inscription dans le futur
        echo"<p>L'élève n'est encore inscrit à aucune séance dans le futur !</p>";
    }
    else{
        echo "<table class='table' border=1>";
        echo "<tr><th>Thème de la séance</th> <th>Date de la séance</th></tr>";
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
            echo "<tr>";
            echo "<td>$row[8]</td>";
            echo "<td>$row[4]</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<br>";
    }

    mysqli_close($connect);

    ?>
</body>