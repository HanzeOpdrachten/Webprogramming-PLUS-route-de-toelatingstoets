<?php

	/**
	 * Dit bestand bevat de algemen functies die niet direct toe te kennen zijn aan 
	 * objecten zoals jobs en employees.
	 */
	
	
	/**
	 * Deze functie genereerd een standaard HTML header	 
	 */
	function displayHeader() {
		global $config;

		echo '<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="renderer" content="webkit">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>',$config['pagetitle'],'</title>
<link type="text/css" rel="stylesheet" href="/css/style.css">
<link rel="icon" href="favicon.gif" type="image/gif" >
<script type="text/javascript" src="/js/general.js"></script>
</head>
<body>
<div id="wrapper">';
	}
	
	
	/**
	 * Deze functie genereerd een standaard HTML footer
	 */
	function displayFooter() {
		global $config;

		// hier zou plaats zijn voor bijvoorbeeld google analytics scripts

		echo '
</div>
</body>
</html>';
	}
	
	/**
	 * Deze functie laat het navigatiemenu zien
	 */
	function displayNavigation() {
		echo '
<a href="/"><img width="128" height="128" src="/img/logo.png" alt="logo" title="logo"></a>
<div id="navigation">
<div class="button"><a href="/">Home</a></div>
<div class="button"><a href="/?action=jobs">Banen</a></div>
<div class="button"><a href="/?action=locations">Locaties</a></div>
<div class="button"><a href="/?action=employees">Werknemers</a></div>
<div class="button"><a href="/?action=departments">Afdelingen</a></div>
</div>';
	}

	/**
	 * Deze functie laat de beginpagina zien
	 */
	function displayHome() {
		echo '
<h1>Welkom</h1>
<p>Maak een keuze uit het navigatiemenu</p>';
	}
	
	/**
	 * Deze functies haalt alle slashes weg die gegenereerd zijn door mysql_escape_string().
	 * Deze functie doorzoekt een volledige array.
	 */
	function escapeArray($array) {
		foreach($array as $key => $value) {
			$array[$key] = stripslashes($value);
		}
		
		return $array;
	}
	
	/**
	 * Deze functie wordt gebruikt om de huidige actie te bepalen
	 * als er geen actie is opgegeven in de url dan wordt de config 
	 * standaard actie gebruikt.
	 *
	 */
	function getCurrentAction() {
		global $config;
		
		if(isset($_GET['action']) == true) {
			return $_GET['action'];
		}
		else {
			return $config['defaultaction'];
		}
	}
