<?php
$sql = "DROP TABLE postfach_postausgang_{$PERSONID};";
$DBP->anfrage($sql);

$sql = "DROP TABLE postfach_posteingang_{$PERSONID};";
$DBP->anfrage($sql);

$sql = "DROP TABLE postfach_postentwurf_{$PERSONID};";
$DBP->anfrage($sql);

$sql = "DROP TABLE postfach_postgetaggedausgang_{$PERSONID}";
$DBP->anfrage($sql);

$sql = "DROP TABLE postfach_postgetaggedeingang_{$PERSONID};";
$DBP->anfrage($sql);

$sql = "DROP TABLE postfach_postgetaggedentwurf_{$PERSONID};";
$DBP->anfrage($sql);

$sql = "DROP TABLE postfach_posttags_{$PERSONID};";
$DBP->anfrage($sql);

$sql = "DELETE FROM postfach_personen_signaturen WHERE person = ?";
$DBS->anfrage($sql, "i", $PERSONID);

// Ordner für das Personenpostfach anlegen
if (is_dir("$ROOT/dateien/personen/$PERSONID/Postfach")) {
  Kern\Dateisystem::ordnerLoeschen("$ROOT/dateien/personen/$PERSONID/Postfach");
}
?>