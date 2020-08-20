<?php
$sql = "CREATE TABLE postfach_postausgang_{$PERSONID} (
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

$sql = "CREATE TABLE postfach_posteingang_{$PERSONID} (
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

$sql = "CREATE TABLE postfach_postentwurf_{$PERSONID} (
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

$sql = "CREATE TABLE postfach_postgetaggedausgang_{$PERSONID} (
	tag bigint(255) UNSIGNED NOT NULL,
	nachricht bigint(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$DBP->anfrage($sql);

$sql = "CREATE TABLE postfach_postgetaggedeingang_{$PERSONID} (
	tag bigint(255) UNSIGNED NOT NULL,
	nachricht bigint(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$DBP->anfrage($sql);

$sql = "CREATE TABLE postfach_postgetaggedentwurf_{$PERSONID} (
	tag bigint(255) UNSIGNED NOT NULL,
	nachricht bigint(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$DBP->anfrage($sql);

$sql = "CREATE TABLE postfach_posttags_{$PERSONID} (
	id bigint(255) UNSIGNED NOT NULL,
	person bigint(255) UNSIGNED NULL DEFAULT NULL,
	titel varbinary(2000) DEFAULT NULL,
	farbe int(2) NOT NULL DEFAULT 0,
	idvon bigint(255) UNSIGNED DEFAULT NULL,
	idzeit bigint(255) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
$DBP->anfrage($sql);

$sql = "ALTER TABLE postfach_postausgang_{$PERSONID}
ADD PRIMARY KEY (id);";
$DBP->anfrage($sql);

$sql = "ALTER TABLE postfach_posteingang_{$PERSONID}
ADD PRIMARY KEY (id);";
$DBP->anfrage($sql);

$sql = "ALTER TABLE postfach_postentwurf_{$PERSONID}
ADD PRIMARY KEY (id);";
$DBP->anfrage($sql);

$sql = "ALTER TABLE postfach_postgetaggedausgang_{$PERSONID}
ADD UNIQUE KEY tag (tag,nachricht),
ADD KEY nachrichtposttaggedausgang_{$PERSONID} (nachricht);";
$DBP->anfrage($sql);

$sql = "ALTER TABLE postfach_postgetaggedeingang_{$PERSONID}
ADD UNIQUE KEY tag (tag,nachricht),
ADD KEY nachrichtposttaggedeingang_{$PERSONID} (nachricht);";
$DBP->anfrage($sql);

$sql = "ALTER TABLE postfach_postgetaggedentwurf_{$PERSONID}
ADD UNIQUE KEY tag (tag,nachricht),
ADD KEY nachrichtposttaggedentwurf_{$PERSONID} (nachricht);";
$DBP->anfrage($sql);

$sql = "ALTER TABLE postfach_posttags_{$PERSONID}
ADD PRIMARY KEY (id);";
$DBP->anfrage($sql);

$sql = "ALTER TABLE postfach_postgetaggedausgang_{$PERSONID}
ADD CONSTRAINT nachrichtposttaggedausgang_{$PERSONID} FOREIGN KEY (nachricht) REFERENCES postausgang_{$PERSONID} (id) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT tagposttaggedausgang_{$PERSONID} FOREIGN KEY (tag) REFERENCES posttags_{$PERSONID} (id) ON DELETE CASCADE ON UPDATE CASCADE;";
$DBP->anfrage($sql);

$sql = "ALTER TABLE postfach_postgetaggedeingang_{$PERSONID}
ADD CONSTRAINT nachrichtposttaggedeingang_{$PERSONID} FOREIGN KEY (nachricht) REFERENCES posteingang_{$PERSONID} (id) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT tagposttaggedeingang_{$PERSONID} FOREIGN KEY (tag) REFERENCES posttags_{$PERSONID} (id) ON DELETE CASCADE ON UPDATE CASCADE;";
$DBP->anfrage($sql);

$sql = "ALTER TABLE postfach_postgetaggedentwurf_{$PERSONID}
ADD CONSTRAINT nachrichtposttaggedentwurf_{$PERSONID} FOREIGN KEY (nachricht) REFERENCES postentwurf_{$PERSONID} (id) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT tagposttaggedentwurf_{$PERSONID} FOREIGN KEY (tag) REFERENCES posttags_{$PERSONID} (id) ON DELETE CASCADE ON UPDATE CASCADE;";
$DBP->anfrage($sql);

$sql = "INSERT INTO postfach_personen_signaturen (person, signatur) VALUES (?, AES_ENCRYPT('', '$CMS_SCHLUESSEL'))";
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