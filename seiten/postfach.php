<?php
$SEITE = new Kern\Seite("Postfach", null);

$spalte    = new UI\Spalte("A1");
$spalte[]  = new UI\SeitenUeberschrift("Postfach");
$spalte[]  = new UI\GrossIconKnopf(new UI\Icon("fas fa-feather-alt"), "Nachricht schreiben", "Erfolg");

$postfach = new Postfach\Postfach($DSH_BENUTZER->getId());
$anzahlen = $postfach->getStatus();

$reiter = new UI\Reiter("dshPostfach");
$reiterkopf = new UI\Reiterkopf(new UI\Icon("fas fa-inbox-in")." Posteingang ".(new UI\Meldezahl($anzahlen['ein'])));
$reiterinhalt = $postfach->getPosteingang();
$reiterspalte = new UI\Spalte("A1", $reiterinhalt);
$reiterkoerper = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter->addReitersegment(new UI\Reitersegment($reiterkopf, $reiterkoerper));

$reiterkopf = new UI\Reiterkopf(new UI\Icon("fas fa-inbox-out")." Postausgang ".(new UI\Meldezahl($anzahlen['aus'])));
$reiterinhalt = "";
$reiterspalte = new UI\Spalte("A1", $reiterinhalt);
$reiterkoerper = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter->addReitersegment(new UI\Reitersegment($reiterkopf, $reiterkoerper));

$reiterkopf = new UI\Reiterkopf(new UI\Icon("fas fa-pencil-ruler")." Entwürfe ".(new UI\Meldezahl($anzahlen['ent'])));
$reiterinhalt = "";
$reiterspalte = new UI\Spalte("A1", $reiterinhalt);
$reiterkoerper = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter->addReitersegment(new UI\Reitersegment($reiterkopf, $reiterkoerper));

$reiterkopf = new UI\Reiterkopf(new UI\Icon(UI\Konstanten::PAPIERKORB)." Papierkorb ".(new UI\Meldezahl($anzahlen['pap'])));
$reiterinhalt = "";
$reiterspalte = new UI\Spalte("A1", $reiterinhalt);
$reiterkoerper = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter->addReitersegment(new UI\Reitersegment($reiterkopf, $reiterkoerper));



$reiterkopf = new UI\Reiterkopf(new UI\Icon(UI\Konstanten::EINSTELLUNGEN)." Einstellungen");
$reiterinhalt = $postfach->getPostfacheinstellungen();
$reiterspalte = new UI\Spalte("A1", $reiterinhalt);
$reiterkoerper = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter->addReitersegment(new UI\Reitersegment($reiterkopf, $reiterkoerper));

$spalte[] = $reiter;
$spalte[] = "<div id=\"dshPostfachBalken\">".$postfach->getBelegt()."</div>";
$SEITE[]  = new UI\Zeile($spalte);
?>
