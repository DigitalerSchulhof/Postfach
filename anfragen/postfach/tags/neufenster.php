<?php
if(!Kern\Check::angemeldet()) {
  Anfrage::addFehler(-2, true);
}

include_once __DIR__."/_details.php";
Anfrage::setRueck("Code", (string) postfachDetails(null));
?>