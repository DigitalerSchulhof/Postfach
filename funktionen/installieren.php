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

// Tabellen für Personen anlegen
$anfrage = $DBS->anfrage("SELECT id FROM kern_personen");
while ($anfrage->werte($pid)) {
  $sql = "CREATE TABLE postfach_{$pid}_ausgang (
  	id bigint(255) UNSIGNED NOT NULL,
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

  $sql = "CREATE TABLE postfach_{$pid}_eingang (
  	id bigint(255) UNSIGNED NOT NULL,
  	absender bigint(255) UNSIGNED NULL DEFAULT NULL,
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

  $sql = "CREATE TABLE postfach_{$pid}_entwuerfe (
  	id bigint(255) UNSIGNED NOT NULL,
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

  $sql = "CREATE TABLE postfach_{$pid}_tags (
  	id bigint(255) UNSIGNED NOT NULL,
  	titel varbinary(2000) DEFAULT NULL,
  	farbe varbinary(500) DEFAULT NULL,
  	idvon bigint(255) UNSIGNED DEFAULT NULL,
  	idzeit bigint(255) UNSIGNED DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBS->anfrage($sql);

  $sql = "CREATE TABLE postfach_{$pid}_getaggedausgang (
    tag bigint(255) UNSIGNED NOT NULL,
    nachricht bigint(255) UNSIGNED NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBS->anfrage($sql);

  $sql = "CREATE TABLE postfach_{$pid}_getaggedeingang (
    tag bigint(255) UNSIGNED NOT NULL,
    nachricht bigint(255) UNSIGNED NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBS->anfrage($sql);

  $sql = "CREATE TABLE postfach_{$pid}_getaggedentwuerfe (
    tag bigint(255) UNSIGNED NOT NULL,
    nachricht bigint(255) UNSIGNED NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_ausgang
  ADD PRIMARY KEY (id);";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_eingang
  ADD PRIMARY KEY (id);";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_entwuerfe
  ADD PRIMARY KEY (id);";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_getaggedausgang
  ADD UNIQUE KEY tag (tag,nachricht),
  ADD KEY nachrichtgetaggedausgang_{$pid} (nachricht);";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_getaggedeingang
  ADD UNIQUE KEY tag (tag,nachricht),
  ADD KEY nachrichtgetaggedeingang_{$pid} (nachricht);";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_getaggedentwuerfe
  ADD UNIQUE KEY tag (tag,nachricht),
  ADD KEY nachrichtgetaggedentwuerfe_{$pid} (nachricht);";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_getaggedausgang
  ADD CONSTRAINT postfach_{$pid}_getaggedausgang_nachricht FOREIGN KEY (nachricht) REFERENCES postfach_{$pid}_ausgang (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT postfach_{$pid}_getaggedausgang_tags FOREIGN KEY (tag) REFERENCES postfach_{$pid}_tags (id) ON DELETE CASCADE ON UPDATE CASCADE;";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_getaggedeingang
  ADD CONSTRAINT postfach_{$pid}_getaggedeingang_nachricht FOREIGN KEY (nachricht) REFERENCES postfach_{$pid}_eingang (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT postfach_{$pid}_getaggedeingang_tags FOREIGN KEY (tag) REFERENCES postfach_{$pid}_tags (id) ON DELETE CASCADE ON UPDATE CASCADE;";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_getaggedentwuerfe
  ADD CONSTRAINT postfach_{$pid}_getaggedentwuerfe_nachricht FOREIGN KEY (nachricht) REFERENCES postfach_{$pid}_entwuerfe (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT postfach_{$pid}_getaggedentwuerfe_tags FOREIGN KEY (tag) REFERENCES postfach_{$pid}_tags (id) ON DELETE CASCADE ON UPDATE CASCADE;";
  $DBS->anfrage($sql);

  $sql = "ALTER TABLE postfach_{$pid}_tags
  ADD PRIMARY KEY (id);";
  $DBS->anfrage($sql);

  $sql = "INSERT INTO postfach_nutzereinstellungen (person, postmail, postalletage, postpapierkorbtage, postspeicherplatz, signatur, emailaktiv, emailadresse, emailname, einganghost, eingangport, eingangnutzer, eingangpasswort, ausganghost, ausgangport, ausgangnutzer, ausgangpasswort) VALUES (?, ['1'], ['365'], ['30'], ['100'], ['0'], [''], [''], [''], [''], [''], [''], [''], [''], [''], [''], ['']);";
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