<?php
$sql = "DROP TABLE postfach_{$PERSONID}_ausgang;";
$DBS->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_eingang";
$DBS->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_entwuerfe;";
$DBS->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_getaggedausgang;";
$DBS->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_getaggedeingang;";
$DBS->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_getaggedentwuerfe;";
$DBS->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_tags;";
$DBS->anfrage($sql);


// Ordner für das Personenpostfach anlegen
if (is_dir("$ROOT/dateien/personen/$PERSONID/Postfach")) {
  Kern\Dateisystem::ordnerLoeschen("$ROOT/dateien/personen/$PERSONID/Postfach");
}

$sql = "DELETE FROM postfach_nutzereinstellungen WHERE person = ?";
$DBS->anfrage($sql, "i", $PERSONID);

?>