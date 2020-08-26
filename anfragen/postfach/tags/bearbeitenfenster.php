<?php
Anfrage::post(false, "id");

if(!Kern\Check::angemeldet()) {
  Anfrage::addFehler(-2, true);
}

if (!UI\Check::istZahl($id)) {
  Anfrage::addFehler(-3, true);
}

include_once __DIR__."/_details.php";
Anfrage::setRueck("Code", (string) postfachDetails($id));
?>