<html>
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <h1>Noter les élèves</h1>
    <br>
    
    <?php
    //connexion à la BDD
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p015'; 
    $dbpass = 'IeqTr7s1e4D0';
    $dbname = 'nf92p015';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8

    $query = 'SELECT * FROM seances 
              INNER JOIN themes ON seances.Idthemes=themes.idtheme 
              WHERE DateSeance<CURDATE() AND supprime=0
              ORDER BY seances.DateSeance;';
    //echo "<br>$query<br>";
    //parmi les séances de thèmes actifs, retourne : idseance, DateSeance, EffMax, Idthemes, idtheme, nom, supprime, descriptif
    $result = mysqli_query($connect, $query);
    if (!$result)
        {
        echo 'Requête invalide et voici le code erreur de mysql : '.mysqli_error($connect);
        }

    //On crée la page HTML à partir du PHP
    echo "<form method='post' action='valider_seance.php'>";
    echo "<p>Sélectionner la séance à noter</p>";
    //choix parmi les séances
    echo "<select name = 'idseance' size = '4' required>";
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        echo "<option value = '$row[0]'> $row[1] $row[5] </option>"; // correspond au nom du thème dans la jointure
    }
    echo "</select>";
    echo "<br>";
    echo "<input type='submit' value='Valider'/>";
    echo "</form>";


    mysqli_close($connect);
    ?>
</body>
</html>