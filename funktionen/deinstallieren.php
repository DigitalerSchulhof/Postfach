<?php
$sql = "DROP TABLE postfach_nutzereinstellungen;";
$DBP->anfrage($sql);

$sql = "DROP TABLE postfach_signaturen;";
$DBP->anfrage($sql);


// Tabellen für Personen entfernen
$anfrage = $DBS->anfrage("SELECT id FROM kern_personen");
while ($anfrage->werte($pid)) {
  $sql = "DROP TABLE postfach_{$pid}_postausgang;";
  $DBP->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_posteingang";
  $DBP->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_postentwurf;";
  $DBP->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_postgetaggedausgang;";
  $DBP->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_postgetaggedeingang;";
  $DBP->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_postgetaggedentwurf;";
  $DBP->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_posttags;";
  $DBP->anfrage($sql);


  // Ordner für das Personenpostfach anlegen
  if (is_dir("$ROOT/dateien/personen/$pid/Postfach")) {
    Kern\Dateisystem::ordnerLoeschen("$ROOT/dateien/personen/$pid/Postfach");
  }
}

// Das Modul wurde deinstalliert

?>