<?php
Anfrage::post("id", "aktiv", "adresse", "name", "ehost", "eport", "enutzer", "epasswort", "ahost", "aport", "anutzer", "apasswort");

if(!Kern\Check::angemeldet()) {
  Anfrage::addFehler(-2, true);
}

if(!UI\Check::istZahl($id,0) || !UI\Check::istToggle($aktiv)) {
  Anfrage::addFehler(-3, true);
}

$profil = new Kern\Profil(new Kern\Nutzerkonto($id));
$recht = $profil->istFremdzugriff();
if (!$DSH_BENUTZER->hatRecht("$recht.einstellungen.email")) {
  Anfrage::addFehler(-4, true);
}

if ($aktiv == "1") {
  if(!UI\Check::istMail($adresse)) {
    Anfrage::addFehler(1);
  }
  if(!UI\Check::istText($name)) {
    Anfrage::addFehler(2);
  }
  if(!UI\Check::istText($ehost)) {
    Anfrage::addFehler(3);
  }
  if(!UI\Check::istZahl($eport,0,65535)) {
    Anfrage::addFehler(4);
  }
  if(!UI\Check::istText($enutzer)) {
    Anfrage::addFehler(5);
  }

  if(!UI\Check::istText($ahost)) {
    Anfrage::addFehler(6);
  }
  if(!UI\Check::istZahl($aport,0,65535)) {
    Anfrage::addFehler(7);
  }
} else {
  $adresse = "";
  $name = "";
  $ehost = "";
  $eport = "";
  $enutzer = "";
  $epasswort = "";
  $ahost = "";
  $aport = "";
  $anutzer = "";
  $apasswort = "";
}

Anfrage::checkFehler();

$sql = "UPDATE postfach_nutzereinstellungen SET emailaktiv = [?], emailadresse = [?], emailname = [?], einganghost = [?], eingangport = [?], eingangnutzer = [?], eingangpasswort = [?], ausganghost = [?], ausgangport = [?], ausgangnutzer = [?], ausgangpasswort = [?] WHERE person = ?";
$anfrage = $DBS->silentanfrage($sql, "sssssssssssi", $aktiv, $adresse, $name, $ehost, $eport, $enutzer, $epasswort, $ahost, $aport, $anutzer, $apasswort, $id);

$logwerte = [[$aktiv, $adresse, $name, "*****", "*****", "*****", "*****", "*****", "*****", "*****", "*****", $id]];

$DBS->logZugriff("DB", "postfach_nutzereinstellungen", "UPDATE postfach_nutzereinstellungen SET emailaktiv = ?, emailadresse = ?, emailname = ?, einganghost = ?, eingangport = ?, eingangnutzer = ?, eingangpasswort = ?, ausganghost = ?, ausgangport = ?, ausgangnutzer = ?, ausgangpasswort = ? WHERE person = ?", "Änderung", $logwerte);
?>
