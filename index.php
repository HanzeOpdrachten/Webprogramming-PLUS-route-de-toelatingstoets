<?php

	error_reporting(E_ALL);

	include('conf/config.conf.php'); // De configuratie van het systeem
	include('inc/database.inc.php'); // Funties om verbinding met de database te maken

	include('inc/general.inc.php'); // Algemene functies zoals drawHeader en drawFooter
	include('inc/jobs.inc.php');
	include('inc/locations.inc.php');
	include('inc/employees.inc.php');
	include('inc/departments.inc.php');

	$mysqli = databaseConnect(); // verbinding met de database maken
	
	// Hieronder alle functies die geen output genereren naar de browser
	// Dit is nodig om de 'warning headers already sent' fout te voorkomen
	switch(getCurrentAction()) {
		// Jobs

		case 'insertjob':
			addJob($mysqli);
		break;
		case 'updatejob':
			updateJob($mysqli);
		break;		
		case 'deletejob':
			deleteJob($mysqli);
		break;
		
		// Locations

		case 'insertlocation':
			addLocation($mysqli);
		break;
		case 'updatelocation':
			updateLocation($mysqli);
		break;		
		case 'deletelocation':
			deleteLocation($mysqli);
		break;
		
		// Employees

		case 'insertemployee':
			addEmployees($mysqli);
		break;
		case 'updateemployee':
			updateEmployees($mysqli);
		break;		
		case 'deleteemployee':
			deleteEmployees($mysqli);
		break;
		
		// Departments

		case 'insertdepartment':
			addDepartments($mysqli);
		break;
		case 'updatedepartment':
			updateDepartments($mysqli);
		break;		
		case 'deletedepartment':
			deleteDepartments($mysqli);
		break;
	}
	
	displayHeader(); // de HTML header tonen	
	displayNavigation(); // de menubalk tonen
	
	// Hieronder alle functies die wel output genereren naar de browser
	switch(getCurrentAction()) {
		// Jobs

		case 'jobs':
			displayAllJobs($mysqli);
		break;
		case 'addjob':
			displayAddJob();
		break;
		case 'editjob':
			displayEditJob($mysqli);
		break;

		// Locations

		case 'locations':
			displayAllLocations($mysqli);
		break;
		case 'addlocation':
			displayAddLocation();
		break;
		case 'editlocation':
			displayEditLocation($mysqli);
		break;

		// Employees

		case 'employees':
			displayAllEmployees($mysqli);
		break;
		case 'addemployee':
			displayAddEmployee();
		break;
		case 'editemployee':
			displayEditEmployee($mysqli);
		break;

		// Departments

		case 'departments':
			displayAllDepartments($mysqli);
		break;
		case 'adddepartment':
			displayAddDepartment();
		break;
		case 'editdepartment':
			displayEditDepartment($mysqli);
		break;

		// Home

		default:
		case 'home':
			displayHome();
		break;
	}

	displayFooter(); // de HTML footer tonen

	databaseDisconnect($mysqli); // verbinding met de database verbreken
