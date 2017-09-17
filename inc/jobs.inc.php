<?php

	/**
	 * Deze functie laat alle banen in het systeem zien	 *
	 */
	function displayAllJobs($mysqli) {
		$sql = "SELECT * FROM `Jobs` ORDER BY `JobTitle`";	

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		echo'
<h1>Banen</h1>
<br>
<input type="button" onclick="document.location.href=\'/?action=addjob\';" value="Baan toevoegen">
<br>
<br>
<table>
<tr>
<th>Titel</td>
<th>Minimum salaris</td>
<th>Maximum salaris</td>
<th>Actie</td>
</tr>';

		while ($row = $result->fetch_assoc()) {

			$row = escapeArray($row); // alle slashes weghalen

			echo'
<tr>
<td>',$row['JobTitle'],'</td>
<td>',$row['MinSalary'],'</td>
<td>',$row['MaxSalary'],'</td>
<td><a href="/?action=editjob&id=',$row['JobID'],'">Bewerken</a> | <a href="javascript:confirmAction(\'Zeker weten?\', \'/?action=deletejob&id=',$row['JobID'],'\');">Verwijderen</a></td>
</tr>';
}
		echo '
</table>';
	}
	
	
	/**
	 * Deze functie laat het banen toevoeg formulier zien	 *
	 */
	function displayAddJob() {
		echo'
<h1>Baan toevoegen</h1>
<form method="post" action="index.php?action=insertjob">
<table>
<tr>
<td>Titel:</td>
<td><input type="text" name="JobTitle"></td>
</tr>
<tr>
<td>Minimuloon:</td>
<td><input type="text" name="MinSalary"></td>
</tr>
<tr>
<td>Maximumloon:</td>
<td><input type="text" name="Maxsalary"></td>
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
	
	function displayEditJob($mysqli) {

		$sql = sprintf( "SELECT * FROM `Jobs` WHERE `JobID` = %d", 
						$mysqli->real_escape_string($_GET['id']) );

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		if($row = $result->fetch_assoc()) {
			$row = escapeArray($row); // alle slashes weghalen

			echo'
<h1>Baan bewerken</h1>
<form method="post" action="index.php?action=updatejob">
<table>
<tr>
<td>Titel:</td>
<td><input type="text" name="JobTitle" value="',$row['JobTitle'],'" /></td>
</tr>
<tr>
<td>Minimuloon:</td>
<td><input type="text" name="MinSalary" value="',$row['MinSalary'],'" /></td>
</tr>
<tr>
<td>Maximumloon:</td>
<td><input type="text" name="Maxsalary" value="',$row['MaxSalary'],'" /></td>
</tr>
<tr>
<td></td>
<td><input type="submit" value="Opslaan" /></td>
</tr>
</table>
<input type="hidden" name="JobID" value="',$row['JobID'],'" />
</form>';
		}
		else {
			die('Geen gegevens gevonden');
		}
	}
	
	/**
	 * Deze functie voegt een nieuwe record toe aan de tabel Jobs	 *
	 */
	function addJob($mysqli) {
		// Letop we maken gebruik van sprintf. Kijk op php.net voor meer info.
		// Binnen sprintf staat %s voor een string, %d voor een decimaal (integer) en %f voor een float

		$sql = sprintf("INSERT INTO `Jobs` (`JobTitle`, `MinSalary`, `MaxSalary`) VALUES  ('%s', '%f', '%f')", 
						$mysqli->real_escape_string($_POST['JobTitle']),
						$mysqli->real_escape_string($_POST['MinSalary']),
						$mysqli->real_escape_string($_POST['Maxsalary']));

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		header('location: /?action=jobs'); // terugkeren naar jobs
		exit();
	}
	
	/**
	 * Deze functie werkt de record met ID $_POST['JobID'] bij	 *
	 */
	
	function updateJob($mysqli) {
		$sql = sprintf("UPDATE `Jobs` SET 
						`JobTitle` = '%s',
						`MinSalary` = '%s',
						`MaxSalary` = '%s'
						WHERE `JobID` = %d",
						$mysqli->real_escape_string($_POST['JobTitle']),
						$mysqli->real_escape_string($_POST['MinSalary']),
						$mysqli->real_escape_string($_POST['Maxsalary']),
						$mysqli->real_escape_string($_POST['JobID']) );

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		header('location: /?action=jobs'); // terugkeren naar jobs
		exit();
	}
	
	/**
	 * Deze functie verwijderd record met id $_GET['ID']  uit de tabel Jobs
	 */	
	function deleteJob($mysqli) {
		$sql = sprintf("DELETE FROM `Jobs` WHERE `JobID` = %d", $mysqli->real_escape_string($_GET['id']));

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		header('location: /?action=jobs'); // terugkeren naar jobs
		exit();
	}
