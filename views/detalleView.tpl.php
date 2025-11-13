@component(head)
<body>
  <div id="detalle-view" class="view-container">
    <div class="detalle-wrapper">
      <button onclick="window.location.href='?slug=panel'" class="btn-back">
        ← Volver
      </button>

      <div class="detalle-content">
        <h2 id="detalle-apodo" class="detalle-title"></h2>
        <div class="grafico-container">
          <canvas id="myChart"></canvas>
        </div>

        <div class="detalle-ubicacion">
          <img src="views/assets/img/place.svg">
          <span id="detalle-ubicacion-text"></span>
          <div id="controls">
            <div id="temp" class="ala">
              <div id="temp-int" class="ala-int">00</div>
              <div id="temp-col">
                <div id="temp-unit">ºC</div>
                <div id="temp-dec">.00</div>
              </div>
            </div>
            <div id="hume" class="ala">
              <div id="hume-int" class="ala-int">00</div>
              <div id="hume-col">
                <div id="hume-unit">%</div>
                <div id="hume-dec">.00</div>
              </div>
            </div>
            <div id="vien" class="ala">
              <div id="vien-int" class="ala-int">00</div>
              <div id="vien-col">
                <div id="vien-unit">m/s</div>
                <div id="vien-dec">.00</div>
              </div>
            </div>
            <div id="ince" class="ala">
              <div id="ince-int" class="ala-int">00</div>
              <div id="ince-col">
                <div id="ince-unit">MJ/m²</div>
                <div id="ince-dec">.00</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="views/assets/js/detalle.js"></script>
</body>
</html>
