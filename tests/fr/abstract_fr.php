<?php
	if(array_key_exists('status', $_SESSION))
	{

       	include_once 'DBConnect.php';
    	$database = new dbConnect();
    	$db = $database->openConnection();


		$categories = array("astrophysics", "cosmology", "particles", "planetology", "hazards", "earthext", "earthint"); // Do not translate this line
		$categories_titles = array("Astrophysique", "Cosmologie", "Physique des particules", "Planetologie", "Dangers naturels", "Enveloppes extérieures de la Terre", "Intérieur de la Terre");

		$keyword = array("k0", "k1", "k2", "k3", "k4", "k5", "k6", "k7","k8","k9","k10", "k11", "k12", "k13", "k14", "k15", "k16", "k17","k18","k19","k20", "k21", "k22", "k23", "k24", "k25", "k26");
		$keyword_name = array("k0" => "Beyond the Standard Model", "k1" => "Black Holes", "k2" => "Climatology", "k3" => "CP violation and flavor physics", "k4" => "Dark energy", "k5" => "Dark matter", "k6" => "Geo and cosmochemistry", "k7" => "Geodynamics", "k8" => "Geomorphology", "k9" => "High energy astrophysics", "k10" => "Instrumentation", "k11" => "Large structures","k12" => "Magnetism", "k13" => "Microbiology", "k14" => "Neutrino", "k15" => "Neutron star", "k16" => "Petrology","k17" => "Planet and star formation", "k18" => "Primordial cosmology", "k19" => "Rock mechanics", "k20" => "Sedimentology", "k21" => "Seismology", "k22" => "Spatial geodesy", "k23" => "Standard Model", "k24" => "Stochastic background", "k25" => "Transport phenomena", "k26" => "Volcanology");
		
		
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
				    $title = $_POST['title'];
					$category = $_POST['category'];
					$keyword1=$_POST['keyword1'];
					$keyword2=$_POST['keyword2'];

				    $sql = "select * from uploaded_abstracts where id = (:id)";
				    $query = $db->prepare($sql);
				    $user = $query->execute(array('id' => $id));

					$result = $query->fetchAll(PDO::FETCH_ASSOC);

				    if (count($result) == 0)
			    	{
				    	$query = $db->prepare("INSERT INTO uploaded_abstracts (id, title, email, first_name, last_name, category, keyword1, keyword2) VALUES (:id, :title, :email, :first_name, :last_name, :category, :keyword1, :keyword2)");
				    	$query->execute(array('id' => $id, 'title' => $title, 'email' => $email, 'first_name' => $first_name, 'last_name' => $last_name, 'category' => $category, "keyword1" => $keyword1, "keyword2" => $keyword2));
				    }
			    }
			}

			rename($target_dir . $_FILES["file"]["name"], "abstracts/abstract" . $_SESSION['id'] . ".pdf");
		}
	
		if($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'program')
		{
			echo '<h2 class="major">Soumettre un résumé</h2>';
			
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

						    		$id = $abst['id'];
						    		$title = $abst['title'];
						    		$first_name = $abst['first_name'];
									$last_name = $abst['last_name'];
									$keyword1 = $abst['keyword1'];
									$keyword2 = $abst['keyword2'];

						    		$link = '<li><a href=download.php?file=abstract' . $id . '.pdf> "' . $title . '"</a>, by ' . $first_name . ' ' . $last_name . ', keywords :'. $keyword1 . ',' . $keyword2 . '</li>';
						    		echo $link;

						}
						echo '</ul>';
				    }
					$index ++;
			    }
			}
			else
			{
				echo 'Aucun résumé n\'a été reçue pour le moment.';
			}
		}
	?>

	<h2 class="major"> Soumettre un résumé</h2>

	<p>Pour soumettre un résumé, veuillez remplir le formulaire ci-dessous en indiquant 
	le titre, la catégorie ainsi que deux mots-clés correspondant à votre travail. 
	Seul le format PDF est accepté.</p>

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
		</div>
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
		
		<div class="select">
			<label>Mot-clé 1:</label>
			<select name="keyword1" required>
				<option></option>

				<!--<?php
					//foreach($keyword_name as $key => $value)
					//{
					//	echo "<option value=" . $keyword[$key] .">" . $keyword_name[$key] . "</option>";
					//}
				?> 
			</select>-->
		<div>
		    Choisir le fichier à envoyer : </br>
		    <input type="file" name="file" id="file" required> </br></br>
		    <input type="submit" value="Soumettre" name="upload-file">
		</div>
	</form>

<?php
	}
	else
	{
		echo '<strong>Accès refusé.</strong>';
	}
?>
