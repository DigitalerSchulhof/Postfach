postfach.schulhof.nutzerkonto = {
  aendern: {
    einstellungen: {
      postfach: (id) => {
        var nachricht  = $("#dshProfil"+id+"Nachrichtenmails").getWert();
        var postfach   = $("#dshProfil"+id+"PostfachLoeschfrist").getWert();
        var papierkorb = $("#dshProfil"+id+"PapierkorbLoeschfrist").getWert();
        core.ajax("Postfach", 1, "Postfacheinstellungen ändern", {id:id, nachricht:nachricht, postfach:postfach, papierkorb:papierkorb}, 0);
      },
      email: (id) => {
        var aktiv     = $("#dshProfil"+id+"EmailAktiv").getWert();
        var adresse   = $("#dshProfil"+id+"EmailAdresse").getWert();
        var name      = $("#dshProfil"+id+"EmailName").getWert();
        var ehost     = $("#dshProfil"+id+"EmailEingangHost").getWert();
        var eport     = $("#dshProfil"+id+"EmailEingangPort").getWert();
        var enutzer   = $("#dshProfil"+id+"EmailEingangNutzer").getWert();
        var epasswort = $("#dshProfil"+id+"EmailEingangPasswort").getWert();
        var ahost     = $("#dshProfil"+id+"EmailAusgangHost").getWert();
        var aport     = $("#dshProfil"+id+"EmailAusgangPort").getWert();
        var anutzer   = $("#dshProfil"+id+"EmailAusgangNutzer").getWert();
        var apasswort = $("#dshProfil"+id+"EmailAusgangPasswort").getWert();
        core.ajax("Postfach", 2, "Profileinstellungen ändern", {id:id, aktiv:aktiv, adresse:adresse, name:name, ehost:ehost, eport:eport, enutzer:enutzer, epasswort:epasswort, ahost:ahost, aport:aport, anutzer:anutzer, apasswort:apasswort}, 13);
      }
    }
  }
};
