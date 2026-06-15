const ctx = document.getElementById("statusChart");

const chartInstance = new Chart(ctx, {
  type: "bar",
  data: {
    labels: ["Parado", "Manutenção", "Ativos"],
    datasets: [
      {
        label: "Quantidade",
        data: [5, 15, 28],
        backgroundColor: ["#E5533D", "#E8B931", "#3DB7E4"],
        borderRadius: 4,
        barThickness: 35,
      },
    ],
  },
  options: {
    indexAxis: "y",
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false },
      title: {
        display: true,
        text: "Situação",
        align: "start",
        color: "#ffffff",
        font: { size: 14, weight: "500" },
        padding: { bottom: 12 },
      },
    },
    scales: {
      x: {
        title: {
          display: true,
          text: "Quantidade",
          color: "#ffffff",
          font: { size: 12 },
        },
        ticks: { color: "#ffffff" },
        grid: {
          color: "rgba(255,255,255,0.1)",
          borderDash: [4, 4],
        },
      },
      y: {
        ticks: { color: "#ffffff" },
        grid: { display: false },
      },
    },
  },
});

async function fetchFromAPI() {
  try {
    const res = await fetch("http://localhost:3000/dados");
    const data = await res.json();
    updateChartData(data);
  } catch (err) {
    console.error("Erro ao buscar dados:", err);
  }
}
fetchFromAPI();
setInterval(fetchFromAPI, 5000);
