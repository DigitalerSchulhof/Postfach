<?php
$SEITE = new Kern\Seite("Postfach", null);

$spalte    = new UI\Spalte("A1");
$spalte[]  = new UI\SeitenUeberschrift("Postfach");
$spalte[]  = new UI\GrossIconKnopf(new UI\Icon("fas fa-feather-alt"), "Nachricht schreiben", "Erfolg");

$postfach = new Postfach\Postfach($DSH_BENUTZER->getId());
$anzahlen = $postfach->getStatus();

$reiter = new UI\Reiter("dshPostfach");

$reiterkopf     = new UI\Reiterkopf("Posteingang", new UI\Icon("fas fa-inbox"), $anzahlen['ein']);
$reiterspalte   = new UI\Spalte("A1", $postfach->getEingangsfilter());
$reiterkoerper  = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter[]       = new UI\Reitersegment($reiterkopf, $reiterkoerper);

$reiterkopf     = new UI\Reiterkopf("Postausgang", new UI\Icon("fas fa-paper-plane"), $anzahlen['aus']);
$reiterinhalt   = "";
$reiterspalte   = new UI\Spalte("A1", $reiterinhalt);
$reiterkoerper  = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter[]       = new UI\Reitersegment($reiterkopf, $reiterkoerper);

$reiterkopf     = new UI\Reiterkopf("Entwürfe", new UI\Icon("fas fa-drafting-compass"), $anzahlen['ent']);
$reiterinhalt   = "";
$reiterspalte   = new UI\Spalte("A1", $reiterinhalt);
$reiterkoerper  = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter[]       = new UI\Reitersegment($reiterkopf, $reiterkoerper);

$reiterkopf     = new UI\Reiterkopf("Papierkorb", new UI\Icon(UI\Konstanten::PAPIERKORB),  $anzahlen['pap']);
$reiterinhalt   = "";
$reiterspalte   = new UI\Spalte("A1", $reiterinhalt);
$reiterkoerper  = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter[]       = new UI\Reitersegment($reiterkopf, $reiterkoerper);




$reiterkopf     = new UI\Reiterkopf("Tags", new UI\Icon("fas fa-tags"));
$reiterinhalt   = $postfach->getTags(true);
$knopf          = new UI\IconKnopf(new UI\Icon(UI\Konstanten::NEU), "Neuen Tag anlegen", "Erfolg");
$knopf          ->addFunktion("onclick", "postfach.tags.neu.laden()");
$reiterinhalt  .= new UI\Absatz($knopf);
$reiterspalte   = new UI\Spalte("A1", $reiterinhalt);
$reiterkoerper  = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter[]       = new UI\Reitersegment($reiterkopf, $reiterkoerper);

$reiterkopf     = new UI\Reiterkopf("Einstellungen", new UI\Icon(UI\Konstanten::EINSTELLUNGEN));
$reiterinhalt   = $postfach->getPostfacheinstellungen();
$reiterspalte   = new UI\Spalte("A1", $reiterinhalt);
$reiterkoerper  = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter[]       = new UI\Reitersegment($reiterkopf, $reiterkoerper);

$spalte[] = $reiter;
$spalte[] = "<div id=\"dshPostfachBalken\">".$postfach->getBelegt()."</div>";
$SEITE[]  = new UI\Zeile($spalte);
?>
