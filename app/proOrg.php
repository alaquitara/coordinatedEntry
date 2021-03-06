<!-- All PHP code comes from or is inspired by the HTMLexample.php and addperson.php code from the CS 340
    course material for Fall 2016 at:
    https://oregonstate.instructure.com/courses/1602407/pages/live-php-coding-recording?module_item_id=16933267 -->
<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","laquitaa-db","XXXXXX","laquitaa-db");
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
        <title>CS 340 Project: Project Organizations</title>
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
	    		<caption>Project Organization</caption>
	            <thead>
	                <tr>
	                    <th>ID</th>
	                    <th>Name</th>
	                    <th>Specialty Area</th>
	                    <th>Funding Amount</th>
	                </tr>
	            </thead>
	            <tbody>
	        		<?php
                    if(!($stmt = $mysqli->prepare("SELECT project_organizations.id, project_organizations.name, project_organizations.specialtyArea, project_organizations.fundingAmount
                        FROM project_organizations ORDER BY project_organizations.id ASC"))){
                    	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                    }

                    if(!$stmt->execute()){
                    	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    if(!$stmt->bind_result($id, $name, $specialtyArea, $fundingAmount)){
                    	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
                    }
                    while($stmt->fetch()){
                     echo "<tr>\n<td>\n" . $id . "\n</td>\n<td>\n" . $name . "\n</td>\n<td>\n" . $specialtyArea .
                     "\n</td>\n<td>\n" . $fundingAmount . "\n</td>\n</tr>";
                    }
                    $stmt->close();
                    ?>
	            </tbody>
	        </table>
			<form method="post" action="addPo.php">
				<fieldset>
					<legend>Add Project Organization</legend>
					<div class="row">
						<div class="form-group col-md-4">
							<label for="name">Name</label>
							<input type="text" class="form-control" id="name" name="name" required>
						</div>
						<div class="form-group col-md-4">
							<label for="specialtyArea">Specialty Area</label>
							<input type="text" class="form-control" id="specialtyArea" name="specialtyArea" required>
						</div>
						<div class="form-group col-md-4">
							<label for="fundingAmount">Funding Amount</label>
							<input type="text" class="form-control" id="fundingAmount" name="fundingAmount" placeholder="$$$$$$$" maxlength="20">
						</div>
					</div>
                    <button type="submit" class="btn">Add</button>
				</fieldset>
			</form>
            <form method="post" action="update_po.php">
				<fieldset>
					<legend>Update Project Organization</legend>
                    <div class="row">
						<div class="form-group col-md-4">
                            <label for="update-id">Select Organization Name</label>
                            <select id="update-id" class="form-control" name="update">
                             <?php
    							  if(!($stmt = $mysqli->prepare("SELECT id, name FROM project_organizations"))){
  								  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  								}

  								if(!$stmt->execute()){
  								  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
  								}
  								if(!$stmt->bind_result($id, $name)){
  								  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
  								}
  								while($stmt->fetch()){
  								  echo '<option value=" '. $id . ' ">' . $id . '. ' . $name . '</option>\n';
  								}
  								$stmt->close();
  								?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn">Update</button>
                </fieldset>
            </form>
            <form method="post" action="delete_po.php">
				<fieldset>
					<legend>Delete Project Organization</legend>
                    <div class="row">
						<div class="form-group col-md-4">
                            <label for="delete-id">Select Organization ID</label>
                            <select id="delete-id" class="form-control" name="delete">
                              <?php
  								if(!($stmt = $mysqli->prepare("SELECT id, name FROM project_organizations"))){
  								  echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
  								}

  								if(!$stmt->execute()){
  								  echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
  								}
  								if(!$stmt->bind_result($id, $name)){
  								  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
  								}
  								while($stmt->fetch()){
  								  echo '<option value=" '. $id . ' ">' . $id . '. ' . $name . '</option>\n';
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
