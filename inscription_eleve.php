<html>
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <h1>Inscrire un élève</h1>
    <br>
    <div>    
    <?php
    //Connexion à la BDD
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p015';
    $dbpass = 'IeqTr7s1e4D0';
    $dbname = 'nf92p015'; 
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    mysqli_set_charset($connect, 'utf8');

    $qE = 'SELECT * FROM eleves ORDER BY nom'; //Sélectionner tous les élèves
    //echo "requête élèves : $qE";
    $rE = mysqli_query($connect, $qE);
    if (!$rE)
        {
        echo 'Requête invalide et voici le code erreur de mysql : '.mysqli_error($connect);
        }

    $qS = 'SELECT * FROM seances 
           INNER JOIN themes 
           ON seances.Idthemes=themes.idtheme 
           WHERE DateSeance>=CURDATE() AND themes.supprime=0
           ORDER BY seances.DateSeance;';
    //retourne pour les séances de thèmes actifs situées dans le futur : 
    //0:idseance, 1:DateSeance, 2:EffMax, 3:Idthemes, 4:idtheme, 5:nom, 6:supprime, 7:descriptif
    //echo "requête séances : $qS";
    $rS = mysqli_query($connect, $qS); // $query utilise comme parametre de mysqli_query
    if (!$rS)
        {
        echo 'Requête invalide et voici le code erreur de mysql : '.mysqli_error($connect);
        }

    //On crée la page HTML à partir du PHP
    echo "<form method='post' action='inscrire_eleve.php'>";
    //choix parmi les étudiants
    echo "<table><tr><td>";
    echo "<select name = 'ideleve' size = '4' required>"; //pour chaque étudiant crée une option
    while ($rowE = mysqli_fetch_array($rE, MYSQLI_NUM)){
        echo "<option value = '$rowE[0]'> $rowE[1] $rowE[2] </option>";
    }
    echo "</select></td><td>";
    //choix parmi les séances
    echo "<select name = 'idseance' size = '4' required>"; //pour chaque séance active crée une option
    while ($rowS = mysqli_fetch_array($rS, MYSQLI_NUM)){
        echo "<option value = '$rowS[0]'> $rowS[1] $rowS[5] </option>";
    }
    echo "</td></tr></table>";
    echo "</select>";
    echo "<br>";
    echo "<input type='submit' value='Valider'/>";
    echo "</form>";


    mysqli_close($connect);
    ?>  
    </div>
</body>
</html>