@component(head)
<body>
  <div id="panel-view" class="view-container" >
    <div class="panel-wrapper">
      <div class="panel-header">
        <h2 class="panel-title">{{ APP_NAME }}</h2>
      </div>
      <div id="list-estacion" class="stations-grid">
        <!-- Las estaciones se cargarán dinámicamente aquí -->
      </div>
    </div>
  </div>
    <template id="tpl-btn-estacion">
      <a class="btn-estacion">
        <div class="estacion-apodo"></div>
        <div class="estacion-ubicacion"></div>
        <div class="estacion-visitas"></div>
      </a>
    </template>
  <script src="views/assets/js/index.js"></script>
</body>
</html>
