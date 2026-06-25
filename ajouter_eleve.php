<html>
	<head>
		<title>traitement ajout élève</title>
		<meta charset = "utf-8"/>
		<link href="style.css" rel="stylesheet">
	</head>

	<body>
		<h1>Ajouter un élève</h1>
		<div>
		<?php
		//stockage de la date du jour
		date_default_timezone_set('Europe/Paris');
		$date = date("Y-m-d");
		//connexion à la BDD
		$dbhost = 'tuxa.sme.utc';
		$dbuser = 'nf92p015';
		$dbpass = 'IeqTr7s1e4D0';
		$dbname = 'nf92p015';
		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
		mysqli_set_charset($connect, 'utf8');


		$nom = $_POST['nom'];
		//echo "<br> le nom saisi est : $nom";
		$prenom = $_POST['prenom'];
		//echo "<br> le prénom saisi est : $prenom";
		$dateNaiss = $_POST['date_naissance'];
		//echo "<br> la date du jour est : $date";

		//vérification 1 : la date de naissance est dans le passé
		if($dateNaiss>$date){
			echo "<br><p>L'élève doit être né dans le passé !</p>";
			exit;
		}
		
		//vérification 2 : existe-t-il un eleve avec meme nom, prénom et date de naissance ?
		$qverif = "SELECT * FROM eleves 
					WHERE nom='$nom' AND prenom='$prenom' AND dateNaiss='$dateNaiss'";
		//echo "<br>$qverif<br>";
		/*retourne, s'il(s) existe(nt) un ou plusieurs élèves avec même nom, prénom, date de naissance, avec les infos :
		ideleve, nom, prenom, dateNaiss, dateInscription*/
		$rverif = mysqli_query($connect, $qverif);
		if (!$rverif){
			echo "<br>Requête invalide et voici le code erreur de mysql :  ".mysqli_error($connect);
			exit;
		}

		$n = mysqli_num_rows($rverif); //renvoie le nombre de résultats de la requête
		if($n==0){
			//pas d'élève du même nom, on ajout l'élève
			$query = "insert into eleves values (NULL, '$nom', '$prenom', '$dateNaiss', '$date')";
			//echo "<br>$query<br>";
			$result = mysqli_query($connect, $query);
			if (!$result){
				echo "<br>Requête invalide et voici le code erreur de mysql :  ".mysqli_error($connect);
				exit;
			}
			echo "<p>L'élève a bien été ajouté ! </p>";


		}else{ //il y a un élève de même nom, prénom, date de naissance, on demande à l'utilisateur s'il veut vraiment l'ajouter
			echo "<form method='post' action='valider_eleve.php'>";
			echo "Il existe au moins un élève avec le même nom, prénom et date de naissance. <br>Voulez-vous continuer ?";
			echo "<br>";    
			//transmission des infos du premier formulaire de manière cachée
			echo "<input type = 'hidden' Value = '$nom' name = 'nom'>";
			echo "<input type = 'hidden' Value = '$prenom' name = 'prenom'>";
			echo "<input type = 'hidden' Value = '$dateNaiss' name = 'dateNaiss'>";
			echo "<br>";
			//demande à l'utilisateur s'il veut continuer
			echo "<input type='radio' name='oui_non' value= 'oui' required/> Oui <br>";
			echo "<input type='radio' name='oui_non' value= 'non' required/> Non <br>";


			echo "<br>";
			echo "<input type='submit' value='Valider'/>";
			echo "</form>";
		}
		mysqli_close($connect);
		?>
		</div>
	</body>
</html>

