<?php
$sql = "CREATE TABLE postfach_{$PERSONID}_postausgang (
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

$sql = "CREATE TABLE postfach_{$PERSONID}_posteingang (
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

$sql = "CREATE TABLE postfach_{$PERSONID}_postentwurf (
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

$sql = "CREATE TABLE postfach_{$PERSONID}_postgetaggedausgang (
  tag bigint(255) UNSIGNED NOT NULL,
  nachricht bigint(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$DBS->anfrage($sql);

$sql = "CREATE TABLE postfach_{$PERSONID}_postgetaggedeingang (
  tag bigint(255) UNSIGNED NOT NULL,
  nachricht bigint(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$DBS->anfrage($sql);

$sql = "CREATE TABLE postfach_{$PERSONID}_postgetaggedentwurf (
  tag bigint(255) UNSIGNED NOT NULL,
  nachricht bigint(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$DBS->anfrage($sql);

$sql = "CREATE TABLE postfach_{$PERSONID}_posttags (
  id bigint(255) UNSIGNED NOT NULL,
  person bigint(255) UNSIGNED NULL DEFAULT NULL,
  titel varbinary(2000) DEFAULT NULL,
  farbe int(2) NOT NULL DEFAULT 0,
  idvon bigint(255) UNSIGNED DEFAULT NULL,
  idzeit bigint(255) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_postausgang
ADD PRIMARY KEY (id);";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_posteingang
ADD PRIMARY KEY (id);";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_postentwurf
ADD PRIMARY KEY (id);";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_postgetaggedausgang
ADD UNIQUE KEY tag (tag,nachricht),
ADD KEY nachrichtposttaggedausgang_{$PERSONID} (nachricht);";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_postgetaggedeingang
ADD UNIQUE KEY tag (tag,nachricht),
ADD KEY nachrichtposttaggedeingang_{$PERSONID} (nachricht);";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_postgetaggedentwurf
ADD UNIQUE KEY tag (tag,nachricht),
ADD KEY nachrichtposttaggedentwurf_{$PERSONID} (nachricht);";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_posttags
ADD PRIMARY KEY (id);";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_postgetaggedausgang
ADD CONSTRAINT nachrichtposttaggedausgang_{$PERSONID} FOREIGN KEY (nachricht) REFERENCES postfach_{$PERSONID}_postausgang (id) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT tagposttaggedausgang_{$PERSONID} FOREIGN KEY (tag) REFERENCES postfach_{$PERSONID}_posttags (id) ON DELETE CASCADE ON UPDATE CASCADE;";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_postgetaggedeingang_{$PERSONID}
ADD CONSTRAINT nachrichtposttaggedeingang_{$PERSONID} FOREIGN KEY (nachricht) REFERENCES postfach_{$PERSONID}_posteingang (id) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT tagposttaggedeingang_{$PERSONID} FOREIGN KEY (tag) REFERENCES postfach_{$PERSONID}_posttags (id) ON DELETE CASCADE ON UPDATE CASCADE;";
$DBS->anfrage($sql);

$sql = "ALTER TABLE postfach_{$PERSONID}_postgetaggedentwurf_{$PERSONID}
ADD CONSTRAINT nachrichtposttaggedentwurf_{$PERSONID} FOREIGN KEY (nachricht) REFERENCES postfach_{$PERSONID}_postentwurf (id) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT tagposttaggedentwurf_{$PERSONID} FOREIGN KEY (tag) REFERENCES postfach_{$PERSONID}_posttags (id) ON DELETE CASCADE ON UPDATE CASCADE;";
$DBS->anfrage($sql);

$sql = "INSERT INTO postfach_nutzereinstellungen (person, postmail, postalletage, postpapierkorbtage, signatur, emailaktiv, emailadresse, emailname, einganghost, eingangport, eingangnutzer, eingangpasswort, ausganghost, ausgangport, ausgangnutzer, ausgangpasswort) VALUES (?, ['1'], ['365'], ['30'], ['0'], [''], [''], [''], [''], [''], [''], [''], [''], [''], [''], ['']);";
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