const canvas = document.getElementById('revenueChart');

if (canvas) {
    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Revenue',
                data: [1200, 1900, 3000, 2500, 3200, 4000],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {

    const toggleBtn = document.getElementById("toggleBtn");
    const sidebar = document.getElementById("sidebar");
    const fullscreenBtn = document.getElementById("fullscreenBtn");

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener("click", function () {
            if (window.innerWidth >= 992) {
                sidebar.classList.toggle("collapsed");
            } else {
                sidebar.classList.toggle("active");
            }
        });
    }

    if (fullscreenBtn) {
        fullscreenBtn.addEventListener("click", function () {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        });
    }

});

