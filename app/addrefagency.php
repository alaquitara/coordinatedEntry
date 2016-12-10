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
        <title>CS 340 Project: Add Referral Agency</title>
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
			<?php
			if(!($stmt = $mysqli->prepare("INSERT INTO referral_agencies(name, streetNumber, streetName, cid) VALUES (?,?,?,?)"))){
				echo "<p id='message'>Prepare failed: "  . $stmt->errno . " " . $stmt->error . "</p>";
			}
			if(!($stmt->bind_param("sisi",$_POST['name'],$_POST['streetNumber'],$_POST['streetName'],$_POST['city']))){
				echo "<p id='message'>Bind failed: "  . $stmt->errno . " " . $stmt->error . "</p>";
			}
			if(!$stmt->execute()){
				echo "<p id='message'>Execute failed: "  . $stmt->errno . " " . $stmt->error . "</p>";
			} else {
				echo "<p id='message'>Added " . $stmt->affected_rows . " row to referral_agencies.</p>";
			}
			?>
		</div>
	</body>
</html>
