<?php
$sql = "DROP TABLE postfach_nutzereinstellungen;";
$DBS->anfrage($sql);


// Tabellen für Personen entfernen
$anfrage = $DBS->anfrage("SELECT id FROM kern_personen");
while ($anfrage->werte($pid)) {
  $sql = "DROP TABLE postfach_{$pid}_postausgang;";
  $DBS->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_posteingang";
  $DBS->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_postentwurf;";
  $DBS->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_postgetaggedausgang;";
  $DBS->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_postgetaggedeingang;";
  $DBS->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_postgetaggedentwurf;";
  $DBS->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_posttags;";
  $DBS->anfrage($sql);


  // Ordner für das Personenpostfach anlegen
  if (is_dir("$ROOT/dateien/personen/$pid/Postfach")) {
    Kern\Dateisystem::ordnerLoeschen("$ROOT/dateien/personen/$pid/Postfach");
  }
}

// Das Modul wurde deinstalliert

?>