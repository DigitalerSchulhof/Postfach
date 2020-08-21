<?php
$SEITE = new Kern\Seite("Postfach", null);

$spalte    = new UI\Spalte("A1");
$spalte[]  = new UI\SeitenUeberschrift("Postfach");

$reiter = new UI\Reiter("dshPostfach");
$reiterkopf = new UI\Reiterkopf("Posteingang");
$posteingang = "";
$reiterspalte = new UI\Spalte("A1", $posteingang);
$reiterkoerper = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter->addReitersegment(new UI\Reitersegment($reiterkopf, $reiterkoerper));

$reiterkopf = new UI\Reiterkopf("Postausgang");
$posteingang = "";
$reiterspalte = new UI\Spalte("A1", $posteingang);
$reiterkoerper = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter->addReitersegment(new UI\Reitersegment($reiterkopf, $reiterkoerper));

$reiterkopf = new UI\Reiterkopf("Postausgang");
$posteingang = "";
$reiterspalte = new UI\Spalte("A1", $posteingang);
$reiterkoerper = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter->addReitersegment(new UI\Reitersegment($reiterkopf, $reiterkoerper));

$reiterkopf = new UI\Reiterkopf("Entwürfe");
$posteingang = "";
$reiterspalte = new UI\Spalte("A1", $posteingang);
$reiterkoerper = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter->addReitersegment(new UI\Reitersegment($reiterkopf, $reiterkoerper));

$reiterkopf = new UI\Reiterkopf("Papierkorb");
$posteingang = "";
$reiterspalte = new UI\Spalte("A1", $posteingang);
$reiterkoerper = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter->addReitersegment(new UI\Reitersegment($reiterkopf, $reiterkoerper));

$reiterkopf = new UI\Reiterkopf("Einstellungen");
$posteingang = "";
$reiterspalte = new UI\Spalte("A1", $posteingang);
$reiterkoerper = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));
$reiter->addReitersegment(new UI\Reitersegment($reiterkopf, $reiterkoerper));


$spalte[] = $reiter;
$SEITE[]  = new UI\Zeile($spalte);
?>
