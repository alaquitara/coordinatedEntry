<!-- All PHP code comes from or is inspired by the HTMLexample.php and addperson.php code from the CS 340
    course material for Fall 2016 at:
    https://oregonstate.instructure.com/courses/1602407/pages/live-php-coding-recording?module_item_id=16933267 -->
<?php
//Turn on error reporting
ini_set('display_errors', 'On');
//Connects to the database
$mysqli = new mysqli("oniddb.cws.oregonstate.edu","laquitaa-db","XXXXXXXXX,"laquitaa-db");
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
        <title>CS 340 Project: Referrals</title>
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
			<div>
				<table class="table table-hover table-condensed">
		    		<caption>Referrals</caption>
		            <thead>
		                <tr>
		                    <th>Client ID</th>
							<th>Client Last Name</th>
		                    <th>Organization ID</th>
							<th>Organization Name</th>
							<th class="del-td"></th>
		                </tr>
		            </thead>
		            <tbody>
		        		<?php
						if(!($stmt = $mysqli->prepare("SELECT referrals.cid, clients.lname, referrals.oid, project_organizations.name
	                        FROM referrals INNER JOIN clients on referrals.cid = clients.id
							INNER JOIN project_organizations on referrals.oid = project_organizations.id ORDER BY referrals.cid ASC"))){
	                    	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	                    }

	                    if(!$stmt->execute()){
	                    	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	                    }
	                    if(!$stmt->bind_result($cid, $lname, $oid, $name)){
	                    	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	                    }
						// In order to send both cid and oid over to delete page the delete button is added in the table as an part of
						// a unique form which references the row it is in
	                    while($stmt->fetch()){
	                     echo "<tr>\n<td>\n" . $cid . "\n</td>\n<td>\n" . $lname. "\n</td>\n<td>\n" . $oid . "\n</td>\n<td>\n" . $name . "\n</td>\n
						 <td class='del-td'><form method='post' action='delete_ref.php'><input type='hidden' name='cid' value=" . $cid . ">
						 <input type='hidden' name='oid' value=" . $oid . "><button type='submit' class='btn'>" . 'Delete' . "</button></form></td></tr>\n";
	                    }
	                    $stmt->close();
	                    ?>
		        	</tbody>
		        </table>
			</div>
			<form method="post" action="addReferrals.php">
				<fieldset>
					<legend>Add Referral Relationship</legend>
					<div class="row">
						<div class="form-group col-md-4">
							<label for="client">Client ID (CID)</label>
							<select id="client" class="form-control" name="cid">
								<?php
	  							  if(!($stmt = $mysqli->prepare("SELECT id, fname, lname FROM clients ORDER BY clients.lname ASC"))){
	  							  	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	  							  }

	  							  if(!$stmt->execute()){
	  							  	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	  							  }
	  							  if(!$stmt->bind_result($id, $fname, $lname)){
	  							  	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	  							  }
	  							  while($stmt->fetch()){
	  							  	echo '<option value=" '. $id . ' "> ' . $fname . ' ' . $lname . '</option>\n';
	  							  }
	  							  $stmt->close();
  							  	?>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="organization">Organization ID (OID)</label>
							<select id="organization" class="form-control" name="oid">
								<?php
	  							  if(!($stmt = $mysqli->prepare("SELECT id, name FROM project_organizations ORDER BY project_organizations.name ASC"))){
	  							  	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	  							  }

	  							  if(!$stmt->execute()){
	  							  	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	  							  }
	  							  if(!$stmt->bind_result($id, $name)){
	  							  	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	  							  }
	  							  while($stmt->fetch()){
	  							  	echo '<option value=" '. $id . ' "> ' . $name . ' </option>\n';
	  							  }
	  							  $stmt->close();
  							  	?>
							</select>
						</div>
					</div>
                    <button type="submit" class="btn">Add</button>
				</fieldset>
			</form>
		</div>
    </body>
</html>
