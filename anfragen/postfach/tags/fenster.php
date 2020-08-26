<?php
Anfrage::post(false, "id");

if(!Kern\Check::angemeldet()) {
  Anfrage::addFehler(-2, true);
}

if ($id !== null) {
  if (!UI\Check::istZahl($id)) {
    Anfrage::addFehler(-3, true);
  }
}

$postfach = new Postfach\Postfach($DSH_BENUTZER->getId());
Anfrage::setRueck("Code", (string) $postfach->getTag($id));
?>