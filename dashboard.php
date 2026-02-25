<!DOCTYPE html>
<html>
<head>
  <title>Plant Analyzer Dashboard</title>
  <meta http-equiv="refresh" content="5">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f8f5;
      text-align: center;
      margin-top: 40px;
    }
    .card {
      display: inline-block;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      margin: 10px;
      width: 260px;
    }
    h2 { color: #2b7a3d; }
    .value { font-size: 28px; font-weight: bold; }
  </style>
</head>
<body>
  <h1>🌿 Plant Analyzer Dashboard</h1>
  <div id="content">Loading...</div>

  <script>
    async function loadData() {
      const res = await fetch('latest_data.json');
      const data = await res.json();

      document.getElementById("content").innerHTML = `
        <div class="card"><h2>Device</h2><div class="value">${data.deviceID}</div></div>
        <div class="card"><h2>Temperature</h2><div class="value">${data.temperature} °C</div></div>
        <div class="card"><h2>Humidity</h2><div class="value">${data.humidity} %</div></div>
        <div class="card"><h2>Soil Value</h2><div class="value">${data.soilValue}</div></div>
        <div class="card"><h2>Light</h2><div class="value">${data.lightStatus}</div></div>
        <div class="card"><h2>Relay</h2><div class="value">${data.relay}</div></div>
        <div class="card"><h2>Signal</h2><div class="value">${data.signalStrength} dBm</div></div>
        <div class="card"><h2>Uptime</h2><div class="value">${data.uptime_sec} sec</div></div>
      `;
    }

    loadData();
    setInterval(loadData, 5000);
  </script>
</body>
</html>
