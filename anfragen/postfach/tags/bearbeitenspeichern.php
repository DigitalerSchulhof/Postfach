<?php
Anfrage::post("id", "titel", "farbe");

if(!Kern\Check::angemeldet()) {
  Anfrage::addFehler(-2, true);
}
if(!UI\Check::istZahl($id)) {
  Anfrage::addFehler(-3, true);
}
if(!UI\Check::istTitel($titel)) {
  Anfrage::addFehler(13);
}

if (UI\Check::istHexFarbe($farbe)) {
  $farbe = UI\Generieren::HexZuRgba($farbe);
}
if(!UI\Check::istRgbaFarbe($farbe)) {
  Anfrage::addFehler(14);
}
Anfrage::checkFehler();

$pid = $DSH_BENUTZER->getId();
$DBS->datensatzBearbeiten("postfach_{$pid}_tags", $id, array("titel" => "[?]", "farbe" => "[?]"), "ss", $titel, $farbe);
?>