<?php
switch ($meldeid) {
  case 0:
    Anfrage::setRueck("Meldung", new UI\Meldung("Änderungen erfolgreich!", "Die Änderungen der Postfach-Einstellungen wurden vorgenomen.", "Erfolg"));
    break;
  case 1:
    Anfrage::setRueck("Meldung", new UI\Meldung("Änderungen erfolgreich!", "Die Änderungen der eMail-Einstellungen wurden vorgenomen.", "Erfolg"));
    break;
  case 2:
    Anfrage::setRueck("Meldung", new UI\Meldung("Tag erstellt!", "Der neue Tag wurde angeleg.", "Erfolg"));
    break;
}
?>
