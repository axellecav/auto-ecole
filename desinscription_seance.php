<head>
    <meta charset="utf-8">
    <title>Désinscription séance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1> Désinscrire un élève d'une séance </h1>
    <h2> Sélectionnez un élève à désincrire </h2>
    <div>
    <?php
    //connexion à la BDD
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p015';
    $dbpass = 'IeqTr7s1e4D0';
    $dbname = 'nf92p015';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    mysqli_set_charset($connect, 'utf8');

    //sélection de tous les élèves
    $query = "SELECT * FROM eleves ORDER BY nom";
    //retourne, dans l'ordre alphabétique du nom : ideleve, nom, prenom, dateNaiss, dateInscription
    //echo "requête : $query;"
    $result = mysqli_query($connect, $query);
    if (!$result){
        echo "<p>Requête invalide et voici le code erreur de mysql :</p>".mysqli_error($connect);
        exit;
    }

    //formulaire qui affiche une sélection parmi les élèves
    echo "<form method='post' action='valider_desinscription_seance.php'>";
    echo "Sélectionner un élève";
    echo "<select name='ideleve' size=4 required>";
    while($row = mysqli_fetch_array($result, MYSQLI_NUM)){ // affiche le nom prénom et date de  naissance de chaque élève
        echo "<option value=$row[0]>$row[1] $row[2], naissance le : $row[3]</option>";
    }//0:ideleve, 1:nom, 2:prenom, 3:dateNaiss 
    echo "</select>";
    echo "<br>";

    echo "<input type='submit' value='Valider'>";
    echo "</form>";

    mysqli_close($connect);
    ?>
    </div>
</body>