var postfach = {
  tags: {
    suchen: (sortieren) => core.ajax("Postfach", 2, null, {...sortieren}),
    daten: (id) => ({
      titel: $("#"+id+"Titel").getWert(),
      farbe: $("#"+id+"Farbe").getWert()
    }),
    neu: {
      fenster:   () => ui.fenster.laden("Postfach", 3, null, null, null, null),
      speichern: () => core.ajax("Postfach", 4, "Neuen Tag erstellen", {...postfach.tags.daten("dshPostfachTagNeu")}, 2, "dshPostfachTags").then((r) => {
        ui.fenster.schliessen("dshPostfachTagNeu");
      })
    },
    bearbeiten: {
      fenster:    (id) => ui.fenster.laden("Postfach", 6, null, {id:id}, null, null),
      speichern: (id) => core.ajax("Postfach", 7, "Tag bearbeiten", {id:id, ...postfach.tags.daten("dshPostfachTag"+id)}, 5, "dshPostfachTags").then((r) => {
        ui.fenster.schliessen("dshPostfachTag"+id);
      })
    },
    loeschen: {
      fragen:     (id) => ui.laden.meldung("Postfach", 3, "Tag löschen", {id:id}),
      ausfuehren: (id) => core.ajax("Postfach", 5, "Tag löschen", {id:id}, 4, "dshPostfachTags")
    }
  }
};

postfach.schulhof = {};