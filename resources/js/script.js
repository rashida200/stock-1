// Enhanced Sidebar Toggle with Backdrop
import Chart from 'chart.js/auto';
const sidebar = document.getElementById("sidebar");
const backdrop = document.getElementById("sidebarBackdrop");
const sidebarToggle = document.getElementById("sidebarToggle");

function toggleSidebar() {
    sidebar.classList.toggle("show");
    backdrop.classList.toggle("show");
}

sidebarToggle.addEventListener("click", toggleSidebar);
backdrop.addEventListener("click", toggleSidebar);

// Responsive Chart
function createResponsiveChart() {
    const ctx = document.getElementById("salesChart").getContext("2d");
    const salesChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
            datasets: [
                {
                    label: "Sales (MAD)",
                    data: [500, 1500, 1300, 1700, 1800, 300],
                    borderColor: "rgb(75, 192, 192)",
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    tension: 0.1,
                    fill: true,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "top",
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                    },
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return `MAD ${tooltipItem.raw.toLocaleString()}`;
                        },
                    },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                    },
                    ticks: {
                        stepSize: 1000, // Custom step size
                        callback: function (value) {
                            return "MAD " + value.toLocaleString();
                        },
                    },
                },
                x: {
                    grid: {
                        display: false,
                    },
                },
            },
            interaction: {
                intersect: false,
                mode: "index",
            },
        },
    });

    // Cleanup on resize
    return function cleanup() {
        salesChart.destroy();
    };
}

// Initial chart creation
let cleanup = createResponsiveChart();

// Recreate chart on window resize
let resizeTimer;
window.addEventListener("resize", function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
        cleanup();
        cleanup = createResponsiveChart();
    }, 250);
});



