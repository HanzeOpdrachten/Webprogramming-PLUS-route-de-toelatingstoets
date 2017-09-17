<?php

	/**
	 * Deze functie laat alle banen in het systeem zien	 *
	 */
	function displayAllEmployees($mysqli) {
		$sql = "SELECT * FROM `Employees`";	

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		echo'
<h1>Afdelingen</h1>
<br>
<input type="button" onclick="document.location.href=\'/?action=addemployee\';" value="Werknemer toevoegen">
<br>
<br>
<table>
<tr>
<th>Afbeelding</th>
<th>Voornaam</th>
<th>Achternaam</th>
<th>Email</th>
<th>Telefoonnummer</th>
<th>Salaris</th>
<th>Percentage provisie</th>
<th>Manager</th>
<th>Department</th>
<th>Actie</th>
</tr>';

		while ($row = $result->fetch_assoc()) {

			$row = escapeArray($row); // alle slashes weghalen

			echo'
<tr>
<td><img width="50" height="50" src="/pictures/',$row['Picture'],'" alt="',$row['FirstName'],' ',$row['LastName'],'" title="',$row['FirstName'],' ',$row['LastName'],'"></td>
<td>',$row['FirstName'],'</td>
<td>',$row['LastName'],'</td>
<td>',$row['Email'],'</td>
<td>',$row['PhoneNumber'],'</td>
<td>',$row['Salary'],'</td>
<td>',$row['CommissionPCT'],'</td>
<td>',$row['ManagerID'],'</td>
<td>',$row['DepartmentID'],'</td>
<td><a href="/?action=editemployee&id=',$row['EmployeeID'],'">Bewerken</a> | <a href="javascript:confirmAction(\'Zeker weten?\', \'/?action=deleteemployee&id=',$row['EmployeeID'],'\');">Verwijderen</a></td>
</tr>';
}
		echo '
</table>';
	}
	
	
	/**
	 * Deze functie laat het banen toevoeg formulier zien	 *
	 */
	function displayAddEmployee() {
		echo'
<h1>Werknemer toevoegen</h1>
<form method="post" action="index.php?action=insertemployee" enctype="multipart/form-data">
<table>
<tr>
<td>Voornaam:</td>
<td><input type="text" name="FirstName"></td>
</tr>
<tr>
<td>Achternaam:</td>
<td><input type="text" name="LastName"></td>
</tr>
<tr>
<td>Email:</td>
<td><input type="text" name="Email"></td>
</tr>
<tr>
<td>Telefoonnummer:</td>
<td><input type="text" name="PhoneNumber"></td>
</tr>
<tr>
<td>Salaris:</td>
<td><input type="text" name="Salary"></td>
</tr>
<tr>
<td>Percentage provisie:</td>
<td><input type="text" name="CommissionPCT"></td>
</tr>
<tr>
<td>Manager:</td>
<td><input type="text" name="ManagerID"></td>
</tr>
<tr>
<td>Department:</td>
<td><input type="text" name="DepartmentID"></td>
</tr>
<tr>
<td>Afbeelding:</td>
<td><input type="file" name="Picture"></td>
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
	
	function displayEditEmployee($mysqli) {

		$sql = sprintf( "SELECT * FROM `Employees` WHERE `EmployeeID` = %d", 
						$mysqli->real_escape_string($_GET['id']) );

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		if($row = $result->fetch_assoc()) {
			$row = escapeArray($row); // alle slashes weghalen

			echo'
<h1>Werknemer bewerken</h1>
<form method="post" action="index.php?action=updateemployee" enctype="multipart/form-data">
<table>
<tr>
<td>Voornaam:</td>
<td><input type="text" name="FirstName" value="',$row['FirstName'],'"></td>
</tr>
<tr>
<td>Achternaam:</td>
<td><input type="text" name="LastName" value="',$row['LastName'],'"></td>
</tr>
<tr>
<td>Email:</td>
<td><input type="text" name="Email" value="',$row['Email'],'"></td>
</tr>
<tr>
<td>Telefoonnummer:</td>
<td><input type="text" name="PhoneNumber" value="',$row['PhoneNumber'],'"></td>
</tr>
<tr>
<td>Salaris:</td>
<td><input type="text" name="Salary" value="',$row['Salary'],'"></td>
</tr>
<tr>
<td>Percentage provisie:</td>
<td><input type="text" name="CommissionPCT" value="',$row['CommissionPCT'],'"></td>
</tr>
<tr>
<td>Manager:</td>
<td><input type="text" name="ManagerID" value="',$row['ManagerID'],'"></td>
</tr>
<tr>
<td>Department:</td>
<td><input type="text" name="DepartmentID" value="',$row['DepartmentID'],'"></td>
</tr>
<tr>
<td>Afbeelding:</td>
<td><input type="file" name="Picture"></td>
</tr>
<tr>
<td></td>
<td><button type="submit">Opslaan</button></td>
</tr>
</table>
<input type="hidden" name="EmployeeID" value="',$row['EmployeeID'],'" />
</form>';
		}
		else {
			die('Geen gegevens gevonden');
		}
	}
	
	/**
	 * Deze functie voegt een nieuwe record toe aan de tabel Employees	 *
	 */
	function addEmployee($mysqli) {
		if($_FILES['Picture']['error'] === UPLOAD_ERR_OK){ // If an image been uploaded
			$num = time(); // Base 10 integer to convert
			$b = 62; // Arbitrary base, up to 62. Add more characters for higher bases
			$base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Characters
			$r = $num % $b ; // It's all scary math from here on
			$res = $base[$r];
			$q = floor($num/$b);
			while ($q) {
			$r = $q % $b;
			$q =floor($q/$b);
			$res = $base[$r].$res;
			}

			$picturename = $res.'.jpg';
			move_uploaded_file($_FILES['Picture']['tmp_name'], getcwd().'/pictures/'.$picturename);
		} else {
			$picturename = 'default.jpg';
		}

		// Letop we maken gebruik van sprintf. Kijk op php.net voor meer info.
		// Binnen sprintf staat %s voor een string, %d voor een decimaal (integer) en %f voor een float

		$sql = sprintf("INSERT INTO `Employees` (`FirstName`, `LastName`, `Email`, `PhoneNumber`, `Salary`, `CommissionPCT`, `ManagerID`, `DepartmentID`, `Picture`) VALUES  ('%s', '%s', '%s', '%s', '%f', '%s', '%d', '%d', '%s')",
						$mysqli->real_escape_string($_POST['FirstName']),
						$mysqli->real_escape_string($_POST['LastName']),
						$mysqli->real_escape_string($_POST['Email']),
						$mysqli->real_escape_string($_POST['PhoneNumber']),
						$mysqli->real_escape_string($_POST['Salary']),
						$mysqli->real_escape_string($_POST['CommissionPCT']),
						$mysqli->real_escape_string($_POST['ManagerID']),
						$mysqli->real_escape_string($_POST['DepartmentID']),
						$picturename);

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		header('location: /?action=employees'); // terugkeren naar employees
		exit();
	}
	
	/**
	 * Deze functie werkt de record met ID $_POST['EmployeeID'] bij	 *
	 */
	
	function updateEmployee($mysqli) {
		if($_FILES['Picture']['error'] === UPLOAD_ERR_OK){ // If an image been uploaded
			$num = time(); // Base 10 integer to convert
			$b = 62; // Arbitrary base, up to 62. Add more characters for higher bases
			$base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Characters
			$r = $num % $b ; // It's all scary math from here on
			$res = $base[$r];
			$q = floor($num/$b);
			while ($q) {
			$r = $q % $b;
			$q =floor($q/$b);
			$res = $base[$r].$res;
			}

			$picturename = $res.'.jpg';
			move_uploaded_file($_FILES['Picture']['tmp_name'], getcwd().'/pictures/'.$picturename);
		} else {
			$picturename = 'default.jpg';
		}

		$sql = sprintf("UPDATE `Employees` SET 
						`FirstName` = '%s',
						`LastName` = '%s',
						`Email` = '%s',
						`PhoneNumber` = '%s',
						`Salary` = '%f',
						`CommissionPCT` = '%s',
						`ManagerID` = '%d',
						`DepartmentID` = '%d',
						`Picture` = '%s'
						WHERE `EmployeeID` = %d",
						$mysqli->real_escape_string($_POST['FirstName']),
						$mysqli->real_escape_string($_POST['LastName']),
						$mysqli->real_escape_string($_POST['Email']),
						$mysqli->real_escape_string($_POST['PhoneNumber']),
						$mysqli->real_escape_string($_POST['Salary']),
						$mysqli->real_escape_string($_POST['CommissionPCT']),
						$mysqli->real_escape_string($_POST['ManagerID']),
						$mysqli->real_escape_string($_POST['DepartmentID']),
						$mysqli->real_escape_string($picturename),
						$mysqli->real_escape_string($_POST['EmployeeID']) );

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		header('location: /?action=employees'); // terugkeren naar employees
		exit();
	}
	
	/**
	 * Deze functie verwijderd record met id $_GET['ID']  uit de tabel Employees
	 */	
	function deleteEmployee($mysqli) {
		$sql = sprintf("DELETE FROM `Employees` WHERE `EmployeeID` = %d", $mysqli->real_escape_string($_GET['id']));

		if (!$result = $mysqli->query($sql)) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		header('location: /?action=employees'); // terugkeren naar employees
		exit();
	}
