<head>
    <meta charset="utf-8">
    <title>Visualisation calendrier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1> Visualiser le calendrier d'un élève : </h1>
    <h2> Sélectionnez un élève pour consulter son calendrier </h2>
    <?php
    // connexion à la base de données
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p015';
    $dbpass = 'IeqTr7s1e4D0';
    $dbname = 'nf92p015';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    mysqli_set_charset($connect, 'utf8');

    // sélection de tous les élèves pour les afficher
    $query = "SELECT * FROM eleves ORDER BY nom";
    //echo "<br>$query<br>";
    $result = mysqli_query($connect, $query);

    if (!$result){
        echo "<p>Requête invalide et voici le code erreur de mysql :</p>".mysqli_error($connect);
        exit;
    }

    // mise en place d'un formulaire qui affiche tous les élèves
    echo "<form method='post' action='visualiser_calendrier_eleve.php'";
    echo "<br>Sélectionner un.e élève<br>";
    echo "<select name='ideleve' size='4' required>";
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        echo "<option value=$row[0]>$row[1] $row[2], né.e le $row[3]</option>";
    }
    echo "</select>";
    echo "<br>";
    echo "<input type='submit' value='Valider'>";
    echo "</form>";

    mysqli_close($connect);
    ?>
</body>