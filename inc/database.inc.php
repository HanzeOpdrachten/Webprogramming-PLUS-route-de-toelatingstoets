<?php

	/**
	 * Dit bestand bevat alle functies die nodig zijn om een
	 * verbinding met de database tot stand te brengen en de
	 * verbreken
	 */

	/**
	 * Deze functie maakt een verbinding met de MySQL server
	 * en gebruikt daarvoor de variabelen de globale array
	 * $config. Daarna selecteerd deze functie de juiste database.
	 *
	 */
	function databaseConnect() {
		global $config;
		$mysqli;

		$mysqli = new mysqli($config['mysql']['hostname'], $config['mysql']['username'], $config['mysql']['password'], $config['mysql']['database']);

		if ($mysqli->connect_errno) {
			http_response_code(503);
			echo '<h1>Database Error</h1>';
			exit(1);
		}

		return $mysqli;
	}
	
	/**
	 * Deze functie verbreekt de verbinding met de database server
	 *
	 */
	function databaseDisconnect($mysqli) {
		$mysqli->close();
	}
	
	
?>