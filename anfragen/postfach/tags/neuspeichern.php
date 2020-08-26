<?php
Anfrage::post("titel", "farbe");

if(!Kern\Check::angemeldet()) {
  Anfrage::addFehler(-2, true);
}
if(!UI\Check::istTitel($titel)) {
  Anfrage::addFehler(11);
}

if (UI\Check::istHexFarbe($farbe)) {
  $farbe = UI\Generieren::HexZuRgba($farbe);
}
if(!UI\Check::istRgbaFarbe($farbe)) {
  Anfrage::addFehler(12);
}
Anfrage::checkFehler();

$pid = $DSH_BENUTZER->getId();
$id = $DBS->neuerDatensatz("postfach_{$pid}_tags", array("titel" => "[?]", "farbe" => "[?]"), "ss", $titel, $farbe);
?>