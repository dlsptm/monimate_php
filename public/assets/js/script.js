const url = window.location.href;
const segments = url.split('/');
const lastSegment = segments.pop();
const id = !isNaN(lastSegment) ? lastSegment : null;


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


const setPropertyArray = [
  {
      key : '--black',
      color1 : '#0B0B0B',
      color2 : '#F8F8F8'
  },
  {
      key : '--white',
      color1 : '#F8F8F8',
      color2 : '#0B0B0B'
  },
  {
      key : '--darkbg',
      color1 : '#090E26',
      color2 : '#f5f5f5'
  },
  {
      key : '--lighterbg',
      color1 : '#181D39',
      color2 : '#f4f4f4'
  },
  {
      key : '--darkerbg',
      color1 : '#f4f4f4',
      color2 : '#181D39'
  }
];

const switchBtn = document.getElementById('switchBtn');

// document.addEventListener("DOMContentLoaded", function () {
//   fetch("index?p=api/getMode")
//     .then((response) => {
//       if (!response.ok) {
//         throw new Error("Erreur lors de la récupération des données");
//       }
//       return response.json();
//     })
//     .then((data) => {
//       console.log(blackTexts);

//       setPropertyArray.forEach((property) => {
//         if (data.dark_light_mode == 0) {
//           document.documentElement.style.setProperty(property.key, property.color1);

//           blackTexts.forEach(blackText => {
            
//             blackText.replace('text-black', 'text-white');
//           })
//         } else {
//           document.documentElement.style.setProperty(property.key, property.color2);
//           blackTexts.forEach(blackText => {
//             blackText.replace('text-white', 'text-black');
//           })
//         }
//       });

//       switchBtn.addEventListener('click', () => {
//         // Boucle à travers le tableau setPropertyArray pour trouver la propriété correspondante
//         setPropertyArray.forEach((property) => {
//           if (data.dark_light_mode == 0) {
//             document.documentElement.style.setProperty(property.key, property.color2);
//           } else {
//             document.documentElement.style.setProperty(property.key, property.color1);
//           }
//         });
//       });
//     })
//     .catch((error) => {
//       console.error("Erreur :", error);
//     });
// });