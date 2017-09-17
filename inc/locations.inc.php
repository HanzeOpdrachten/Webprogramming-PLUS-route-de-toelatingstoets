<?php

	/**
	 * Deze functie laat alle banen in het systeem zien	 *
	 */
	function displayAllLocations($mysqli) {
		$sql = "SELECT * FROM `Locations`";	

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		echo'
<h1>Locaties</h1>
<br>
<input type="button" onclick="document.location.href=\'/?action=addlocation\';" value="Locatie toevoegen">
<br>
<br>
<table>
<tr>
<th>Adres</th>
<th>Postcode</th>
<th>Stad</th>
<th>Provincie</th>
<th>Actie</th>
</tr>';

		while ($row = $result->fetch_assoc()) {

			$row = escapeArray($row); // alle slashes weghalen

			echo'
<tr>
<td>',$row['StreetAddress'],'</td>
<td>',$row['PostalCode'],'</td>
<td>',$row['City'],'</td>
<td>',$row['StateProvince'],'</td>
<td><a href="/?action=editlocation&id=',$row['LocationID'],'">Bewerken</a> | <a href="javascript:confirmAction(\'Zeker weten?\', \'/?action=deletelocation&id=',$row['LocationID'],'\');">Verwijderen</a></td>
</tr>';
}
		echo '
</table>';
	}
	
	
	/**
	 * Deze functie laat het banen toevoeg formulier zien	 *
	 */
	function displayAddLocation() {
		echo'
<h1>Locatie toevoegen</h1>
<form method="post" action="index.php?action=insertlocation">
<table>
<tr>
<td>Adres:</td>
<td><input type="text" name="StreetAddress"></td>
</tr>
<tr>
<td>Postcode:</td>
<td><input type="text" name="PostalCode"></td>
</tr>
<tr>
<td>Stad:</td>
<td><input type="text" name="City"></td>
</tr>
<tr>
<td>Provincie:</td>
<td><input type="text" name="StateProvince"></td>
</tr>
<tr>
<td></td>
<td><button type="submit">Opslaan</button></td>
</tr>
</table>
</form>';
	}
	
	/**
	 * Deze functie laat het banen bewerkformulier zien.
	 * Dit formulier is automatisch gevuld met de gegevens die bij het meegegeven ID horen	 *
	 */
	
	function displayEditLocation($mysqli) {

		$sql = sprintf( "SELECT * FROM `Locations` WHERE `LocationID` = %d", 
						$mysqli->real_escape_string($_GET['id']) );

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		if($row = $result->fetch_assoc()) {
			$row = escapeArray($row); // alle slashes weghalen

			echo'
<h1>Locatie bewerken</h1>
<form method="post" action="index.php?action=updatelocation">
<table>
<tr>
<td>Adres:</td>
<td><input type="text" name="StreetAddress" value="',$row['StreetAddress'],'"></td>
</tr>
<tr>
<td>Postcode:</td>
<td><input type="text" name="PostalCode" value="',$row['PostalCode'],'"></td>
</tr>
<tr>
<td>Stad:</td>
<td><input type="text" name="City" value="',$row['City'],'"></td>
</tr>
<tr>
<td>Provincie:</td>
<td><input type="text" name="StateProvince" value="',$row['StateProvince'],'"></td>
</tr>
<tr>
<td></td>
<td><button type="submit" value="',$row['LocationID'],'">Opslaan</button></td>
</tr>
</table>
<input type="hidden" name="LocationID" value="',$row['LocationID'],'" />
</form>';
		}
		else {
			die('Geen gegevens gevonden');
		}
	}
	
	/**
	 * Deze functie voegt een nieuwe record toe aan de tabel Locations	 *
	 */
	function addLocation($mysqli) {
		// Letop we maken gebruik van sprintf. Kijk op php.net voor meer info.
		// Binnen sprintf staat %s voor een string, %d voor een decimaal (integer) en %f voor een float

		$sql = sprintf("INSERT INTO `Locations` (`StreetAddress`, `PostalCode`, `City`, `StateProvince`) VALUES  ('%s', '%s', '%s', '%s')", 
						$mysqli->real_escape_string($_POST['StreetAddress']),
						$mysqli->real_escape_string($_POST['PostalCode']),
						$mysqli->real_escape_string($_POST['City']),
						$mysqli->real_escape_string($_POST['StateProvince']));

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		header('location: /?action=locations'); // terugkeren naar locations
		exit();
	}
	
	/**
	 * Deze functie werkt de record met ID $_POST['LocationID'] bij	 *
	 */
	
	function updateLocation($mysqli) {
		$sql = sprintf("UPDATE `Locations` SET 
						`StreetAddress` = '%s',
						`PostalCode` = '%s',
						`City` = '%s',
						`StateProvince` = '%s'
						WHERE `LocationID` = %d",
						$mysqli->real_escape_string($_POST['StreetAddress']),
						$mysqli->real_escape_string($_POST['PostalCode']),
						$mysqli->real_escape_string($_POST['City']),
						$mysqli->real_escape_string($_POST['StateProvince']),
						$mysqli->real_escape_string($_POST['LocationID']) );

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		header('location: /?action=locations'); // terugkeren naar locations
		exit();
	}
	
	/**
	 * Deze functie verwijderd record met id $_GET['ID']  uit de tabel Locations
	 */	
	function deleteLocation($mysqli) {
		$sql = sprintf("DELETE FROM `Locations` WHERE `LocationID` = %d", $mysqli->real_escape_string($_GET['id']));

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		header('location: /?action=locations'); // terugkeren naar locations
		exit();
	}
