<div class="item">
    <h6 class="sub-title">Estado De Verticales</h6>
    <img class="scoring-4"
        src='https://quickchart.io/chart?c={
            type: "radar",
            data: {
                labels: ["Producto o servicio", "Comercial y de mercardo", "Financiero", "Equipo de trabajo"],

                datasets: [{
                    label: "Vertices",
                    backgroundColor: "transparent",
                    borderColor: "rgba(97, 69, 227, 1)",
                    fill: false,
                    radius: 6,
                    pointRadius: 6,
                    pointBorderWidth: 3,
                    pointBackgroundColor: "rgba(97, 69, 227, 0.5)",
                    pointBorderColor: "rgba(97, 69, 227, 1)",
                    pointHoverRadius: 10,
                    data: [
                        {{ $calculate['score_group_65'] }},
                        {{ $calculate['score_group_66'] }},
                        {{ $calculate['score_group_67'] }},
                        {{ $calculate['score_group_68'] }}
                    ]
                }]
            },
            options: {
                legend: {
                    position: "top",
                    labels: {
                        usePointStyle: true,
                        fontSize: 12,
                        padding: 30,
                        boxWidth: 15
                    }
                },
                scale: {
                    ticks: {
                        beginAtZero: true
                    },
                    pointLabels: {
                        fontSize: 12
                    },
                    grid: {
                        color: "black"
                    },
                    angleLines: {
                        color: "black"
                    },
                }
            }
        }'
        alt="scoring_colaborativa">
</div>

