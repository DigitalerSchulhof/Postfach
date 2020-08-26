<?php
Anfrage::postSort();

if(!Kern\Check::angemeldet()) {
  Anfrage::addFehler(-2, true);
}

$PERSONID = $DSH_BENUTZER->getId();

$spalten = [["{titel} AS titel"], ["{farbe} AS farbe"], ["id"]];
$sql = "SELECT ?? FROM postfach_{$PERSONID}_tags";
$ta = new Kern\Tabellenanfrage($sql, $spalten, $sortSeite, $sortDatenproseite, $sortSpalte, $sortRichtung);
$tanfrage = $ta->anfrage($DBS);
$anfrage = $tanfrage["Anfrage"];

$tabelle = new UI\Tabelle("dshPostfachTags", "postfach.tags.suchen", new UI\Icon("fas fa-tag"), "Titel", "Farbe");

while ($anfrage->werte($titel, $farbe, $id)) {
  $zeile = new UI\Tabelle\Zeile();
  $zeile["Titel"] = $titel;
  $zeile["Farbe"] = new UI\Farbbeispiel($farbe);

  $knopf = UI\MiniIconKnopf::bearbeiten();
  $knopf ->addFunktion("onclick", "postfach.tags.bearbeiten.fenster('$id')");
  $zeile ->addAktion($knopf);

  $knopf = UI\MiniIconKnopf::loeschen();
  $knopf ->addFunktion("onclick", "postfach.tags.loeschen.fragen('$id')");
  $zeile ->addAktion($knopf);

  $tabelle[] = $zeile;
}

Anfrage::setRueck("Code", (string) $tabelle);
?>
