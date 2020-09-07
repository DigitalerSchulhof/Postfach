var postfach = {
  tags: {
    suchen: (sortieren) => core.ajax("Postfach", 2, null, {...sortieren}),
    daten: (id) => ({
      titel: $("#"+id+"Titel").getWert(),
      farbe: $("#"+id+"Farbe").getWert()
    }),
    neu: {
      fenster:   _ => ui.fenster.laden("Postfach", 3),
      speichern: _ => core.ajax("Postfach", 4, "Neuen Tag erstellen", {...postfach.tags.daten("dshPostfachTagNeu")}, 2, "dshPostfachTags").then((r) => {
        ui.fenster.schliessen("dshPostfachTagNeu");
      })
    },
    bearbeiten: {
      fenster:    (id) => ui.fenster.laden("Postfach", 6, {id:id}),
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