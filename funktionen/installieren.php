<?php
// Tabellen für Personen anlegen
$anfrage = $DBS->anfrage("SELECT id FROM kern_personen");

while ($anfrage->werte($pid)) {
  $sql = "CREATE TABLE postfach_postausgang_{$pid} (
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
  $DBP->anfrage($sql);

  $sql = "CREATE TABLE postfach_posteingang_{$pid} (
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
  $DBP->anfrage($sql);

  $sql = "CREATE TABLE postfach_postentwurf_{$pid} (
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
  $DBP->anfrage($sql);

  $sql = "CREATE TABLE postfach_postgetaggedausgang_{$pid} (
  	tag bigint(255) UNSIGNED NOT NULL,
  	nachricht bigint(255) UNSIGNED NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBP->anfrage($sql);

  $sql = "CREATE TABLE postfach_postgetaggedeingang_{$pid} (
  	tag bigint(255) UNSIGNED NOT NULL,
  	nachricht bigint(255) UNSIGNED NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBP->anfrage($sql);

  $sql = "CREATE TABLE postfach_postgetaggedentwurf_{$pid} (
  	tag bigint(255) UNSIGNED NOT NULL,
  	nachricht bigint(255) UNSIGNED NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBP->anfrage($sql);

  $sql = "CREATE TABLE postfach_posttags_{$pid} (
  	id bigint(255) UNSIGNED NOT NULL,
  	person bigint(255) UNSIGNED NULL DEFAULT NULL,
  	titel varbinary(2000) DEFAULT NULL,
  	farbe int(2) NOT NULL DEFAULT 0,
  	idvon bigint(255) UNSIGNED DEFAULT NULL,
  	idzeit bigint(255) UNSIGNED DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
  $DBP->anfrage($sql);

  $sql = "ALTER TABLE postfach_postausgang_{$pid}
  ADD PRIMARY KEY (id);";
  $DBP->anfrage($sql);

  $sql = "ALTER TABLE postfach_posteingang_{$pid}
  ADD PRIMARY KEY (id);";
  $DBP->anfrage($sql);

  $sql = "ALTER TABLE postfach_postentwurf_{$pid}
  ADD PRIMARY KEY (id);";
  $DBP->anfrage($sql);

  $sql = "ALTER TABLE postfach_postgetaggedausgang_{$pid}
  ADD UNIQUE KEY tag (tag,nachricht),
  ADD KEY nachrichtposttaggedausgang_{$pid} (nachricht);";
  $DBP->anfrage($sql);

  $sql = "ALTER TABLE postfach_postgetaggedeingang_{$pid}
  ADD UNIQUE KEY tag (tag,nachricht),
  ADD KEY nachrichtposttaggedeingang_{$pid} (nachricht);";
  $DBP->anfrage($sql);

  $sql = "ALTER TABLE postfach_postgetaggedentwurf_{$pid}
  ADD UNIQUE KEY tag (tag,nachricht),
  ADD KEY nachrichtposttaggedentwurf_{$pid} (nachricht);";
  $DBP->anfrage($sql);

  $sql = "ALTER TABLE postfach_posttags_{$pid}
  ADD PRIMARY KEY (id);";
  $DBP->anfrage($sql);

  $sql = "ALTER TABLE postfach_postgetaggedausgang_{$pid}
  ADD CONSTRAINT nachrichtposttaggedausgang_{$pid} FOREIGN KEY (nachricht) REFERENCES postausgang_{$pid} (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT tagposttaggedausgang_{$pid} FOREIGN KEY (tag) REFERENCES posttags_{$pid} (id) ON DELETE CASCADE ON UPDATE CASCADE;";
  $DBP->anfrage($sql);

  $sql = "ALTER TABLE postfach_postgetaggedeingang_{$pid}
  ADD CONSTRAINT nachrichtposttaggedeingang_{$pid} FOREIGN KEY (nachricht) REFERENCES posteingang_{$pid} (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT tagposttaggedeingang_{$pid} FOREIGN KEY (tag) REFERENCES posttags_{$pid} (id) ON DELETE CASCADE ON UPDATE CASCADE;";
  $DBP->anfrage($sql);

  $sql = "ALTER TABLE postfach_postgetaggedentwurf_{$pid}
  ADD CONSTRAINT nachrichtposttaggedentwurf_{$pid} FOREIGN KEY (nachricht) REFERENCES postentwurf_{$pid} (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT tagposttaggedentwurf_{$pid} FOREIGN KEY (tag) REFERENCES posttags_{$pid} (id) ON DELETE CASCADE ON UPDATE CASCADE;";
  $DBP->anfrage($sql);

  $sql = "INSERT INTO postfach_personen_signaturen (person, signatur) VALUES (?, {''})";
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