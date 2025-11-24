// === Konfigurasi Global ===
const CONFIG = {
  fontFamily: "'Poppins', sans-serif"
};

// === 1. Efek Ripple Tombol ===
document.querySelectorAll("button, a.button").forEach(btn => {
  btn.addEventListener("click", function(e) {
    this.style.transform = "scale(0.95)";
    setTimeout(() => {
      this.style.transform = "";
    }, 150);
  });
});

// === 2. Flash Message Fade Out ===
const flash = document.querySelector(".flash");
if (flash) {
  setTimeout(() => {
    flash.style.opacity = "0";
    flash.style.transform = "translateY(-10px)";
    flash.style.transition = "all 0.5s ease";
    setTimeout(() => flash.remove(), 500); 
  }, 3500);
}

// === 3. Chart.js (Grafik Canvas Utama) ===
// Hanya dijalankan jika ada elemen dengan ID voteChart
window.addEventListener("load", () => {
  const chartCanvas = document.getElementById("voteChart");
  if (!chartCanvas) return;

  chartCanvas.style.opacity = "0";
  setTimeout(() => {
    chartCanvas.style.transition = "opacity 1s ease";
    chartCanvas.style.opacity = "1";
  }, 200);

  let labels = [], data = [];
  try {
    labels = JSON.parse(chartCanvas.dataset.labels || "[]");
    data = JSON.parse(chartCanvas.dataset.data || "[]");
  } catch (e) {
    console.error("Error parsing chart data"); return;
  }

  const initChart = () => {
    if (typeof Chart === "undefined") return;

    if (chartCanvas._chartInstance) {
      chartCanvas._chartInstance.destroy();
    }

    const ctx = chartCanvas.getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(143, 148, 251, 1)'); 
    gradient.addColorStop(1, 'rgba(78, 84, 200, 0.8)'); 

    const chart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels,
        datasets: [{
          label: "Perolehan Suara",
          data: data,
          backgroundColor: gradient,
          borderRadius: 8,
          borderSkipped: false,
          barThickness: 50,
          maxBarThickness: 70
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: { duration: 1500, easing: 'easeOutQuart' },
        plugins: {
          legend: { display: false },
          title: {
            display: true,
            text: "Statistik Real-Time",
            font: { size: 18, family: CONFIG.fontFamily, weight: '600' },
            color: '#333',
            padding: { bottom: 20 }
          },
        },
        scales: {
          x: { grid: { display: false }, ticks: { color: '#636e72' } },
          y: { beginAtZero: true, grid: { borderDash: [5, 5] }, ticks: { stepSize: 1, color: '#636e72' } }
        }
      }
    });
    chartCanvas._chartInstance = chart;
  };

  if (typeof Chart !== "undefined") {
    initChart();
  } else {
    let attempts = 0;
    const interval = setInterval(() => {
      attempts++;
      if (typeof Chart !== "undefined") {
        clearInterval(interval);
        initChart();
      } else if (attempts > 20) { clearInterval(interval); }
    }, 100);
  }
});