<?php
switch ($meldeid) {
  case 0:
    Anfrage::setRueck("Meldung", new UI\Meldung("Änderungen erfolgreich!", "Die Änderungen der Postfach-Einstellungen wurden vorgenomen.", "Erfolg"));
    break;
  case 1:
    Anfrage::setRueck("Meldung", new UI\Meldung("Änderungen erfolgreich!", "Die Änderungen der eMail-Einstellungen wurden vorgenomen.", "Erfolg"));
    break;
  case 2:
    Anfrage::setRueck("Meldung", new UI\Meldung("Tag erstellt!", "Der neue Tag wurde angelegt.", "Erfolg"));
    break;
  case 3:
    parameter("id");
    Anfrage::setRueck("Meldung", new UI\Meldung("Diesen Tag wirklich löschen", "Soll der Tag wirklich gelöscht werden?", "Warnung"));
    $knoepfe[] = new UI\Knopf("Tag löschen", "Fehler", "postfach.tags.loeschen.ausfuehren('$id')");
    $knoepfe[] = UI\Knopf::abbrechen();
    Anfrage::setRueck("Knöpfe", $knoepfe);
    break;
  case 4:
    Anfrage::setRueck("Meldung", new UI\Meldung("Tag löschen", "Der Tag wurde gelöscht.", "Erfolg"));
    break;
  case 5:
    Anfrage::setRueck("Meldung", new UI\Meldung("Tag bearbeiten", "Der Tag wurde geändert.", "Erfolg"));
    break;
}
?>
