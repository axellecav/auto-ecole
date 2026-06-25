<html>
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <h1>Inscrire un élève</h1>
    <br>
    <?php
    //connexion BDD
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p015';
    $dbpass = 'IeqTr7s1e4D0';
    $dbname = 'nf92p015';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    mysqli_set_charset($connect, 'utf8');

    $ideleve = $_POST['ideleve'];
    //echo "<br> Id de l'élève sélectionné : $ideleve";

    $idseance = $_POST['idseance'];
    //echo "<br> Id de la séance sélectionnée :$idseance";

    $query = "INSERT INTO inscription VALUES ($idseance, $ideleve, -1)";
    //echo "<br>$query<br>";

    
    //Vérification que la séance n'est pas pleine
    $query1 = "SELECT * FROM seances WHERE idseance = '$idseance'";
    //renvoie la ligne ayant l'id de la séance sélectionnée
    // echo "<br>$query1<br>";
    $result1 = mysqli_query($connect, $query1);
    if(!$result1){
      echo "Requête 1 invalide et voici le code erreur de mysql : ".mysqli_error($connect);
      exit;
    }

    $row1 = mysqli_fetch_array($result1, MYSQLI_NUM);
    //le tableau retourné ne contient qu'une ligne pcq on a pris le idseance donc le while est exécuté une fois
    $effmax = $row1[2]; // on met l'effectif maximal dans une variable
    // sélection de toutes les inscriptions à la séance
    $query2 = "SELECT * FROM inscription WHERE idseance ='$idseance'";
    //echo "<br>$query2<br>";
    $result2 = mysqli_query($connect, $query2);
    if(!$result2){
        echo "Requête 2 invalide et voici le code erreur de mysql :".mysqli_error($connect);
        exit;
    }

    if (mysqli_num_rows($result2) >= $effmax){ // la valeur de l'effectif maximum a été atteinte
        echo "<p>Cette séance est déjà complète, l'élève ne peut pas s'y inscrire.</p>";
        exit;
    } 
    while ($row2 = mysqli_fetch_array($result2, MYSQLI_NUM)){
        if ($row2[1] == $ideleve){ // l'id de lélève est déjà présent dans l'inscription
            echo "<p>Cet élève est déjà inscrit à cette séance, il ne peut donc pas s'y inscrire une autre fois.</p>";
            exit;
        }
    }
    // l'élève peut être inscrit
    $query3 = "INSERT INTO inscription VALUES('$idseance', '$ideleve', -1)"; 
    //echo "<br>$query3<br>";
    $result3 = mysqli_query($connect, $query3);
    if(!$result3){
        echo "Requête 3 invalide et voici le code erreur de mysql : ".mysqli_error($connect);
    }
    else{
        echo "<p>L'élève a bien été inscrit à la séance !</p>";
    }

    mysqli_close($connect);
    ?>
</body>
</html>
