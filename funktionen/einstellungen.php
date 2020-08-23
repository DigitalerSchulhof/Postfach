<?php
$sql = "SELECT {postmail}, {postalletage}, {postpapierkorbtage}, {postspeicherplatz}, {emailaktiv}, {emailadresse}, {emailname}, {einganghost}, {eingangport}, {eingangnutzer}, {eingangpasswort}, {ausganghost}, {ausgangport}, {ausgangnutzer}, {ausgangpasswort} FROM postfach_nutzereinstellungen WHERE person = ?";
$anfrage = $DBS->anfrage($sql, "i", $profilid);
$anfrage->werte($postmail, $posttage, $papierkorbtage, $postspeicherplatz, $mailaktiv, $mailadresse, $mailname, $mailehost, $maileport, $mailenutzer, $mailepasswort, $mailahost, $mailaport, $mailanutzer, $mailapasswort);

$reiterspalte = new UI\Spalte("A1");

if ($DSH_BENUTZER->hatRecht("$recht.einstellungen.postfach")) {
  $reiterspalte[]   = new UI\Ueberschrift(3, "Internes Postfach");
  $postfach = new Postfach\Postfach($profilid);
  $reiterspalte[]   = $postfach->getPostfacheinstellungen();
}
if ($DSH_BENUTZER->getId() == $profilid) {
  $reiterspalte[]   = new UI\Ueberschrift(3, "eMail-Postfach");
  $reiterspalte[]   = new UI\Meldung("eMails im Schulhof empfangen", "Achtung! Damit eMails im Schulhof empfangen werden können, müssen Zugangsdaten gespeichert werden. Dies geschieht natürlich verschlüsselt.", "Information");
  $formular         = new UI\FormularTabelle();
  $mailaktivknopf   = new UI\IconToggle("dshProfil{$profilid}EmailAktiv", "eMails über den Schulhof verwalten", new UI\Icon(UI\Konstanten::HAKEN));
  $mailaktivknopf   ->setWert($mailaktiv);
  $mailaktivknopf   ->addFunktion("onclick", "ui.formular.anzeigenwenn('dshProfil{$profilid}EmailAktiv', '1', 'dshProfil{$profilid}EmailFelder')");
  $mailaktivF       = new UI\FormularFeld(new UI\InhaltElement("Aktiv:"), $mailaktivknopf);
  $formular[]       = $mailaktivF;

  $mailadresseF     = new UI\FormularFeld(new UI\InhaltElement("eMail-Adresse:"),             (new UI\Mailfeld("dshProfil{$profilid}EmailAdresse"))->setWert($mailadresse));
  $mailnameF        = new UI\FormularFeld(new UI\InhaltElement("Angezeigter Name:"),               (new UI\Textfeld("dshProfil{$profilid}EmailName"))->setWert($mailname));
  $mailehostF       = new UI\FormularFeld(new UI\InhaltElement("IMAP-Host (Posteingang):"),   (new UI\Textfeld("dshProfil{$profilid}EmailEingangHost"))->setWert($mailehost));
  $maileportF       = new UI\FormularFeld(new UI\InhaltElement("IMAP-Port (Posteingang):"),   (new UI\Zahlenfeld("dshProfil{$profilid}EmailEingangPort",0,65535))->setWert($maileport));
  $mailenutzerF     = new UI\FormularFeld(new UI\InhaltElement("Benutzername (Posteingang):"),(new UI\Textfeld("dshProfil{$profilid}EmailEingangNutzer"))->setWert($mailenutzer));
  $mailepasswortF   = new UI\FormularFeld(new UI\InhaltElement("Passwort (Posteingang):"),    (new UI\Passwortfeld("dshProfil{$profilid}EmailEingangPasswort"))->setWert($mailepasswort));
  $mailepasswortF   ->setOptional(true);
  $mailahostF       = new UI\FormularFeld(new UI\InhaltElement("SMTP-Host (Postausgang):"),   (new UI\Textfeld("dshProfil{$profilid}EmailAusgangHost"))->setWert($mailahost));
  $mailaportF       = new UI\FormularFeld(new UI\InhaltElement("SMTP-Port (Postausgang):"),   (new UI\Zahlenfeld("dshProfil{$profilid}EmailAusgangPort",0,65535))->setWert($mailaport));
  $mailanutzerF     = new UI\FormularFeld(new UI\InhaltElement("Benutzername (Posteingang):"),(new UI\Textfeld("dshProfil{$profilid}EmailAusgangNutzer"))->setWert($mailanutzer));
  $mailanutzerF     ->setOptional(true);
  $mailapasswortF   = new UI\FormularFeld(new UI\InhaltElement("Passwort (Postausgang):"),    (new UI\Passwortfeld("dshProfil{$profilid}EmailAusgangPasswort"))->setWert($mailapasswort));
  $mailapasswortF   ->setOptional(true);

  if ($mailaktiv != 1) {
    $mailadresseF     ->addKlasse("dshUiUnsichtbar");
    $mailnameF        ->addKlasse("dshUiUnsichtbar");
    $mailehostF       ->addKlasse("dshUiUnsichtbar");
    $maileportF       ->addKlasse("dshUiUnsichtbar");
    $mailenutzerF     ->addKlasse("dshUiUnsichtbar");
    $mailepasswortF   ->addKlasse("dshUiUnsichtbar");
    $mailahostF       ->addKlasse("dshUiUnsichtbar");
    $mailaportF       ->addKlasse("dshUiUnsichtbar");
    $mailanutzerF     ->addKlasse("dshUiUnsichtbar");
    $mailapasswortF   ->addKlasse("dshUiUnsichtbar");
  }
  $mailadresseF     ->addKlasse("dshProfil{$profilid}EmailFelder");
  $mailnameF        ->addKlasse("dshProfil{$profilid}EmailFelder");
  $mailehostF       ->addKlasse("dshProfil{$profilid}EmailFelder");
  $maileportF       ->addKlasse("dshProfil{$profilid}EmailFelder");
  $mailenutzerF     ->addKlasse("dshProfil{$profilid}EmailFelder");
  $mailepasswortF   ->addKlasse("dshProfil{$profilid}EmailFelder");
  $mailahostF       ->addKlasse("dshProfil{$profilid}EmailFelder");
  $mailaportF       ->addKlasse("dshProfil{$profilid}EmailFelder");
  $mailanutzerF     ->addKlasse("dshProfil{$profilid}EmailFelder");
  $mailapasswortF   ->addKlasse("dshProfil{$profilid}EmailFelder");

  $formular[]       = $mailadresseF;
  $formular[]       = $mailnameF;
  $formular[]       = $mailehostF;
  $formular[]       = $maileportF;
  $formular[]       = $mailenutzerF;
  $formular[]       = $mailepasswortF;
  $formular[]       = $mailahostF;
  $formular[]       = $mailaportF;
  $formular[]       = $mailanutzerF;
  $formular[]       = $mailapasswortF;

  $formular[]       = (new UI\Knopf("Änderungen speichern", "Erfolg"))  ->setSubmit(true);
  $formular         ->addSubmit("postfach.schulhof.nutzerkonto.aendern.einstellungen.email('{$profilid}')");
  $reiterspalte[]   = $formular;
}
$reiterkopf     = new UI\Reiterkopf("Postfach", new UI\Icon("fas fa-envelope"));
$reiterkoerper  = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));

return [new UI\Reitersegment($reiterkopf, $reiterkoerper)];
?>