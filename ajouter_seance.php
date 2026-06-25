<html>
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <h1>Ajout d'une séance</h1>

    <div>
    <?php
    //connexion à la base de données
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p015';
    $dbpass = 'IeqTr7s1e4D0';
    $dbname = 'nf92p015';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    mysqli_set_charset($connect, 'utf8');


    $Idthemes = $_POST['idtheme'];
    //echo "<br> Le thème choisi est le numéro $Idthemes";

    $date = $_POST['date'];
    //echo "<br> La date saisie est : $date";

    $effMax = $_POST['effectif'];
    //echo "<br> L'effectif est : $effMax";

    $query = "INSERT INTO seances VALUES (NULL, '$date', $effMax, $Idthemes)";
    //echo "<br>$query<br>";
    //requête ajoute à la BDD une séance avec les valeurs du formulaire

    //vérification que la date est vraiment dans le futur : 
    date_default_timezone_set('Europe/Paris');
    $dateDuJour = date("Y\-m\-d");
    //echo "<br> la date du jour est : "."'$date'"." <br>";
    if($date<$dateDuJour){
        echo "<br>Il est impossible de créer une séance dans le passé.";
        exit;
    }

    //Vérification que l'effectif est >0
    if($effMax<=0){
        echo "<p>L'effectif doit être strictement positif</p>";
        exit;
    }

    //Vérification qu'il n'existe pas d'autre séance pour ce thème à cette date
    $qverif = "SELECT * FROM seances WHERE Idthemes=$Idthemes AND DateSeance='$date'";
    //renvoie, s'il y a une séance pour ce même thème le même jour : idseance, DateSeance, EffMax, Idthemes
    $rverif = mysqli_query($connect, $qverif);
    //echo "<br>Requête vérification : $qverif";
    if (!$rverif){
        echo "<br>pas bon  ".mysqli_error($connect);
    }

    $n = mysqli_num_rows($rverif); //compte le nombre de résultats de la requête

    if($n==0){ //s'il n'y a pas d'autre séance pour ce thème à cette date, on peut ajouter
        $result = mysqli_query($connect, $query);
        //echo "<br>Requête : $query";
        if (!$result){
            echo "<br>pas bon  ".mysqli_error($connect);
        }
        echo "<br><p>Séance ajoutée avec succès !</p>";

    }else{//il y a déjà une séance du thème à cette date
        echo "<br><p>Une séance du thème choisi existe déjà à cette date.";
        echo "<br>Impossible d'ajouter deux séances du même thème à la même date.</p>";
    }
    mysqli_close($connect);
    ?>
    </div>
</body>
</html>

