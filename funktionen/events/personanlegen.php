<?php
$sql = "CREATE TABLE postfach_{$PERSONID}_ausgang (
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

$sql = "CREATE TABLE postfach_{$PERSONID}_eingang (
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

$sql = "CREATE TABLE postfach_{$PERSONID}_entwuerfe (
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

$sql = "CREATE TABLE postfach_{$PERSONID}_tags (
  id bigint(255) UNSIGNED NOT NULL,
  titel varbinary(2000) DEFAULT NULL,
  farbe varbinary(500) DEFAULT NULL,
  idvon bigint(255) UNSIGNED DEFAULT NULL,
  idzeit bigint(255) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$DBS->anfrage($sql);

$sql = "CREATE TABLE postfach_{$PERSONID}_getaggedausgang (
  tag bigint(255) UNSIGNED NOT NULL,
  nachricht bigint(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$DBS->anfrage($sql);

$sql = "CREATE TABLE postfach_{$PERSONID}_getaggedeingang (
  tag bigint(255) UNSIGNED NOT NULL,
  nachricht bigint(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$DBS->anfrage($sql);

$sql = "CREATE TABLE postfach_{$PERSONID}_getaggedentwuerfe (
  tag bigint(255) UNSIGNED NOT NULL,
  nachricht bigint(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_ausgang
ADD PRIMARY KEY (id);";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_eingang
ADD PRIMARY KEY (id);";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_entwuerfe
ADD PRIMARY KEY (id);";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_getaggedausgang
ADD UNIQUE KEY tag (tag,nachricht),
ADD KEY nachrichtgetaggedausgang_{$PERSONID} (nachricht);";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_getaggedeingang
ADD UNIQUE KEY tag (tag,nachricht),
ADD KEY nachrichtgetaggedeingang_{$PERSONID} (nachricht);";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_getaggedentwuerfe
ADD UNIQUE KEY tag (tag,nachricht),
ADD KEY nachrichtgetaggedentwuerfe_{$PERSONID} (nachricht);";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_getaggedausgang
ADD CONSTRAINT postfach_{$PERSONID}_getaggedausgang_nachricht FOREIGN KEY (nachricht) REFERENCES postfach_{$PERSONID}_ausgang (id) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT postfach_{$PERSONID}_getaggedausgang_tags FOREIGN KEY (tag) REFERENCES postfach_{$PERSONID}_tags (id) ON DELETE CASCADE ON UPDATE CASCADE;";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_getaggedeingang
ADD CONSTRAINT postfach_{$PERSONID}_getaggedeingang_nachricht FOREIGN KEY (nachricht) REFERENCES postfach_{$PERSONID}_eingang (id) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT postfach_{$PERSONID}_getaggedeingang_tags FOREIGN KEY (tag) REFERENCES postfach_{$PERSONID}_tags (id) ON DELETE CASCADE ON UPDATE CASCADE;";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_getaggedentwuerfe
ADD CONSTRAINT postfach_{$PERSONID}_getaggedentwuerfe_nachricht FOREIGN KEY (nachricht) REFERENCES postfach_{$PERSONID}_entwuerfe (id) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT postfach_{$PERSONID}_getaggedentwuerfe_tags FOREIGN KEY (tag) REFERENCES postfach_{$PERSONID}_tags (id) ON DELETE CASCADE ON UPDATE CASCADE;";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_tags
ADD PRIMARY KEY (id);";
$DBS->anfrage($sql);

$sql = "INSERT INTO postfach_nutzereinstellungen (person, postmail, postalletage, postpapierkorbtage, postspeicherplatz, signatur, emailaktiv, emailadresse, emailname, einganghost, eingangport, eingangnutzer, eingangpasswort, ausganghost, ausgangport, ausgangnutzer, ausgangpasswort) VALUES (?, ['1'], ['365'], ['30'], ['100'], ['0'], [''], [''], [''], [''], [''], [''], [''], [''], [''], [''], ['']);";
$DBS->anfrage($sql, "i", $PERSONID);

// Ordner für das Personenpostfach anlegen
if (is_dir("$ROOT/dateien/personen/$PERSONID/Postfach")) {
  Kern\Dateisystem::ordnerLoeschen("$ROOT/dateien/personen/$PERSONID/Postfach");
}
mkdir("$ROOT/dateien/personen/$PERSONID/Postfach");
mkdir("$ROOT/dateien/personen/$PERSONID/Postfach/temp");
mkdir("$ROOT/dateien/personen/$PERSONID/Postfach/eingang");
mkdir("$ROOT/dateien/personen/$PERSONID/Postfach/ausgang");
mkdir("$ROOT/dateien/personen/$PERSONID/Postfach/entwurf");
mkdir("$ROOT/dateien/personen/$PERSONID/Postfach/papierkorb");
mkdir("$ROOT/dateien/personen/$PERSONID/Postfach/papierkorb/eingang");
mkdir("$ROOT/dateien/personen/$PERSONID/Postfach/papierkorb/ausgang");
mkdir("$ROOT/dateien/personen/$PERSONID/Postfach/papierkorb/entwurf");
?>