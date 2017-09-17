<?php

	/**
	 * Deze functie laat alle banen in het systeem zien	 *
	 */
	function displayAllDepartments($mysqli) {
		$sql = "SELECT * FROM `Departments`";	

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		echo'
<h1>Afdelingen</h1>
<br>
<input type="button" onclick="document.location.href=\'/?action=adddepartment\';" value="Afdeeling toevoegen">
<br>
<br>
<table>
<tr>
<th>Naam</th>
<th>Manager</th>
<th>Locatie</th>
<th>Actie</th>
</tr>';

		while ($row = $result->fetch_assoc()) {

			$row = escapeArray($row); // alle slashes weghalen

			echo'
<tr>
<td>',$row['DepartmentName'],'</td>
<td>',$row['ManagerID'],'</td>
<td>',$row['LocationID'],'</td>
<td><a href="/?action=editdepartment&id=',$row['DepartmentID'],'">Bewerken</a> | <a href="javascript:confirmAction(\'Zeker weten?\', \'/?action=deletedepartment&id=',$row['DepartmentID'],'\');">Verwijderen</a></td>
</tr>';
}
		echo '
</table>';
	}
	
	
	/**
	 * Deze functie laat het banen toevoeg formulier zien	 *
	 */
	function displayAddDepartment() {
		echo'
<h1>Afdeeling toevoegen</h1>
<form method="post" action="index.php?action=insertdepartment">
<table>
<tr>
<td>Naam:</td>
<td><input type="text" name="DepartmentName"></td>
</tr>
<tr>
<td>Manager:</td>
<td><input type="text" name="ManagerID"></td>
</tr>
<tr>
<td>Locatie:</td>
<td><input type="text" name="LocationID"></td>
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
	
	function displayEditDepartment($mysqli) {

		$sql = sprintf( "SELECT * FROM `Departments` WHERE `DepartmentID` = %d", 
						$mysqli->real_escape_string($_GET['id']) );

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		if($row = $result->fetch_assoc()) {
			$row = escapeArray($row); // alle slashes weghalen

			echo'
<h1>Afdeeling bewerken</h1>
<form method="post" action="index.php?action=updatedepartment">
<table>
<tr>
<td>Naam:</td>
<td><input type="text" name="DepartmentName" value="',$row['DepartmentName'],'"></td>
</tr>
<tr>
<td>Manager:</td>
<td><input type="text" name="ManagerID" value="',$row['ManagerID'],'"></td>
</tr>
<tr>
<td>Locatie:</td>
<td><input type="text" name="LocationID" value="',$row['LocationID'],'"></td>
</tr>
<tr>
<td></td>
<td><button type="submit">Opslaan</button></td>
</tr>
</table>
<input type="hidden" name="DepartmentID" value="',$row['DepartmentID'],'" />
</form>';
		}
		else {
			die('Geen gegevens gevonden');
		}
	}
	
	/**
	 * Deze functie voegt een nieuwe record toe aan de tabel Departments	 *
	 */
	function addDepartment($mysqli) {
		// Letop we maken gebruik van sprintf. Kijk op php.net voor meer info.
		// Binnen sprintf staat %s voor een string, %d voor een decimaal (integer) en %f voor een float

		$sql = sprintf("INSERT INTO `Departments` (`DepartmentName`, `ManagerID`, `LocationID`) VALUES  ('%s', '%d', '%d')",
						$mysqli->real_escape_string($_POST['DepartmentName']),
						$mysqli->real_escape_string($_POST['ManagerID']),
						$mysqli->real_escape_string($_POST['LocationID']));

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		header('location: /?action=departments'); // terugkeren naar departments
		exit();
	}
	
	/**
	 * Deze functie werkt de record met ID $_POST['DepartmentID'] bij	 *
	 */
	
	function updateDepartment($mysqli) {
		$sql = sprintf("UPDATE `Departments` SET 
						`DepartmentName` = '%s',
						`ManagerID` = '%d',
						`LocationID` = '%d'
						WHERE `DepartmentID` = %d",
						$mysqli->real_escape_string($_POST['DepartmentName']),
						$mysqli->real_escape_string($_POST['ManagerID']),
						$mysqli->real_escape_string($_POST['LocationID']),
						$mysqli->real_escape_string($_POST['DepartmentID']) );

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		header('location: /?action=departments'); // terugkeren naar departments
		exit();
	}
	
	/**
	 * Deze functie verwijderd record met id $_GET['ID']  uit de tabel Departments
	 */	
	function deleteDepartment($mysqli) {
		$sql = sprintf("DELETE FROM `Departments` WHERE `DepartmentID` = %d", $mysqli->real_escape_string($_GET['id']));

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		header('location: /?action=departments'); // terugkeren naar departments
		exit();
	}
