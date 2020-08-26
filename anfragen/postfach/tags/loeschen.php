<?php
Anfrage::post("id");

if(!Kern\Check::angemeldet()) {
  Anfrage::addFehler(-2, true);
}
if(!UI\Check::istZahl($id)) {
  Anfrage::addFehler(-3, true);
}

$pid = $DSH_BENUTZER->getId();
$DBS->datensatzLoeschen("postfach_{$pid}_tags", $id);
?>