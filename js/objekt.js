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
    }
  }
};

postfach.schulhof = {};