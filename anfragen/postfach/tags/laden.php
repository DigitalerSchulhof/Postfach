<?php
Anfrage::postSort();

if(!Kern\Check::angemeldet()) {
  Anfrage::addFehler(-2, true);
}

$postfach = new Postfach\Postfach($DSH_BENUTZER->getId());

Anfrage::setRueck("Code", (string) $postfach->getTags(false, $sortSeite, $sortDatenproseite, $sortSpalte, $sortRichtung));
?>
