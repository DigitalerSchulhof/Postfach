<?php
namespace Postfach;
use UI;
use Kern;

class Postfach {
  /** @var int ID der Person der das Postfach gehört */
  private $person;
  /** @var string 0/1, wenn benutzer Benachrichtigungen empfängt, sonst false*/
  private $benachrichtigung;
  /** @var int Anzahl Tage, die der Benutzer normale Nachrichten speichert */
  private $alletage;
  /** @var int Anzahl Tage, die der Benutzer Nachrichten im Papierkorb speichert */
  private $papierkorbtage;
  /** @var int Speicherplatz, der dem Postfach zur Verfügung steht */
  private $speicherplatz;
  /** @var int Speicherplatz, der dem Postfach zur Verfügung steht */
  private $signatur;

  public function __construct($id) {
    global $DBS;
    $this->person = $id;
    $sql = "SELECT {postmail}, {postalletage}, {postpapierkorbtage}, {postspeicherplatz}, {signatur} FROM postfach_nutzereinstellungen WHERE person = ?";
    $anfrage = $DBS->anfrage($sql, "i", $id);
    $anfrage->werte($this->benachrichtigung, $this->alletage, $this->papierkorbtage, $this->speicherplatz, $this->signatur);
  }

  /**
   * Liefert den Balken dieses Postfachs
   * @return UI\Balken Balken, der anzeigt, wie voll das Postfach ist
   */
  public function getBelegt() : UI\Balken {
    global $ROOT, $DBS;
    // Dateisystem Größe ermitteln
    $info = Kern\Dateisystem::ordnerInfo("$ROOT/dateien/personen/{$this->person}/Postfach");
    $belegt = $info["groesse"];
    // Datenbankgröße ermitteln
    $belegt += Kern\Dateisystem::tabellenGroesse($DBS, $this->profilTabellen());
    return new UI\Balken("Speicher", $belegt, $this->speicherplatz*1000*1000);
  }

  /**
   * Gibt an, wie viele Nachrichten in welchem Bereich des Postfachs liegen
   * @return array Anzahl Nachrichten der einzelnen Bereiche
   */
  public function getStatus() {
    global $DBS;
    $eingang['-'] = 0;
		$eingang[1] = 0;
    $zahlen['ein'] = 0;
    $zahlen['aus'] = 0;
    $zahlen['ent'] = 0;
    $zahlen['pap'] = 0;
    $sql = "SELECT [gelesen], COUNT(gelesen) FROM postfach_{$this->person}_eingang WHERE papierkorb = {?} GROUP BY gelesen";
    $anfrage = $DBS->anfrage($sql, "s", "-");
    while ($anfrage->werte($status, $anzahl)) {
      $eingang[$status] = $anzahl;
      $zahlen['ein'] += $anzahl;
    }
    if ($eingang[1] > 0) {
      $zahlen['ein'] = $eingang[1]."/".$zahlen['ein'];
    }

    $sql = "SELECT COUNT(*) FROM postfach_{$this->person}_ausgang WHERE papierkorb = {?}";
    $anfrage = $DBS->anfrage($sql, "s", "-");
    $anfrage->werte($zahlen['aus']);

    $sql = "SELECT COUNT(*) FROM postfach_{$this->person}_entwuerfe WHERE papierkorb = {?}";
    $anfrage = $DBS->anfrage($sql, "s", "-");
    $anfrage->werte($zahlen['ent']);

    $sql = "SELECT COUNT(*) FROM postfach_{$this->person}_eingang WHERE papierkorb = {?}";
    $anfrage = $DBS->anfrage($sql, "s", "1");
    $anfrage->werte($zahl);
    $zahlen['pap'] += $zahl;

    $sql = "SELECT COUNT(*) FROM postfach_{$this->person}_ausgang WHERE papierkorb = {?}";
    $anfrage = $DBS->anfrage($sql, "s", "1");
    $anfrage->werte($zahl);
    $zahlen['pap'] += $zahl;

    $sql = "SELECT COUNT(*) FROM postfach_{$this->person}_entwuerfe WHERE papierkorb = {?}";
    $anfrage = $DBS->anfrage($sql, "s", "1");
    $anfrage->werte($zahl);
    $zahlen['pap'] += $zahl;

    return $zahlen;
  }

  /**
   * Posftacheinstellungen laden
   * @return UI\Formular Formular für die Postfacheinstellungen
   */
  public function getPostfacheinstellungen() : UI\FormularTabelle {
    global $DSH_BENUTZER;
    $formular         = new UI\FormularTabelle();
    $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Nachrichten:"),          (new UI\IconToggle("dshProfil{$this->person}Nachrichtenmails", "Ich möchte eine eMail-Benachrichtugung erhalten, wenn ich eine Nachricht im Postfach erhalte.", new UI\Icon(UI\Konstanten::HAKEN)))->setWert($this->benachrichtigung));
    $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Löschfrist Postfach (Tage):"),          (new UI\Zahlenfeld("dshProfil{$this->person}PostfachLoeschfrist", 1, 1000))->setWert($this->alletage));
    $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Löschfrist Papierkorb (Tage):"),        (new UI\Zahlenfeld("dshProfil{$this->person}PapierkorbLoeschfrist", 1, 1000))->setWert($this->papierkorbtage));
    $speicherplatzF = (new UI\Zahlenfeld("dshProfil{$this->person}PostfachSpeicherplatz", 10, 5000))->setWert($this->speicherplatz);
    if (!$DSH_BENUTZER->hatRecht("personen.andere.profil.einstellungen.speicherplatz")) {
      $speicherplatzF->setAttribut("disabled");
    }
    $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Speicherplatz (MB):"), $speicherplatzF);
    $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Signatur:"), (new UI\Editor("dshProfil{$this->person}PostfachSignatur"))->setWert($this->signatur));

    $formular[]       = (new UI\Knopf("Änderungen speichern", "Erfolg"))  ->setSubmit(true);
    $formular         ->addSubmit("postfach.schulhof.nutzerkonto.aendern.einstellungen.postfach('{$this->person}')");
    return $formular;
  }

  public function getEingangsfilter() : string {
    return new Eingangsfilter($this, "dshPostfachEingang", "console.log(1)");
  }

  /**
   * Generiert die Tabelle des Aktionsprotokolls für den angegebenen Tag
   * @param  int       $datum Timestamp des Tages von dem das Aktionsprotokoll stammen soll
   * @return UI\Tabelle        :)
   */
  public function getTags($autoladen = false, $sortSeite = 1, $sortDatenproseite = 25, $sortSpalte = 0, $sortRichtung = "ASC") : UI\Tabelle {
    global $DBS, $DSH_BENUTZER;
    if ($this->person != $DSH_BENUTZER->getId()) {
      throw new \Exception("Unzulässiger Zugriff");
    }

    $spalten = [["{titel} AS titel"], ["{farbe} AS farbe"], ["id"]];
    $sql = "SELECT ?? FROM postfach_{$this->person}_tags";
    $ta = new Kern\Tabellenanfrage($sql, $spalten, $sortSeite, $sortDatenproseite, $sortSpalte, $sortRichtung);
    $tanfrage = $ta->anfrage($DBS);
    $anfrage = $tanfrage["Anfrage"];

    $tabelle = new UI\Tabelle("dshPostfachTags", "postfach.tags.laden", new UI\Icon("fas fa-tag"), "Titel", "Farbe");
    if ($autoladen) {
      $tabelle->setAutoladen(true);
    } else {
      while ($anfrage->werte($titel, $farbe, $id)) {
        $zeile = new UI\Tabelle\Zeile();
        $zeile["Titel"] = $titel;
        $zeile["Farbe"] = new UI\Farbbeispiel($farbe);

        $knopf = UI\MiniIconKnopf::bearbeiten();
        $knopf ->addFunktion("onclick", "schulhof.postfach.tags.bearbeiten('$id')");
        $zeile ->addAktion($knopf);

        $knopf = UI\MiniIconKnopf::loeschen();
        $knopf ->addFunktion("onclick", "schulhof.postfach.tags.loeschen.fragen('$id')");
        $zeile ->addAktion($knopf);

        $tabelle[] = $zeile;
      }
    }

    return $tabelle;
  }


  public function neuerTag() : string {
    global $DSH_BENUTZER;
    if ($this->person != $DSH_BENUTZER->getId()) {
      throw new \Exception("Unzulässiger Zugriff");
    }

    $fensterid = "dshPostfachNeuerTag";

    $fenstertitel = (new UI\Icon("fas fa-tag"))." Neuen Tag anlegen";

    $formular         = new UI\FormularTabelle();

    $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Titel:"),    new UI\Textfeld("dshPostfachNeuerTagTitel"));
    $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Farbe:"),    new UI\Farbfeld("dshPostfachNeuerTagFarbe"));
    $formular[]       = (new UI\Knopf("Neuen Tag anlegen", "Erfolg"))  ->setSubmit(true);
    $formular         ->addSubmit("postfach.tags.neu.erstellen()");
    $fensterinhalt    = UI\Zeile::standard($formular);

    $code = new UI\Fenster($fensterid, $fenstertitel, $fensterinhalt, true, true);
    $code->addFensteraktion(UI\Knopf::schliessen($fensterid));

    return $code;
  }

  /**
   * Liefert ein Array mit allen Posttabellen dieses Posrtfachs zurück
   * @return string[] Tabellen dieses Postfachs
   */
  public function profilTabellen() : array {
    $tabellen = [];
    $tabellen[] = "postfach_{$this->person}_ausgang";
    $tabellen[] = "postfach_{$this->person}_eingang";
    $tabellen[] = "postfach_{$this->person}_entwuerfe";
    $tabellen[] = "postfach_{$this->person}_getaggedausgang";
    $tabellen[] = "postfach_{$this->person}_getaggedeingang";
    $tabellen[] = "postfach_{$this->person}_getaggedentwurf";
    $tabellen[] = "postfach_{$this->person}_tags";
    return $tabellen;
  }
}

?>