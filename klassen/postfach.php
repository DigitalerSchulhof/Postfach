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
    global $ROOT, $DBP;
    // Dateisystem Größe ermitteln
    $info = Kern\Dateisystem::ordnerInfo("$ROOT/dateien/personen/{$this->person}/Postfach");
    $belegt = $info["groesse"];
    // Datenbankgröße ermitteln
    $belegt += Kern\Dateisystem::tabellenGroesse($DBP, $this->profilTabellen());
    return new UI\Balken("Speicher", $belegt, $this->speicherplatz*1000*1000);
  }

  /**
   * Gibt an, wie viele Nachrichten in welchem Bereich des Postfachs liegen
   * @return array Anzahl Nachrichten der einzelnen Bereiche
   */
  public function getStatus() {
    global $DBP;
    $eingang['-'] = 0;
		$eingang[1] = 0;
    $zahlen['ein'] = 0;
    $zahlen['aus'] = 0;
    $zahlen['ent'] = 0;
    $zahlen['pap'] = 0;
    $sql = "SELECT [gelesen], COUNT(gelesen) FROM postfach_{$this->person}_posteingang WHERE papierkorb = {?} GROUP BY gelesen";
    $anfrage = $DBP->anfrage($sql, "s", "-");
    while ($anfrage->werte($status, $anzahl)) {
      $eingang[$status] = $anzahl;
      $zahlen['ein'] += $anzahl;
    }
    if ($eingang[1] > 0) {
      $zahlen['ein'] = $eingang[1]."/".$zahlen['ein'];
    }

    $sql = "SELECT COUNT(*) FROM postfach_{$this->person}_postausgang WHERE papierkorb = {?}";
    $anfrage = $DBP->anfrage($sql, "s", "-");
    $anfrage->werte($zahlen['aus']);

    $sql = "SELECT COUNT(*) FROM postfach_{$this->person}_postentwurf WHERE papierkorb = {?}";
    $anfrage = $DBP->anfrage($sql, "s", "-");
    $anfrage->werte($zahlen['ent']);

    $sql = "SELECT COUNT(*) FROM postfach_{$this->person}_posteingang WHERE papierkorb = {?}";
    $anfrage = $DBP->anfrage($sql, "s", "1");
    $anfrage->werte($zahl);
    $zahlen['pap'] += $zahl;

    $sql = "SELECT COUNT(*) FROM postfach_{$this->person}_postausgang WHERE papierkorb = {?}";
    $anfrage = $DBP->anfrage($sql, "s", "1");
    $anfrage->werte($zahl);
    $zahlen['pap'] += $zahl;

    $sql = "SELECT COUNT(*) FROM postfach_{$this->person}_postentwurf WHERE papierkorb = {?}";
    $anfrage = $DBP->anfrage($sql, "s", "1");
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

  public function getPosteingang() : string {
    $spalten = [["{gelesen} AS gelesen", "{beantwortet} AS beantwortet"], ["{nachname} AS nachname", "{vorname} AS vorname", "{titel} AS titel"], ["{betreff} AS betreff"], ["zeit"], ["{archiviert} as archiviert"]];
    $sql = "SELECT ?? FROM postfach_{$this->person}_posteingang WHERE papierkorb = {'-'}";
    $tanfrage = new Kern\Tabellenanfrage($sql, $spalten, 1, 25, 4);
    return "";
  }

  /**
   * Liefert ein Array mit allen Posttabellen dieses Posrtfachs zurück
   * @return string[] Tabellen dieses Postfachs
   */
  public function profilTabellen() : array {
    $tabellen = [];
    $tabellen[] = "postfach_{$this->person}_postausgang";
    $tabellen[] = "postfach_{$this->person}_posteingang";
    $tabellen[] = "postfach_{$this->person}_postentwurf";
    $tabellen[] = "postfach_{$this->person}_postgetaggedausgang";
    $tabellen[] = "postfach_{$this->person}_postgetaggedeingang";
    $tabellen[] = "postfach_{$this->person}_postgetaggedentwurf";
    $tabellen[] = "postfach_{$this->person}_posttags";
    return $tabellen;
  }
}

?>