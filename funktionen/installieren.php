<?php

// Tabellen anlegen
$sql = "CREATE TABLE postfach_nutzereinstellungen (
  person bigint(255) UNSIGNED DEFAULT NULL,
  postmail varbinary(50) DEFAULT NULL,
  postalletage varbinary(500) DEFAULT NULL,
  postpapierkorbtage varbinary(500) DEFAULT NULL,
  postspeicherplatz varbinary(500) DEFAULT NULL,
  signatur blob DEFAULT NULL,
  emailaktiv varbinary(50) DEFAULT NULL,
  emailadresse varbinary(500) DEFAULT NULL,
  emailname varbinary(500) DEFAULT NULL,
  einganghost varbinary(500) DEFAULT NULL,
  eingangport varbinary(500) DEFAULT NULL,
  eingangnutzer varbinary(500) DEFAULT NULL,
  eingangpasswort varbinary(500) DEFAULT NULL,
  ausganghost varbinary(500) DEFAULT NULL,
  ausgangport varbinary(500) DEFAULT NULL,
  ausgangnutzer varbinary(500) DEFAULT NULL,
  ausgangpasswort varbinary(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_nutzereinstellungen
ADD PRIMARY KEY (person);";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_nutzereinstellungen
ADD CONSTRAINT postfachnutzereinstellungen FOREIGN KEY (person) REFERENCES kern_personen (id) ON DELETE CASCADE ON UPDATE CASCADE;";
$DBS->anfrage($sql);

$sql = "ALTER TABLE personen_signaturen
ADD CONSTRAINT postfachsignaturenpersonen FOREIGN KEY (person) REFERENCES personen (id) ON DELETE CASCADE ON UPDATE CASCADE;";
$DBS->anfrage($sql);

// Tabellen für Personen anlegen
$anfrage = $DBS->anfrage("SELECT id FROM kern_personen");
while ($anfrage->werte($pid)) {
  $sql = "CREATE TABLE postfach_{$pid}_postausgang (
  	id bigint(255) UNSIGNED NOT NULL,
  	absender bigint(255) UNSIGNED NULL DEFAULT NULL,
  	empfaenger text COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  	zeit bigint(255) UNSIGNED DEFAULT NULL,
  	betreff varbinary(5000) DEFAULT NULL,
  	nachricht longblob DEFAULT NULL,
  	papierkorb varbinary(50) DEFAULT NULL,
  	papierkorbseit bigint(255) DEFAULT NULL,
  	archiviert varbinary(50) DEFAULT NULL,
  	idvon bigint(255) UNSIGNED DEFAULT NULL,
  	idzeit bigint(255) UNSIGNED DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBS->anfrage($sql);

  $sql = "CREATE TABLE postfach_{$pid}_posteingang (
  	id bigint(255) UNSIGNED NOT NULL,
  	absender bigint(255) UNSIGNED NULL DEFAULT NULL,
  	empfaenger bigint(255) UNSIGNED NULL DEFAULT NULL,
  	alle text COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  	zeit bigint(255) UNSIGNED DEFAULT NULL,
  	betreff varbinary(5000) DEFAULT NULL,
  	nachricht longblob DEFAULT NULL,
  	gelesen varbinary(50) DEFAULT NULL,
  	beantwortet varbinary(50) DEFAULT NULL,
  	papierkorb varbinary(50) DEFAULT NULL,
  	papierkorbseit bigint(255) UNSIGNED NULL DEFAULT NULL,
  	archiviert varbinary(50) DEFAULT NULL,
  	idvon bigint(255) UNSIGNED DEFAULT NULL,
  	idzeit bigint(255) UNSIGNED DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBS->anfrage($sql);

  $sql = "CREATE TABLE postfach_{$pid}_postentwurf (
  	id bigint(255) UNSIGNED NOT NULL,
  	absender bigint(255) UNSIGNED NULL DEFAULT NULL,
  	empfaenger text COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  	zeit bigint(255) UNSIGNED DEFAULT NULL,
  	betreff varbinary(5000) DEFAULT NULL,
  	nachricht longblob DEFAULT NULL,
  	papierkorb varbinary(50) DEFAULT NULL,
  	papierkorbseit bigint(255) UNSIGNED NULL DEFAULT NULL,
  	archiviert varbinary(50) DEFAULT NULL,
  	idvon bigint(255) UNSIGNED DEFAULT NULL,
  	idzeit bigint(255) UNSIGNED DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBS->anfrage($sql);

  $sql = "CREATE TABLE postfach_{$pid}_postgetaggedausgang (
  	tag bigint(255) UNSIGNED NOT NULL,
  	nachricht bigint(255) UNSIGNED NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBS->anfrage($sql);

  $sql = "CREATE TABLE postfach_{$pid}_postgetaggedeingang (
  	tag bigint(255) UNSIGNED NOT NULL,
  	nachricht bigint(255) UNSIGNED NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBS->anfrage($sql);

  $sql = "CREATE TABLE postfach_{$pid}_postgetaggedentwurf (
  	tag bigint(255) UNSIGNED NOT NULL,
  	nachricht bigint(255) UNSIGNED NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBS->anfrage($sql);

  $sql = "CREATE TABLE postfach_{$pid}_posttags (
  	id bigint(255) UNSIGNED NOT NULL,
  	person bigint(255) UNSIGNED NULL DEFAULT NULL,
  	titel varbinary(2000) DEFAULT NULL,
  	farbe int(2) NOT NULL DEFAULT 0,
  	idvon bigint(255) UNSIGNED DEFAULT NULL,
  	idzeit bigint(255) UNSIGNED DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_postausgang
  ADD PRIMARY KEY (id);";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_posteingang
  ADD PRIMARY KEY (id);";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_postentwurf
  ADD PRIMARY KEY (id);";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_postgetaggedausgang
  ADD UNIQUE KEY tag (tag,nachricht),
  ADD KEY nachrichtposttaggedausgang_{$pid} (nachricht);";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_postgetaggedeingang
  ADD UNIQUE KEY tag (tag,nachricht),
  ADD KEY nachrichtposttaggedeingang_{$pid} (nachricht);";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_postgetaggedentwurf
  ADD UNIQUE KEY tag (tag,nachricht),
  ADD KEY nachrichtposttaggedentwurf_{$pid} (nachricht);";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_posttags
  ADD PRIMARY KEY (id);";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_postgetaggedausgang
  ADD CONSTRAINT nachrichtposttaggedausgang_{$pid} FOREIGN KEY (nachricht) REFERENCES postfach_{$pid}_postausgang (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT tagposttaggedausgang_{$pid} FOREIGN KEY (tag) REFERENCES postfach_{$pid}_posttags (id) ON DELETE CASCADE ON UPDATE CASCADE;";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_postgetaggedeingang_{$pid}
  ADD CONSTRAINT nachrichtposttaggedeingang_{$pid} FOREIGN KEY (nachricht) REFERENCES postfach_{$pid}_posteingang (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT tagposttaggedeingang_{$pid} FOREIGN KEY (tag) REFERENCES postfach_{$pid}_posttags (id) ON DELETE CASCADE ON UPDATE CASCADE;";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_postgetaggedentwurf_{$pid}
  ADD CONSTRAINT nachrichtposttaggedentwurf_{$pid} FOREIGN KEY (nachricht) REFERENCES postfach_{$pid}_postentwurf (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT tagposttaggedentwurf_{$pid} FOREIGN KEY (tag) REFERENCES postfach_{$pid}_posttags (id) ON DELETE CASCADE ON UPDATE CASCADE;";
  $DBS->anfrage($sql);

  $sql = "INSERT INTO postfach_nutzereinstellungen (person, postmail, postalletage, postpapierkorbtage, postspeicherplatz, postsignatur, emailaktiv, emailadresse, emailname, einganghost, eingangport, eingangnutzer, eingangpasswort, ausganghost, ausgangport, ausgangnutzer, ausgangpasswort) VALUES (?, ['1'], ['365'], ['30'], ['100'], ['0'], [''], [''], [''], [''], [''], [''], [''], [''], [''], [''], ['']);";
  $DBS->anfrage($sql, "i", $pid);

  // Ordner für das Personenpostfach anlegen
  if (is_dir("$ROOT/dateien/personen/$pid/Postfach")) {
    Kern\Dateisystem::ordnerLoeschen("$ROOT/dateien/personen/$pid/Postfach");
  }
  mkdir("$ROOT/dateien/personen/$pid/Postfach");
  mkdir("$ROOT/dateien/personen/$pid/Postfach/temp");
  mkdir("$ROOT/dateien/personen/$pid/Postfach/eingang");
  mkdir("$ROOT/dateien/personen/$pid/Postfach/ausgang");
  mkdir("$ROOT/dateien/personen/$pid/Postfach/entwurf");
  mkdir("$ROOT/dateien/personen/$pid/Postfach/papierkorb");
  mkdir("$ROOT/dateien/personen/$pid/Postfach/papierkorb/eingang");
  mkdir("$ROOT/dateien/personen/$pid/Postfach/papierkorb/ausgang");
  mkdir("$ROOT/dateien/personen/$pid/Postfach/papierkorb/entwurf");
}

// Das Modul wurde installiert
?>