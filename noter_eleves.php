<head>
  <meta charset="utf-8">
  <title>Noter élèves</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Noter élèves</h1>
  <?php
  //Connexion BDD
  $dbhost = 'tuxa.sme.utc';
  $dbuser = 'nf92p015';
  $dbpass = 'IeqTr7s1e4D0';
  $dbname = 'nf92p015';
  $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
  mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8

  $idseance = $_POST['idseance'];

  //selection des inscriptions
  $query = "SELECT * FROM inscription WHERE idseance = '$idseance'";
  //echo "<br> $query<br>";
  $result = mysqli_query($connect, $query);
  //résultat : 0:idseance, 1:ideleve, 2:note
  if (!$result){
    echo "Requête invalide et voici le code erreur de mysql :".mysqli_error($connect);
    exit;
  }

  //sélection des élèves inscrits à cette séance
  while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){ //Pour chaque élève inscrit à la séance
    $nb_fautes = $_POST["nbfautes_$row[1]"] ?? '';
    if ($nb_fautes === '') {// si un élève n'a pas été noté
      echo "<p> Au moins un élève n'a pas été noté !</p>";
    } else{ // si le nombre de fautes a bien été rentré
      $ideleve = $_POST["ideleve_$row[1]"];
      $note = 40 - $nb_fautes;

      // change la note dans la table inscription
      $queryI = "UPDATE inscription SET note = $note WHERE ideleve = '$ideleve' AND idseance = '$idseance'";
      $resultI = mysqli_query($connect, $queryI);
      if (!$resultI){
        echo "<p>Requête invalide et voici le code erreur de mysql :</p>".mysqli_error($connect);
        exit;
      }
    }
  }
  echo "<p>Les notes ont bien été mises à jour !</p>";

  mysqli_close($connect);
  ?>
</body>
