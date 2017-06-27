<!-- All PHP code comes from or is inspired by the HTMLexample.php and addperson.php code from the CS 340
    course material for Fall 2016 at:
    https://oregonstate.instructure.com/courses/1602407/pages/live-php-coding-recording?module_item_id=16933267 -->
<?php
	//Turn on error reporting
	ini_set('display_errors', 'On');
	//Connects to the database
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu","laquitaa-db","XXXXXXXXX","laquitaa-db");
	if($mysqli->connect_errno){
		echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
		}

	if(!($stmt = $mysqli->prepare("SELECT id, fname, lname, SSN, Sex, DOB, AgencyID FROM clients WHERE id=?"))){
    	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!($stmt->bind_param("i",$_POST['update']))){
    	echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->execute()){
    	echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
    }
	if(!$stmt->bind_result($id, $fname, $lname, $SSN, $Sex, $DOB, $AgencyID)){
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
        <title>CS 340 Project: Update Client</title>
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
            <form method="post" action="update_client2.php">
                <fieldset>
                    <legend>Update Client</legend>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" required value=
                                <?php
                                    echo '"' . $fname . '">';
                                ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname" required value=
                            <?php
                                echo '"' . $lname . '">';
                            ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ssn">SSN</label>
                            <input type="text" class="form-control" id="ssn" name="ssn" placeholder="XXX-XX-XXXX" maxlength="12" pattern="\d{3}-\d{2}-\d{4}" value=
                            <?php
                                echo '"' . $SSN . '">';
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
							<!-- PHP checks to see which value previously existed in database and checks the appropriate radio -->
							<div class="sex">
                                <label for="sex" class="radio">Male </label>
                                <input type="radio" name="sex" class ="radio" required value="M"
                                    <?php
                                        if($Sex == 'M'){
                                            echo ' checked>';
                                        }
                                        else{
                                            echo '>';
                                        }
                                     ?>
                            </div>
                            <div class="sex">
                                <label for="sex" class="radio">Female </label>
                                <input type="radio" name="sex" class="radio" required value="F"
                                    <?php
                                        if($Sex == 'F'){
                                            echo ' checked>';
                                        }
                                        else{
                                            echo '>';
                                        }
                                     ?>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dob">DOB</label>
                            <input type="date" class="form-control" id="dob" name="DOB" placeholder="YYYY-MM-DD" pattern="\d{4}-\d{1,2}-\d{1,2}" value=
                                <?php
                                    echo '"' . $DOB . '">';
                                ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="r-agency">Referral Agency</label>
							<!-- PHP defaults to have the option that currently exists in the DB selected -->
                            <select id="r-agency" class="form-control" name="refAgency" required>
                                <?php
	  							  if(!($stmt = $mysqli->prepare("SELECT id, name FROM referral_agencies"))){
	  							  	echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
	  							  }

	  							  if(!$stmt->execute()){
	  							  	echo "Execute failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	  							  }
	  							  if(!$stmt->bind_result($refID, $name)){
	  							  	echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
	  							  }
	  							  while($stmt->fetch()){
                                      if($AgencyID == $refID){
                                          echo '<option value=" '. $refID . ' " selected> ' . $name . '</option>\n';
                                      }
                                      else{
                                          echo '<option value=" '. $refID . ' "> ' . $name . '</option>\n';
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
