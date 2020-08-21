<?php
Anfrage::post("id", "nachricht", "postfach", "papierkorb", "speicherplatz");

if(!Kern\Check::angemeldet()) {
  Anfrage::addFehler(-2, true);
}

if(!UI\Check::istZahl($id,0) || !UI\Check::istToggle($nachricht)) {
  Anfrage::addFehler(-3, true);
}

$profil = new Kern\Profil(new Kern\Nutzerkonto($id));
$recht = $profil->istFremdzugriff();
if (!$DSH_BENUTZER->hatRecht("$recht.einstellungen.postfach")) {
  Anfrage::addFehler(-4, true);
}

if(!UI\Check::istZahl($postfach,1,1000)) {
  Anfrage::addFehler(8);
}
if(!UI\Check::istZahl($papierkorb,1,1000)) {
  Anfrage::addFehler(9);
}
if(!UI\Check::istZahl($speicherplatz,10,5000)) {
  Anfrage::addFehler(10);
}

Anfrage::checkFehler();

if (!$DSH_BENUTZER->hatRecht("personen.andere.profil.einstellungen.speicherplatz")) {
  $sql = "UPDATE postfach_nutzereinstellungen SET postmail = [?], postalletage = [?], postpapierkorbtage = [?] WHERE person = ?";
  $anfrage = $DBS->anfrage($sql, "sssi", $nachricht, $postfach, $papierkorb, $id);
} else {
  $sql = "UPDATE postfach_nutzereinstellungen SET postmail = [?], postalletage = [?], postpapierkorbtage = [?], postspeicherplatz = [?] WHERE person = ?";
  $anfrage = $DBS->anfrage($sql, "ssssi", $nachricht, $postfach, $papierkorb, $speicherplatz, $id);
}

?>
