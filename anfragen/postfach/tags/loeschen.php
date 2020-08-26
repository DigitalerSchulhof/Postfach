<?php
Anfrage::post("id");

if(!Kern\Check::angemeldet()) {
  Anfrage::addFehler(-2, true);
}
if(!UI\Check::istZahl($id)) {
  Anfrage::addFehler(-3, true);
}

$pid = $DSH_BENUTZER->getId();
$DBS->anfrage("DELETE FROM postfach_{$pid}_tags WHERE id = ?", "i", $id);
?>