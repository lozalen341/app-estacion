@component(head)
<body>
  <div id="detalle-view" class="view-container">
    <div class="detalle-wrapper">
      <button onclick="window.location.href='?slug=panel'" class="btn-back">
        ← Volver
      </button>
      
      <div class="detalle-content">
        <h2 id="detalle-apodo" class="detalle-title"></h2>
        <div class="detalle-ubicacion">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
          <span id="detalle-ubicacion-text"></span>
        </div>
      </div>
    </div>
  </div>
  <script>
document.addEventListener("DOMContentLoaded", async () => {
  // Tomamos el chipid de la URL (?chipid=XXXX)
  const params=new URLSearchParams(window.location.search)
  const chipid=params.get("chipid")

  if(!chipid){
    document.getElementById("detalle-apodo").textContent="Error"
    document.getElementById("detalle-ubicacion-text").textContent="No se recibió chipid"
    return
  }

  // Pedimos el JSON
  const response=await fetch('datos.php')
  const estaciones=await response.json()

  // Buscamos la estación que coincida
  const estacion=estaciones.find(e=>e.chipid===chipid)

  if(estacion){
    document.getElementById("detalle-apodo").textContent=estacion.apodo
    document.getElementById("detalle-ubicacion-text").textContent=estacion.ubicacion
  }else{
    document.getElementById("detalle-apodo").textContent="No encontrada"
    document.getElementById("detalle-ubicacion-text").textContent=""
  }
})
</script>

</body>
</html>