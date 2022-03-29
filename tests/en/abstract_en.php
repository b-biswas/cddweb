<?php
	if(array_key_exists('status', $_SESSION))
	{

       	include_once 'DBConnect.php';
    	$database = new dbConnect();
    	$db = $database->openConnection();

		$categories = array("astrophysics", "cosmology", "particles", "planetology", "hazards", "earthext", "earthint"); // Do not translate this line
		$categories_titles = array("Astrophysics", "Cosmology", "Particle physics", "Planetology", "Natural hazards", "Earth exterior evelops", "Earth interior");

		//$keyword=array("k0", "k1", "k2", "k3", "k4", "k5", "k6", "k7","k8","k9","k10", "k11", "k12", "k13", "k14", "k15", "k16", "k17","k18","k19","k20", "k21", "k22", "k23", "k24", "k25", "k26");
		//$keyword_name=array("beyon standard model", "black holes","climatology","cp violation and flavor physics","dark energy","dark matter","geo and cosmochemistry","geodynamics","geomorphology","high energy astrophysics","instrumentation","large structures","magnetism","microbiology","neutrino","neutron star","petrology","planet and star formation","primordial cosmology","rock mechanics","sedimentology","seismology","spatial geodesy","standard model","stochastic background", "transport phenomena", "volcanology");
		
		
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
				echo 'No abstract has been submitted yet.';
			}
		}
	?>

	<h2 class="major">Submit an abstract</h2>

	<p>To submit an abstract, please fill in this form, specifying the title,
	the category and two keywords for your work. It will be received by the team 
	in charge of the program of the conference. Only PDF format is supported.</p>

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
		</div>
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

<?php
	}
	else
	{
		echo '<strong>Access denied.</strong>';
	}
?>
