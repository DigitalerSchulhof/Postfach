<?php

use Kern\Verwaltung\Liste;
use Kern\Verwaltung\Element;
use UI\Icon;

$technik    = Liste::addKategorie(new \Kern\Verwaltung\Kategorie("technik", "Technik"));

if($DSH_BENUTZER->hatRecht("personen.andere.profil.einstellungen.speicherplatz"))  $technik[] = new Element("Postfach Speicherlimits", "Postfach Speicherlimits einstellen", new Icon("fas fa-mail-bulk"), "Schulhof/Verwaltung/Postfach", true);
?>
