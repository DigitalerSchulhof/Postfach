<?php
switch ($meldeid) {
  case 0:
    Anfrage::setRueck("Meldung", new UI\Meldung("Änderungen erfolgreich!", "Die Änderungen der Postfach-Einstellungen wurden vorgenomen.", "Erfolg"));
    break;
}
?>
