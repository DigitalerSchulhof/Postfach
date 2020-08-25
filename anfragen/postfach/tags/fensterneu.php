<?php
if(!Kern\Check::angemeldet()) {
  Anfrage::addFehler(-2, true);
}

$postfach = new Postfach\Postfach($DSH_BENUTZER->getId());
Anfrage::setRueck("Code", (string) $postfach->neuerTag());
?>