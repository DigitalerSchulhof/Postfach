<?php
$sql = "DROP TABLE postfach_{$PERSONID}_postausgang;";
$DBS->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_posteingang";
$DBS->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_postentwurf;";
$DBS->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_postgetaggedausgang;";
$DBS->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_postgetaggedeingang;";
$DBS->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_postgetaggedentwurf;";
$DBS->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_posttags;";
$DBS->anfrage($sql);


// Ordner für das Personenpostfach anlegen
if (is_dir("$ROOT/dateien/personen/$PERSONID/Postfach")) {
  Kern\Dateisystem::ordnerLoeschen("$ROOT/dateien/personen/$PERSONID/Postfach");
}

$sql = "DELETE FROM postfach_nutzereinstellungen WHERE person = ?";
$DBS->anfrage($sql, "i", $PERSONID);

?>