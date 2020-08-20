<?php
// Tabellen entfernen
$anfrage = $DBS->anfrage("SELECT id FROM kern_personen");

while ($anfrage->werte($pid)) {
  $sql = "DROP TABLE postfach_postausgang_{$pid};";
  $DBP->anfrage($sql);

  $sql = "DROP TABLE postfach_posteingang_{$pid};";
  $DBP->anfrage($sql);

  $sql = "DROP TABLE postfach_postentwurf_{$pid};";
  $DBP->anfrage($sql);

  $sql = "DROP TABLE postfach_postgetaggedausgang_{$pid}";
  $DBP->anfrage($sql);

  $sql = "DROP TABLE postfach_postgetaggedeingang_{$pid};";
  $DBP->anfrage($sql);

  $sql = "DROP TABLE postfach_postgetaggedentwurf_{$pid};";
  $DBP->anfrage($sql);

  $sql = "DROP TABLE postfach_posttags_{$pid};";
  $DBP->anfrage($sql);

  $sql = "DELETE FROM postfach_personen_signaturen WHERE person = ?";
  $DBS->anfrage($sql, "i", $pid);

  // Ordner für das Personenpostfach anlegen
  if (is_dir("$ROOT/dateien/personen/$pid/Postfach")) {
    Kern\Dateisystem::ordnerLoeschen("$ROOT/dateien/personen/$pid/Postfach");
  }
}

// Das Modul wurde deinstalliert

?>