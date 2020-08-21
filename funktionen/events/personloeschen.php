<?php
$sql = "DROP TABLE postfach_{$PERSONID}_postausgang;";
$DBP->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_posteingang";
$DBP->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_postentwurf;";
$DBP->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_postgetaggedausgang;";
$DBP->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_postgetaggedeingang;";
$DBP->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_postgetaggedentwurf;";
$DBP->anfrage($sql);

$sql = "DROP TABLE postfach_{$PERSONID}_posttags;";
$DBP->anfrage($sql);


// Ordner für das Personenpostfach anlegen
if (is_dir("$ROOT/dateien/personen/$PERSONID/Postfach")) {
  Kern\Dateisystem::ordnerLoeschen("$ROOT/dateien/personen/$PERSONID/Postfach");
}

$sql = "DELETE FROM postfach_nutzereinstellungen WHERE person = ?";
$DBS->anfrage($sql, "i", $PERSONID);

$sql = "DELETE FROM postfach_signaturen WHERE person = ?";
$DBS->anfrage($sql, "i", $PERSONID);

?>