<?php
	if(array_key_exists('status', $_SESSION))
	{

       	include_once 'DBConnect.php';
    	$database = new dbConnect();
    	$db = $database->openConnection();

		$categories = array("astrophysics", "cosmology", "particles", "planetology", "hazards", "earthext", "earthint"); // Do not translate this line
		$categories_titles = array("Astrophysics", "Cosmology", "Particle physics", "Planetology", "Natural hazards", "Earth exterior envelops", "Earth interior");

		$types = array ("talk" => "Talk", "poptalk" => "Popularized talk", "poster" => "Poster");
		
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
				    echo "<strong>Only PDF format is allowed.</strong></br>";
				    $upload_check = 0;
				}
			}
			else
			{
				$upload_check = 0;
			}

			if ($upload_check == 0)
			{
			    echo "<strong>Sorry, your file was not uploaded.</strong>";
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
			echo '<h2 class="major"> Submitted abstracts</h2>';
			
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

						    		$link = '<li><strong><a href=download.php?file=abstract' . $abst_id . '.pdf> "' . $abst_title . '"</a></strong>, ' . lcfirst($types[$abst_type]) .' by ' . $abst_first_name . ' ' . $abst_last_name . ' ('.$abst_affiliation.', ' . $abst_email . ')</li>';
						    		echo $link;
						}
						echo '</ul>';
				    }
					$index ++;
			    }
			}
			else
			{
				echo 'No abstract has been submitted yet.';
			}
		}
	?>

	<h2 class="major">Submit an abstract</h2>

	<p>To submit an abstract, please fill in this form, specifying the title and
	the category for your work. Please, select also <strong>two keywords in the list below</strong>
	and include them in your file. It will be received by the team 
	in charge of the program of the conference. <strong>Only PDF format</strong> is supported.</p>

	<p>Only one abstract can be added per person. If you want to modify 
	your abstract, just submit the new version. Please, contact us if you 
	want to modify the title.</p>

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
			<label for="title">Abstract title:</label>
			<input type="text" name="title" id="title" required/>
		</div> </br>

		<div class="field">
			<label for="affiliation">Laboratory/Institute/Collaboration:</label>
			<input type="text" name="affiliation" id="affiliation" required/>
		</div> </br>

		<div class="select">
			<label>Presentation type:</label>
			<select name="type" required>
				<option></option>
						<option value="talk">Talk</option>
						<option value="poptalk">Popularized talk</option>
						<option value="poster">Poster</option>
 			</select>
		</div> </br>

		<div class="select">
			<label>Category:</label>
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
		    Select file to upload: </br>
		    <input type="file" name="file" id="file" required> </br></br>
		    <input type="submit" value="Submit" name="upload-file">
		</div>
	</form>

	<div>
		Indicative keywords:
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
		echo '<strong>Access denied.</strong>';
	}
?>
