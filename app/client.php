<!-- All PHP code comes from or is inspired by the HTMLexample.php and addperson.php code from the CS 340
    course material for Fall 2016 at:
    https://oregonstate.instructure.com/courses/1602407/pages/live-php-coding-recording?module_item_id=16933267 -->
<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","laquitaa-db","IntzoDYf7GNg5c3u","laquitaa-db");
if($mysqli->connect_errno){
	echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CS 340 Project: Clients</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="css/stylesheet.css" type="text/css">
    </head>
    <body>
        <nav class="navbar navbar-static-top">
            <div class="container-fluid">
                <h1 id="title"><a href="index.html">Homeless Coordinated Entry</a></h1>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
						<li>
                            <a href="client.php" class="navbar-text">Clients</a>
                        </li>
                        <li>
                            <a href="referral_agencies.php" class="navbar-text">Referral Agencies</a>
                        </li>
                        <li>
                            <a href="cities.php" class="navbar-text">Cities</a>
                        </li>
                        <li>
                            <a href="questionnaire.php" class="navbar-text">Questionnaire</a>
                        </li>
                        <li>
                            <a href="proOrg.php" class="navbar-text">Project Organizations</a>
                        </li>
                        <li>
                            <a href="referrals.php" class="navbar-text">Referrals</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
		<div class="container">
	        <table class="table table-hover table-condensed">
	    		<caption>Clients</caption>
	            <thead>
	                <tr>
	                    <th>ID</th>
	                    <th>First Name</th>
	                    <th>Last Name</th>
	                    <th>SSN</th>
	                    <th>Sex</th>
	                    <th>DOB</th>
	                    <th>Referral Agency</th>
	                </tr>
	            </thead>
	            <tbody>
                    <?php
                    if(!($stmt = $mysqli->prepare("SELECT clients.id, clients.fname, clients.lname, clients.SSN,
                        clients.Sex, clients.DOB, referral_agencies.name FROM clients INNER JOIN referral_agencies
                        ON clients.AgencyID = referral_agencies.id ORDER BY clients.id ASC"))){
                    	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    if(!$stmt->execute()){
                    	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if(!$stmt->bind_result($id, $fname, $lname, $SSN, $sex, $dob, $refName)){
                    	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while($stmt->fetch()){
                     echo "<tr>\n<td>\n" . $id . "\n</td>\n<td>\n" . $fname . "\n</td>\n<td>\n" . $lname .
                     "\n</td>\n<td>\n" . $SSN . "\n</td>\n<td>\n" . $sex . "\n</td>\n<td>\n" . $dob .
                     "\n</td>\n<td>\n" . $refName . "\n</td>\n</tr>";
                    }
                    $stmt->close();
                    ?>
	            </tbody>
	        </table>
			<form method="post" action="addclient.php">
				<fieldset>
					<legend>Add Client</legend>
					<div class="row">
						<div class="form-group col-md-4">
							<label for="fname">First Name</label>
							<input type="text" class="form-control" id="fname" name="fname" required>
						</div>
						<div class="form-group col-md-4">
							<label for="lname">Last Name</label>
							<input type="text" class="form-control" id="lname" name="lname" required>
						</div>
						<div class="form-group col-md-4">
							<label for="ssn">SSN</label>
							<!-- Pattern enforces SSN is entered into standard format using regex -->
							<input type="text" class="form-control" id="ssn" name="ssn" placeholder="XXX-XX-XXXX" maxlength="12" pattern="\d{3}-\d{2}-\d{4}">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-4">
                            <div class="sex">
                                <label for="sex" class="radio">Male </label>
    					        <input type="radio" name="sex" class ="radio" value="M" required>
                            </div>
					        <div class="sex">
                                <label for="sex" class="radio">Female </label>
    					        <input type="radio" name="sex" class="radio" value="F" required>
                            </div>
					 	</div>
						<div class="form-group col-md-4">
							<label for="dob">DOB</label>
							<!-- Pattern enforces DOB is entered into standard format using regex as entering incorrectly would enter an empty string -->
							<input type="date" class="form-control" id="dob" name="DOB" placeholder="YYYY-MM-DD" pattern="\d{4}-\d{1,2}-\d{1,2}">
						</div>
						<div class="form-group col-md-4">
							<label for="r-agency">Referral Agency</label>
                            <select id="r-agency" class="form-control" name="refAgency" required>
								<?php
	  							  if(!($stmt = $mysqli->prepare("SELECT id, name FROM referral_agencies"))){
	  							  	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	  							  }

	  							  if(!$stmt->execute()){
	  							  	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	  							  }
	  							  if(!$stmt->bind_result($id, $name)){
	  							  	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	  							  }
	  							  while($stmt->fetch()){
	  							  	echo '<option value=" '. $id . ' "> ' . $name . '</option>\n';
	  							  }
	  							  $stmt->close();
  							  	?>
                            </select>
						</div>
					</div>
                    <button type="submit" class="btn">Add</button>
				</fieldset>
			</form>
            <form method="post" action="update_client.php">
				<fieldset>
					<legend>Update Client</legend>
                    <div class="row">
						<div class="form-group col-md-4">
                            <label for="update-id">Select Client ID</label>
                            <select id="update-id" class="form-control" name="update">
								<?php
    							  if(!($stmt = $mysqli->prepare("SELECT id, fname, lname FROM clients"))){
    							  	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    							  }

    							  if(!$stmt->execute()){
    							  	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    							  }
    							  if(!$stmt->bind_result($id, $fname, $lname)){
    							  	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
    							  }
    							  while($stmt->fetch()){
    							  	echo '<option value=" '. $id . ' "> ' . $id . '. ' . $fname . ' ' . $lname . '</option>\n';
    							  }
    							  $stmt->close();
    							  ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn">Update</button>
                </fieldset>
            </form>
            <form method="post" action="delete_client.php">
				<fieldset>
					<legend>Delete Client</legend>
                    <div class="row">
						<div class="form-group col-md-4">
                            <label for="delete-id">Select Client ID</label>
                            <select id="delete-id" class="form-control" name="delete">
								<?php
  								if(!($stmt = $mysqli->prepare("SELECT id, fname, lname FROM clients"))){
  								  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  								}

  								if(!$stmt->execute()){
  								  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
  								}
  								if(!$stmt->bind_result($id, $fname, $lname)){
  								  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
  								}
  								while($stmt->fetch()){
  								  echo '<option value=" '. $id . ' "> ' . $id . '. ' . $fname . ' ' . $lname . '</option>\n';
  								}
  								$stmt->close();
  								?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn">Delete</button>
                </fieldset>
            </form>
		</div>
    </body>
</html>
