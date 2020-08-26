<?php
function postfachDetails($id = null) : UI\Fenster {
  global $DBS, $DSH_BENUTZER;
  $formular         = new UI\FormularTabelle();
  $PERSONID = $DSH_BENUTZER->getId();

  if ($id === null) {
    $fensterid = "dshPostfachTagNeu";
    $fenstertitel = (new UI\Icon("fas fa-tag"))." Neuen Tag anlegen";
    $formular         ->addSubmit("postfach.tags.neu.speichern()");
    $knopf = (new UI\Knopf("Neuen Tag anlegen", "Erfolg"))  ->setSubmit(true);
  } else {
    $fensterid = "dshPostfachTag$id";
    $fenstertitel = (new UI\Icon("fas fa-tag"))." Tag bearbeiten";
    $formular         ->addSubmit("postfach.tags.bearbeiten.speichern('$id')");
    $knopf = (new UI\Knopf("Tag bearbeiten", "Erfolg"))  ->setSubmit(true);
  }

  $titel = new UI\Textfeld("{$fensterid}Titel");
  $farbe = new UI\Farbfeld("{$fensterid}Farbe");

  if ($id !== null) {
    global $DBS;
    $sql = "SELECT {titel}, {farbe} FROM postfach_{$PERSONID}_tags WHERE id = ?";
    $DBS->anfrage($sql, "i", $id)->werte($titelW, $farbeW);
    $titel->setWert($titelW);
    $farbe->setWert($farbeW);
  }

  $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Titel:"),    $titel);
  $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Farbe:"),    $farbe);
  $formular[]       = $knopf;
  $fensterinhalt    = UI\Zeile::standard($formular);

  $fenster = new UI\Fenster($fensterid, $fenstertitel, $fensterinhalt, true, true);
  $fenster->addFensteraktion(UI\Knopf::schliessen($fensterid));
  return $fenster;
}
?>