<?php
	if(array_key_exists('status', $_SESSION))
	{

       	include_once 'DBConnect.php';
    	$database = new dbConnect();
    	$db = $database->openConnection();


		$categories = array("astrophysics", "cosmology", "particles", "planetology", "hazards", "earthext", "earthint"); // Do not translate this line
		$categories_titles = array("Astrophysique", "Cosmologie", "Physique des particules", "Planétologie", "Dangers naturels", "Enveloppes extérieures de la Terre", "Intérieur de la Terre");

		$types = array ("talk" => "Oral", "poptalk" => "Oral de vulgarisation", "poster" => "Poster");

		/*$keyword = array("k0", "k1", "k2", "k3", "k4", "k5", "k6", "k7","k8","k9","k10", "k11", "k12", "k13", "k14", "k15", "k16", "k17","k18","k19","k20", "k21", "k22", "k23", "k24", "k25", "k26");
		$keyword_name = array("k0" => "Beyond the Standard Model", "k1" => "Black Holes", "k2" => "Climatology", "k3" => "CP violation and flavor physics", "k4" => "Dark energy", "k5" => "Dark matter", "k6" => "Geo and cosmochemistry", "k7" => "Geodynamics", "k8" => "Geomorphology", "k9" => "High energy astrophysics", "k10" => "Instrumentation", "k11" => "Large structures","k12" => "Magnetism", "k13" => "Microbiology", "k14" => "Neutrino", "k15" => "Neutron star", "k16" => "Petrology","k17" => "Planet and star formation", "k18" => "Primordial cosmology", "k19" => "Rock mechanics", "k20" => "Sedimentology", "k21" => "Seismology", "k22" => "Spatial geodesy", "k23" => "Standard Model", "k24" => "Stochastic background", "k25" => "Transport phenomena", "k26" => "Volcanology");*/
		
		
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$upload_check = 1;
		    if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0)
		    {
				$target_dir = "abstracts/";
				$target_file = $target_dir . basename($_FILES["file"]["name"]);
				$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

				if($imageFileType != "pdf")
				{
				    echo "<strong>Seul le format PDF est accepté.</strong></br>";
				    $upload_check = 0;
				}
			}
			else
			{
				$upload_check = 0;
			}

			if ($upload_check == 0)
			{
			    echo "<strong>Désolé, un problème s'est produit lors de l'envoi du fichier.</strong>";
			}
			else
			{
			    if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file))
			    {
			        $message[] = "<strong>The file ". basename( $_FILES["file"]["name"]). " has been uploaded.</strong>";

			        // Add title and id to the database
			    	$id = $_SESSION['id'];
			    	$email = $_SESSION['email'];
			    	$first_name = $_SESSION['first_name'];
			    	$last_name = $_SESSION['last_name'];
				    $title = htmlspecialchars(stripslashes(utf8_decode($_POST['title'])));
					$category = $_POST['category'];
					$type = $_POST['type'];
					$affiliation = htmlspecialchars(stripslashes(utf8_decode($_POST['affiliation'])));

				    $sql = "select * from uploaded_abstracts where id = (:id)";
				    $query = $db->prepare($sql);
				    $user = $query->execute(array('id' => $id));

					$result = $query->fetchAll(PDO::FETCH_ASSOC);

				    if (count($result) == 0)
			    	{
				    	$query = $db->prepare("INSERT INTO uploaded_abstracts (id, title, type, email, first_name, last_name, affiliation, category) VALUES (:id, :title, :type, :email, :first_name, :last_name, :affiliation, :category)");
				    	$query->execute(array('id' => $id, 'title' => $title, 'type' => $type, 'email' => $email, 'first_name' => $first_name, 'last_name' => $last_name, 'affiliation' => $affiliation, 'category' => $category));
				    }
			    }
			}

			rename($target_dir . $_FILES["file"]["name"], "abstracts/abstract" . $_SESSION['id'] . ".pdf");
		}
	
		if($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'program' || $_SESSION['status'] == 'foreign')
		{
			echo '<h2 class="major">Résumés soumis</h2>';
			
			$sql = "select * from uploaded_abstracts";
			$query = $db->prepare($sql);
			$user = $query->execute();
			$result = $query->fetchAll(PDO::FETCH_ASSOC);
			$nb_total = count($result);

			if ($nb_total != 0)
			{
				$index = 0;
				foreach($categories as $cat)
				{
					$sql = "select * from uploaded_abstracts where category = ?";
					$query = $db->prepare($sql);
					$user = $query->execute(array($cat));
					$result = $query->fetchAll(PDO::FETCH_ASSOC);
					$nb_cat = count($result); // Number of abstract in this category

					if ($nb_cat>0)	
					{
						echo "<h3>" . $categories_titles[$index] . "</h3>";
						echo '<ul>';
					    for ($i = 0; $i < $nb_cat; $i++)
					    {
						    		$abst = $result[$i];

						    		$abst_id = $abst['id'];
						    		$abst_title = $abst['title'];
						    		$abst_first_name = $abst['first_name'];
									$abst_last_name = $abst['last_name'];
									$abst_email = $abst['email'];
									$abst_affiliation = $abst['affiliation'];
									$abst_type = $abst['type'];

						    		$link = '<li><strong><a href=download.php?file=abstract' . $abst_id . '.pdf> "' . $abst_title . '"</a></strong>, ' . lcfirst($types[$abst_type]) .' par ' . $abst_first_name . ' ' . $abst_last_name . ' ('.$abst_affiliation.', ' . $abst_email . ')</li>';

						    		echo $link;

						}
						echo '</ul>';
				    }
					$index ++;
			    }
			}
			else
			{
				echo 'Aucun résumé n\'a été reçu pour le moment.';
			}
		}
	?>

	<h2 class="major"> Soumettre un résumé</h2>

	<p>Pour soumettre un résumé, veuillez remplir le formulaire ci-dessous en indiquant 
	le titre et la catégorie correspondant à votre travail. S'il vous plait, pensez à insérer 
	<strong>deux mots-clés parmi la liste ci-dessous</strong> dans votre pdf.
	<strong>Seul le format PDF</strong> est accepté.</p>

	<p>Chaque personne peut ajouter au plus un résumé. Si vous voulez la modifier, 
	vous pouvez soumettre une nouvelle version. Si vous voulez modifier le titre, 
	veuillez nous contacter.</p>

	<!-- Need to compare the date to the deadline before displaying this form -->
	<form action="" method="post" enctype="multipart/form-data">
	    <?php
	        if (! empty($message) && is_array($message))
	        {
		    ?>
	            <div class="error-message">
		            <?php 
	                    foreach($message as $msg) {
	                        echo "<strong>" . $msg . "</strong><br/>";
	                    }
	                ?>
	            </div>
		    <?php
	        }
	    ?>

		<div class="field">
			<label for="title">Titre de la présentation :</label>
			<input type="text" name="title" id="title" required/>
		</div></br>

		<div class="field">
			<label for="affiliation">Laboratoire/Institut/Collaboration :</label>
			<input type="text" name="affiliation" id="affiliation" required/>
		</div> </br>

		<div class="select">
			<label>Type de présentation :</label>
			<select name="type" required>
				<option></option>
						<option value="talk">Oral</option>
						<option value="poptalk">Oral de vulgarisation</option>
						<option value="poster">Poster</option>
 			</select>
		</div> </br>

		<div class="select">
			<label>Catégorie :</label>
			<select name="category" required>
				<option></option>
				<?php
					foreach($categories as $key => $value)
					{
						echo "<option value=" . $categories[$key] .">" . $categories_titles[$key] . "</option>";
					}
				?>
 			</select>
		</div> </br>
		<div>
		    Choisir le fichier à envoyer : </br>
		    <input type="file" name="file" id="file" required> </br></br>
		</div>
		<!-- <div class="checkbox">
			<label>Mot-clés :</label>
				<?php
					//foreach($keyword_name as $key => $value)
					//{
					//	echo "<input type='checkbox' name=" . $keyword[$key] ." id=" . $keyword[$key] ."checked='checked'/> <label //for='".$keyword[$key] ."'>". $keyword_name[$key] . "</label>";
					//}
				?>
		</div> </br> -->
		    <input type="submit" value="Soumettre" name="upload-file">
	</form>

	<div>
		Mots-clés indicatifs :
			<ul>
				<li>Beyond the Standard Model</li>
				<li>Black Holes</li>
				<li>Climatology</li>
				<li>CP violation and flavor physics</li>
				<li>Dark energy</li>
				<li>Dark matter</li>
				<li>Geo and cosmochemistry</li>
				<li>Geodynamics</li>
				<li>Geomorphology</li>
				<li>High energy astrophysics</li>
				<li>Instrumentation</li>
				<li>Large structures</li>
				<li>Magnetism</li>
				<li>Microbiology</li>
				<li>Neutrino</li>
				<li>Neutron star</li>
				<li>Petrology</li>
				<li>Planet and star formation</li>
				<li>Primordial cosmology</li>
				<li>Rock mechanics</li>
				<li>Sedimentology</li>
				<li>Seismology</li>
				<li>Solar and stellar physics</li>
				<li>Spatial geodesy</li>
				<li>Standard Model</li>
				<li>Stochastic background</li>
				<li>Sun and Solar system</li>
				<li>Tectonics</li>
				<li>Transport phenomena</li>
				<li>Volcanology</li> 
		</ul>
	<div>

<?php
	}
	else
	{
		echo '<strong>Accès refusé.</strong>';
	}
?>
