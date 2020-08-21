<?php

use Kern\Verwaltung\Liste;
use Kern\Verwaltung\Element;
use UI\Icon;

$essen    = Liste::addKategorie(new \Kern\Verwaltung\Kategorie("essen", "Essen"));

if($DSH_BENUTZER->hatRecht("lecker") || false)  $essen[] = new Element("Lasagne", "Lasagnegehalt einstellen", new Icon("fas fa-cat"), "Schulhof/Verwaltung/Garfield", true);
?>
