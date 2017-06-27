<!-- All PHP code comes from or is inspired by the HTMLexample.php and addperson.php code from the CS 340
    course material for Fall 2016 at:
    https://oregonstate.instructure.com/courses/1602407/pages/live-php-coding-recording?module_item_id=16933267 -->
<?php
	//Turn on error reporting
	ini_set('display_errors', 'On');
	//Connects to the database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","laquitaa-db","XXXXXXX","laquitaa-db");
	if($mysqli->connect_errno){
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}

	if(!($stmt = $mysqli->prepare("SELECT id, name, streetNumber, streetName, cid FROM referral_agencies WHERE id=?"))){
    	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!($stmt->bind_param("i",$_POST['update']))){
    	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->execute()){
    	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
    }
	if(!$stmt->bind_result($id, $name, $streetNumber, $streetName, $city)){
	  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	}
	$stmt->fetch();
	$stmt->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CS 340 Project: Update Referral Agency</title>
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
            <form method="post" action="update_refagency2.php">
				<fieldset>
					<legend>Update Referral Agency</legend>
					<div class="row">
						<div class="form-group col-md-6">
							<label for="name">Name</label>
							<input type="text" class="form-control" id="name" name="name" value=
                                <?php
                                    echo '"' . $name . '">';
                                ?>
						</div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
							<label for="streetNum">Street Number</label>
							<input type="number" class="form-control" id="streetNum" name="streetNumber" value=
                                <?php
                                    echo '"' . $streetNumber . '">';
                                ?>
						</div>
						<div class="form-group col-md-4">
							<label for="streetName">Street Name</label>
							<input type="text" class="form-control" id="streetName" name="streetName" value=
                                <?php
                                    echo '"' . $streetName . '">';
                                ?>
						</div>
                        <div class="form-group col-md-4">
							<label for="city">City</label>
							<!-- PHP defaults to have the option that currently exists in the DB selected -->
                            <select id="city" class="form-control" name="city">
								<?php
	  							  if(!($stmt = $mysqli->prepare("SELECT id, name, zipcode FROM cities"))){
	  							  	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	  							  }

	  							  if(!$stmt->execute()){
	  							  	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	  							  }
	  							  if(!$stmt->bind_result($cid, $cName, $zipcode)){
	  							  	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	  							  }
	  							  while($stmt->fetch()){
                                      if($city == $cid){
                                          echo '<option value=" '. $cid . ' " selected> ' . $cName . ' ' . $zipcode . '</option>\n';
                                      }
                                      else{
                                          echo '<option value=" '. $cid . ' "> ' . $cName . ' ' . $zipcode . '</option>\n';
                                      }
	  							  }
	  							  $stmt->close();
  							  	?>
                            </select>
						</div>
                    </div>
					<input type="hidden" name="id" value=
                    <?php
                        echo '"' . $id . '">';
                    ?>
                    <button type="submit" class="btn">Submit Update</button>
                </fieldset>
            </form>
        </div>
    </body>
</html>
