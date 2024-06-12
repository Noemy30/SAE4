document.addEventListener("DOMContentLoaded", (event) => {
  const today = new Date().toISOString().split("T")[0];
  document.querySelector("#horaire").setAttribute("min", today);

  document
    .querySelector("#ajoutTournoi")
    .addEventListener("submit", function (event) {
      const joueurs_necessaires = document.querySelector(
        "#joueurs_necessaires"
      ).value;
      const places_disponibles = document.querySelector(
        "#places_disponibles"
      ).value;
      const horaire = document.querySelector("#horaire").value;
      let isValid = true;
      let errorMessage = "";

      if (new Date(horaire) < new Date()) {
        isValid = false;
        errorMessage +=
          "La date et l'heure doivent être égales ou supérieures à la date actuelle.\n";
      }

      if (joueurs_necessaires <= 5) {
        isValid = false;
        errorMessage +=
          "Le nombre de joueurs nécessaires doit être supérieur à 5.\n";
      }

      if (!/^\d+$/.test(places_disponibles)) {
        isValid = false;
        errorMessage += "Les places disponibles doivent être un nombre.\n";
      }

      if (!isValid) {
        event.preventDefault();
        alert(errorMessage);
      }
    });
});
