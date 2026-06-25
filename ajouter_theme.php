<html>
	<head>
		<title>traitement ajout thème</title>
		<meta charset = "utf-8"/>
		<link href="style.css" rel="stylesheet">
	</head>

	<body>
		<h1>Ajout d'un thème</h1>
		
		<div>
		<?php
		//connexion BDD
		$dbhost = 'tuxa.sme.utc';
		$dbuser = 'nf92p015';
		$dbpass = 'IeqTr7s1e4D0';
		$dbname = 'nf92p015';
		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
		mysqli_set_charset($connect, 'utf8');

		//initialisation de supprime
		$supprime = 0;

		//Récupération valeurs formulaire
		$nom = $_POST['nom'];
		//echo "<br> le nom saisi est : $nom";
		$descriptif = $_POST['descriptif'];
		//echo "<br> le descriptif saisi est : $descriptif";

		//vérification qu'aucun autre thème actif n'a le même nom
		$qverif = "SELECT * FROM themes WHERE nom='$nom'";
		//echo "<br>requête de vérification du nom : $qverif<br>";
		//renvoie les attributs du thème avec le même nom s'il existe
		$rverif = mysqli_query($connect, $qverif);
		$n = mysqli_num_rows($rverif);

		if($n==0){ //si aucun thème ne porte le même nom, on peut ajouter
			$query = "insert into themes values (NULL, '$nom', $supprime, '$descriptif')";
			//echo "<br>requête : $query<br>";
			$result = mysqli_query($connect, $query);
			if (!$result){
				echo "<br>Requête invalide et voici le code erreur de mysql : ".mysqli_error($connect);
				exit;
			}
			echo "Le thème $nom a bien été ajouté !";
		}else{
			$row = mysqli_fetch_assoc($rverif); //récupère attributs de la valeur trouvée
			$supprime = $row['supprime']; //réécupère la valeur de l'attribut supprime
			//echo "<br>supprime = $supprime";

			if($supprime == 0){ //si le thème est actif
				echo "<br><p>Un thème porte déjà ce nom.<p/><br>";
				echo "<p>On ne peut pas créer deux thèmes avec le même nom</p><br>";
			}else{ //thème a ete supprimé précédemment
				echo "<br><p>Ce thème existe mais avait été supprimé.</p><br>";
				$query = "UPDATE themes SET supprime=0 WHERE nom='$nom'"; 
				//modifie l'attribut supprime du thème portant le même nom de 0 à 1
				//echo "<br>requête : $query<br>";
				$result = mysqli_query($connect, $query);
				if (!$result){
					echo "<br>Requête invalide et voici le code erreur de mysql : ".mysqli_error($connect);
				}
				echo "<p>Le thème a bien été réactivé. </p><br>";
			}	
		}

		mysqli_close($connect);
		?>
		</div>
	</body>
</html>