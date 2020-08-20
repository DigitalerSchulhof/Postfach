<?php
$reiterspalte = new UI\Spalte("A1");

if ($DSH_BENUTZER->hatRecht("$recht.einstellungen.postfach")) {
  $reiterspalte[]   = new UI\Ueberschrift(3, "Internes Postfach");
  $formular         = new UI\FormularTabelle();
  $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Löschfrist Postfach (Tage):"),          (new UI\Zahlenfeld("dshProfil{$profilid}PostfachLoeschfrist", 1, 1000))->setWert($posttage));
  $formular[]       = new UI\FormularFeld(new UI\InhaltElement("Löschfrist Papierkorb (Tage):"),        (new UI\Zahlenfeld("dshProfil{$profilid}PapierkorbLoeschfrist", 1, 1000))->setWert($papierkorbtage));

  $formular[]       = (new UI\Knopf("Änderungen speichern", "Erfolg"))  ->setSubmit(true);
  $formular         ->addSubmit("kern.schulhof.nutzerkonto.aendern.einstellungen.postfach('{$profilid}')");
  $reiterspalte[]   = $formular;
}
if ($DSH_BENUTZER->getId() == $this->person->getId()) {
  $reiterspalte[]   = new UI\Ueberschrift(3, "eMail-Postfach");
  $reiterspalte[]   = new UI\Meldung("eMails im Schulhof empfangen", "Achtung! Damit eMails im Schulhof empfangen werden können, müssen Zugangsdaten gespeichert werden. Dies geschieht natürlich verschlüsselt.", "Information");
  $formular         = new UI\FormularTabelle();
  $mailaktivknopf   = new UI\IconToggle("dshProfil{$profilid}EmailAktiv", "eMails über den Schulhof verwalten", new UI\Icon(UI\Konstanten::HAKEN));
  $mailaktivknopf   ->setWert($mailaktiv);
  $mailaktivknopf   ->addFunktion("onclick", "ui.formular.anzeigenwenn('dshProfil{$profilid}EmailAktiv', '1', 'dshProfil{$profilid}EmailFelder')");
  $mailaktivF       = new UI\FormularFeld(new UI\InhaltElement("Aktiv:"), $mailaktivknopf);
  $formular[]       = $mailaktivF;

  $mailadresseF     = new UI\FormularFeld(new UI\InhaltElement("eMail-Adresse:"),             (new UI\Mailfeld("dshProfil{$profilid}EmailAdresse"))->setWert($mailadresse));
  $mailnameF        = new UI\FormularFeld(new UI\InhaltElement("Anzeigename:"),               (new UI\Textfeld("dshProfil{$profilid}EmailName"))->setWert($mailname));
  $mailehostF       = new UI\FormularFeld(new UI\InhaltElement("IMAP-Host (Posteingang):"),   (new UI\Textfeld("dshProfil{$profilid}EmailEingangHost"))->setWert($mailehost));
  $maileportF       = new UI\FormularFeld(new UI\InhaltElement("IMAP-Port (Posteingang):"),   (new UI\Zahlenfeld("dshProfil{$profilid}EmailEingangPort",0,65535))->setWert($maileport));
  $mailenutzerF     = new UI\FormularFeld(new UI\InhaltElement("Benutzername (Posteingang):"),(new UI\Textfeld("dshProfil{$profilid}EmailEingangNutzer"))->setWert($mailenutzer));
  $mailepasswortF   = new UI\FormularFeld(new UI\InhaltElement("Passwort (Posteingang):"),    (new UI\Passwortfeld("dshProfil{$profilid}EmailEingangPasswort"))->setWert($mailepasswort));
  $mailepasswortF   ->setOptional(true);
  $mailahostF       = new UI\FormularFeld(new UI\InhaltElement("SMTP-Host (Postausgang):"),   (new UI\Textfeld("dshProfil{$profilid}EmailAusgangHost"))->setWert($mailahost));
  $mailaportF       = new UI\FormularFeld(new UI\InhaltElement("SMTP-Port (Postausgang):"),   (new UI\Zahlenfeld("dshProfil{$profilid}EmailAusgangPort",0,65535))->setWert($mailaport));
  $mailanutzerF     = new UI\FormularFeld(new UI\InhaltElement("Benutzername (Posteingang):"),(new UI\Textfeld("dshProfil{$profilid}EmailEingangNutzer"))->setWert($mailanutzer));
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
  $formular         ->addSubmit("kern.schulhof.nutzerkonto.aendern.einstellungen.email('{$profilid}')");
  $reiterspalte[]   = $formular;
}
$reiterkopf = new UI\Reiterkopf("Postfach");
$reiterkoerper = new UI\Reiterkoerper($reiterspalte->addKlasse("dshUiOhnePadding"));

return [new UI\Reitersegment($reiterkopf, $reiterkoerper)];
?>