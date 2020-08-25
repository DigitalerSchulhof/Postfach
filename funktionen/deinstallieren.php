<?php
$sql = "DROP TABLE postfach_nutzereinstellungen;";
$DBS->anfrage($sql);

// Tabellen für Personen entfernen
$anfrage = $DBS->anfrage("SELECT id FROM kern_personen");
while ($anfrage->werte($pid)) {
  $sql = "DROP TABLE postfach_{$pid}_ausgang;";
  $DBS->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_eingang";
  $DBS->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_entwuerfe;";
  $DBS->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_getaggedausgang;";
  $DBS->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_getaggedeingang;";
  $DBS->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_getaggedentwurf;";
  $DBS->anfrage($sql);

  $sql = "DROP TABLE postfach_{$pid}_tags;";
  $DBS->anfrage($sql);


  // Ordner für das Personenpostfach anlegen
  if (is_dir("$ROOT/dateien/personen/$pid/Postfach")) {
    Kern\Dateisystem::ordnerLoeschen("$ROOT/dateien/personen/$pid/Postfach");
  }
}

// Das Modul wurde deinstalliert

?>