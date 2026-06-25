<html>
	<head>
		<title>ajouter un élève</title>
		<meta charset = "utf-8"/>
        <link href="style.css" rel="stylesheet">
	</head>

	<body>
		<h1>Ajouter un élève</h1>
        <?php        
        $oui_non = $_POST['oui_non'];
		//echo "<br> Vous avez sélectionné : $oui_non";

        if($oui_non=='non'){
            echo "<br><p> Abandon de l'ajout de l'élève.</p>";
            exit;
        } 

        //connexion à la BDD
        date_default_timezone_set('Europe/Paris');
        $date = date("Y-m-d");
        $dbhost = 'tuxa.sme.utc';
        $dbuser = 'nf92p015';
        $dbpass = 'IeqTr7s1e4D0';
        $dbname = 'nf92p015';
        $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
        mysqli_set_charset($connect, 'utf8');
        
        $nom = $_POST['nom'];
        //echo "<br> le nom à ajouter est : $nom";
        $prenom = $_POST['prenom'];
        //echo "<br> le prénom à ajouter est : $prenom";
        $dateNaiss = $_POST['dateNaiss'];
        //echo "<br> la date du jour est : $date";

        $query = "INSERT INTO eleves VALUES (NULL, '$nom', '$prenom', '$dateNaiss', '$date')";
        //echo "<br>$query<br>";

        $result = mysqli_query($connect, $query);
        if (!$result){
            echo "<br>Requête invalide et voici le code erreur de mysql :".mysqli_error($connect);
        }
        echo "<p>L'élève a bien été ajouté ! </p>";
        mysqli_close($connect);
        ?>
	</body>
</html>
