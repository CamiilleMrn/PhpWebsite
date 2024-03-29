let ctx = document.getElementById('myChart').getContext('2d');
let labels = ['Match gagnés', 'Match perdus'];
let colorHex = ['#0B0633', 'yellow'];

var matchPerdus = document.getElementById('myDiv').getAttribute('data-my-var');
var matchGagnes = document.getElementById('myDiv1').getAttribute('data-my-var1');

let myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        datasets: [{
            data: [matchGagnes, matchPerdus],
            backgroundColor: colorHex
        }],
        labels: labels
    },
    options: {
        responsive: true,
        legend: {
            position: 'top'
        },
        plugins: {
            datalabels: {
                color: '#fff',
                anchor: 'end',
                align: 'start',
                offset: -10,
                borderWidth: 2,
                borderColor: '#fff',
                borderRadius: 25,
                backgroundColor: (context) => {
                    return context.dataset.backgroundColor;
                },
                font: {
                    weight: 'bold',
                    size: '10'
                },
                formatter: (value) => {
                    return value + ' %';
                }
            }
        }
    }
})