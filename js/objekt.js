var postfach = {
  tags: {
    laden: (sortieren) => {
      return core.ajax("Postfach", 2, null, {...sortieren});
    },
    neu: {
      laden: () => {
        ui.fenster.laden("Postfach", 3, null, null, null, null);
      },
      erstellen: () => {
        var titel = $("#dshPostfachNeuerTagTitel").getWert();
        var farbe = $("#dshPostfachNeuerTagFarbe").getWert();
        core.ajax("Postfach", 4, "Neuen Tag erstellen", {titel:titel, farbe:farbe}, 2, "dshPostfachTags");
      }
    },
    bearbeiten: {
      laden: (id) => {
        ui.fenster.laden("Postfach", 3, null, {id:id}, null, null);
      },
      ausfuehren: (id) => {
        var titel = $("#dshPostfachTag"+id+"Titel").getWert();
        var farbe = $("#dshPostfachTag"+id+"Farbe").getWert();
        core.ajax("Postfach", 6, "Tag bearbeiten", {id:id, titel:titel, farbe:farbe}, 5, "dshPostfachTags");
      }
    },
    loeschen: {
      fragen: (id) => ui.laden.meldung("Postfach", 3, "Tag löschen", {id:id}),
      ausfuehren: (id) => {
        core.ajax("Postfach", 5, "Tag löschen", {id:id}, 4, "dshPostfachTags");
      }
    }
  }
};

postfach.schulhof = {};