<html>
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <h1>Noter des élèves</h1>
    <br>
    
    <?php
    //Connexion à la BDD
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p015'; 
    $dbpass = 'IeqTr7s1e4D0';
    $dbname = 'nf92p015';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    mysqli_set_charset($connect, 'utf8');

    $idseance = $_POST['idseance'];

    $query = "SELECT eleves.nom, eleves.prenom, inscription.note, eleves.ideleve
              FROM eleves, inscription 
              WHERE eleves.ideleve=inscription.ideleve
              AND inscription.idseance=$idseance
              ORDER BY eleves.nom";
    //echo "<br>$query<br>";
    $result = mysqli_query($connect, $query);
    //résultat : 0:nom, 1:prénom, 2:note, 3:ideleve

    if (!$result)
        {
        echo 'Requête invalide et voici le code erreur de mysql : '.mysqli_error($connect);
        }
    
    //Vérification : des élèves sont-ils inscrits à la séance ?
    if (mysqli_num_rows($result) == 0){ // il n'y a pas d'élèves inscrits
      echo "<p> Aucun élève n'est inscrit à cette séance !</p>";
      exit;
    }

    //On crée la page HTML à partir du PHP
    echo "<form action='noter_eleves.php' method='post'>";
    echo "<br><table border=1>";
    echo "<tr> <th>Nom:</th> <th>Prénom:</th> <th>Nombre de fautes:</th> </tr>";
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){ // pour chaque élève inscrit
        echo "<input type='hidden' value='$row[3]' name='ideleve_$row[3]'>";
        echo "<tr>";
        echo "  <td> $row[0]</td>";
        echo "  <td> $row[1]</td>";
        if($row[2] == -1){ // si l'élève n'est pas encore noté, le champ est vide
            echo "<td><input type='number' name='nbfautes_$row[3]' min='0' max='40' id='nombre' required></td>";
        }
        else{ //si l'élève est noté, on crée un input avec le nombre de fautes actuel déjà rentré.
            $fautes = 40 - $row[2]; //on a stocké la note, on la retransforme en nombre de fautes
            echo "<td><input type='number' name='nbfautes_$row[3]' min='0' max='40' id='nombre' value='$fautes' required></td>";
        }
        echo "</tr>";
    }
    echo "</table>";

    echo "<input type='hidden' name='idseance' value='$idseance'>";
    echo "<br>";
    echo "<input type='submit' value='Valider'>";
    echo "</form>";

    mysqli_close($connect);
    ?>