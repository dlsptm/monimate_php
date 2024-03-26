const url = window.location.href;
const segments = url.split('/');
const lastSegment = segments.pop();
const id = !isNaN(lastSegment) ? lastSegment : null;

console.log(id);

document.addEventListener("DOMContentLoaded", function () {

  let fetchURL = "index?p=api/getIncomes";
  if (id !== null) {
    fetchURL += '/' + id;
  }


  fetch(fetchURL)

    .then((response) => {
      if (!response.ok) {
        throw new Error("Erreur lors de la récupération des données");
      }
      return response.json();
    })
    .then((data) => {
      console.log(data);
      var labels = [];
      var amounts = [];

      // Parcourir les données des revenus et extraire les titres et les montants
      data.forEach((json_incomes) => {
        labels.push(json_incomes.title.replace("&#039;", "'"));
        amounts.push(json_incomes.amount);
      });

      // Créer un nouveau graphique Chart.js
      const ctx = document.getElementById("myChart").getContext("2d");

      const myChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: labels,
          datasets: [{
            label: "Montant", // Définir un label significatif pour le dataset
            data: amounts,
            backgroundColor: [
              "#CF3888",
              "#FFC759",
              "#5FD597",
              "#5430B1",
              "#DE7332",
            ],
            borderColor: [
              "#CF3888",
              "#FFC759",
              "#5FD597",
              "#5430B1",
              "#DE7332",
            ],
            borderWidth: 1,
          }, ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              display: false, // Masquer l'axe y (scale) à gauche du graphique
            },
          },
          plugins: {
            legend: {
              display: false
            }
          },
          animation: {
            y: {
              type: 'number', // Spécifie l'animation basée sur les valeurs numériques
              duration: 1000, // Durée de l'animation en millisecondes
              easing: 'easeInOutQuad', // Fonction d'animation (facultatif)
            }
          }
        }        
        
      });
    })
    .catch((error) => {
      console.error("Erreur :", error);
    });
});
