<?php
namespace Postfach;
use Kern, UI;

class Eingangsfilter extends Kern\Filter {
  public $postfach;

  /**
   * Erstellt einen neuen Filter
   * @param int    $id    :)
   * @param string $ziel  Javascript-Funktion die ausgelöst wird
   * @param bool   $auto  Aktiviert die Aktualisierung des Ergebnisses bei Nutzereingabe wenn true
   */
  public function __construct($postfach, $id, $ziel, $knopfart = "Filter", $auto = true) {
    parent::__construct($id, $ziel, $knopfart, $auto);
    $this->postfach = $postfach;
  }

  public function __toString() : string {
    global $DSH_ALLEMODULE;
    if ($this->anzeigen) {
      $this->knopf->setWert("1");
    }
    $code = new UI\Absatz($this->knopf);

    $formular         = new UI\FormularTabelle();
    $vorname          = new UI\Textfeld("{$this->id}FilterVorname");
    $nachname         = new UI\Textfeld("{$this->id}FilterNachname");
    $betreff          = new UI\Textfeld("{$this->id}FilterBetreff");
    $von              = new UI\Datumfeld("{$this->id}FilterZeitraumVon");
    $von              ->setWert(date("d.m.Y", time()));
    $bis              = new UI\Datumfeld("{$this->id}FilterZeitraumBis");
    $bis              ->setWert(date("d.m.Y", time()-30*24*60*60));
    //$tags             = new UI\Multitoggle("{$this->id}Tags");

    if ($this->autoaktualisierung) {
      $vorname->addFunktion("oninput", $this->ziel);
      $nachname->addFunktion("oninput", $this->ziel);
      $betreff->addFunktion("oninput", $this->ziel);
      $von->addFunktion("onclick", $this->ziel);
      $bis->addFunktion("onclick", $this->ziel);
      //$tags->addFunktion("onclick", $this->ziel);
    }

    $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Vorname:"),              $vorname);
    $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Nachname:"),             $nachname);
    $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Betreff:"),              $betreff);
    $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Von:"),                  $von);
    $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Bis:"),                  $bis);
    //$formular[]       = new UI\FormularFeld(new UI\InhaltElement("Tags:"),                 $tags);

    $formular[]       = (new UI\Knopf("Suchen", "Erfolg"))  ->setSubmit(true);
    $formular         -> addSubmit($this->ziel);
    $formular         -> setID("{$this->id}A");
    if (!$this->anzeigen) {
      $formular       -> addKlasse("dshUiUnsichtbar");
    }

    $code            .= $formular;
    return $code;
  }
}

?>