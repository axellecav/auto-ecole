<html>
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <h1>Ajout d'une séance</h1>
    <br>
    <div>
    <?php
    //Connexion BDD
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p015';
    $dbpass = 'IeqTr7s1e4D0'; 
    $dbname = 'nf92p015';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    mysqli_set_charset($connect, 'utf8');

    //Sélection des thèmes actifs
    $query = 'SELECT * FROM themes WHERE supprime=0 ORDER BY nom';
    //echo "<br>$query<br>";
    //retourne dans les thèmes actifs : idtheme, nom, supprime, descriptif
    $result = mysqli_query($connect, $query);
    if (!$result) 
        {
        echo 'Requête invalide et voici le code erreur de mysql : '.mysqli_error($connect);
        }

    //On crée la page HTML à partir du PHP
    echo "<form method='post' action='ajouter_seance.php'>";
    echo "<select name = 'idtheme' size = '4' required>";
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){ //affiche une ligne pour chaque thème actif
        echo "<option value = '$row[0]'> $row[1] </option>"; //row[0]:idtheme, row[1]:nom
    }
    echo "</select>";
    echo "<br>";

    echo "<br>";
    echo "<label for='date'>Date : </label>";
    echo "<input type='date' id='date' name='date' required/>";
    echo "<br>";    
    echo "<br>";

    echo "<label for='effectif'>Effectif maximum : </label>";
    echo "<input type='number' id='effectif' name='effectif' required/>";
    echo "<br>";

    echo "<br>";
    echo "<input type='submit' value='Valider'/>";
    echo "</form>";


    mysqli_close($connect);
    ?>
    </div>

    

</body>
</html>