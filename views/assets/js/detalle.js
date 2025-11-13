let chipid = "";
let fec=[], tem=[], hum=[], vie=[], fwi=[], pre=[];
const MAX_DATOS=7;
const INTERVAL_REFRESH=60000;
let dataJsonActual="";
let sectionVisible="temperatura";
let myChart=null;

let btnControls=[
  ["temperatura",'<i class="fas fa-thermometer-full color-temperatura"></i>'],
  ["fuego",'<i class="fas fa-fire color-fuego"></i>'],
  ["humedad",'<i class="fas fa-tint color-humedad"></i>'],
  ["viento",'<i class="fas fa-wind color-viento"></i>'],
  ["presion",'<i class="fas fa-arrow-circle-down color-presion"></i>']
];

document.addEventListener("DOMContentLoaded", async ()=>{
  const params=new URLSearchParams(window.location.search);
  chipid=params.get("chipid");

  if(!chipid){
    document.getElementById("detalle-apodo").textContent="Error";
    document.getElementById("detalle-ubicacion-text").textContent="No se recibió chipid";
    return;
  }

  console.log("Web cargada para el chipid:",chipid);

  // Mostrar nombre de la estación desde datos.php
  await obtenerNombreEstacion();

  // Registrar visita y obtener datos iniciales
  await addVisitStation();
  await refreshDatos(MAX_DATOS);

  // Actualización periódica de datos
  setInterval(()=>refreshDatos(1),INTERVAL_REFRESH);

  // Mostrar por defecto la pestaña "temperatura"
  btnControls.forEach(btn=>{
    const cont=document.querySelector("#panel-container-"+btn[0]);
    if(btn[0]==="temperatura"){
      sectionVisible=btn[0];
      if(document.querySelector("#title-sub")){
        document.querySelector("#title-sub").innerHTML=btn[1]+"&nbsp;"+btn[0].toUpperCase();
      }
      if(cont) cont.style.display="grid";
    }else{
      if(cont) cont.style.display="none";
    }
  });

  // Configurar botones
  btnControls.forEach(btn=>{
    const boton=document.querySelector("#btn-"+btn[0]);
    if(!boton) return;
    boton.addEventListener("click",e=>{
      e.preventDefault();
      sectionVisible=btn[0];
      btnControls.forEach(b=>{
        const c=document.querySelector("#panel-container-"+b[0]);
        if(c) c.style.display=(b[0]===btn[0])?"grid":"none";
      });
      procesar(dataJsonActual,false);
    });
  });
});

// ================================
// FETCHS
// ================================

// Obtiene el nombre y ubicación desde datos.php
async function obtenerNombreEstacion(){
  try{
    const res=await fetch("datos.php");
    const estaciones=await res.json();

    const estacion=estaciones.find(e=>e.chipid==chipid);
    if(estacion){
      document.getElementById("detalle-apodo").textContent=estacion.apodo||"Sin nombre";
      document.getElementById("detalle-ubicacion-text").textContent=estacion.ubicacion||"";
    }else{
      document.getElementById("detalle-apodo").textContent="No encontrada";
      document.getElementById("detalle-ubicacion-text").textContent="";
    }
  }catch(e){
    console.error("Error al obtener nombre de estación:",e);
  }
}

// Incrementa visitas
async function addVisitStation(){
  try{
    const res=await fetch(`datosDetalle.php?chipid=${chipid}&mode=visit-station`);
    const data=await res.json();
    console.log("Visita registrada:",data);
  }catch(e){
    console.error("Error al registrar visita:",e);
  }
}

// Trae datos meteorológicos
async function refreshDatos(cantfilas){
  try{
    const res=await fetch(`datosDetalle.php?chipid=${chipid}&cant=${cantfilas}`);
    const data=await res.json();
    dataJsonActual=data;
    procesar(data);
  }catch(e){
    console.error("Error al obtener datos:",e);
  }
}

// ================================
// PROCESAMIENTO DE DATOS
// ================================
function procesar(datos,addData=true){
  if(!datos||!datos.length) return;
  const d=datos[0];

  const [tempInt,tempDec="00"]=d.temperatura.split(".");
  document.getElementById("temp-int").textContent=tempInt;
  document.getElementById("temp-dec").textContent="."+tempDec;

  const [humInt,humDec="00"]=d.humedad.split(".");
  document.getElementById("hume-int").textContent=humInt;
  document.getElementById("hume-dec").textContent="."+humDec;

  const [vieInt,vieDec="00"]=d.viento.split(".");
  document.getElementById("vien-int").textContent=vieInt;
  document.getElementById("vien-dec").textContent="."+vieDec;

  document.getElementById("ince-int").textContent=d.fwi;
  document.getElementById("ince-dec").textContent="";

  if(addData){
    const hora=d.fecha.split(" ")[1].slice(0,5);
    fec.push(hora);
    tem.push(d.temperatura);
    hum.push(d.humedad);
    vie.push(d.viento);
    fwi.push(d.fwi);
    pre.push(d.presion);

    if(fec.length>MAX_DATOS){
      [fec,tem,hum,vie,fwi,pre].forEach(arr=>arr.shift());
    }
  }

  let itemsGrafico=[];
  switch(sectionVisible){
    case "temperatura": itemsGrafico=[{label:"Temperatura",borderColor:"#ffbf69",data:tem}]; break;
    case "humedad": itemsGrafico=[{label:"Humedad",borderColor:"#00bbf9",data:hum}]; break;
    case "viento": itemsGrafico=[{label:"Viento",borderColor:"#e0fbfc",data:vie}]; break;
    case "presion": itemsGrafico=[{label:"Presion",borderColor:"#6ee55d",data:pre}]; break;
    default: itemsGrafico=[{label:"FWI",borderColor:"#ec512b",data:fwi}];
  }

  renderCharts(d.ubicacion,fec,itemsGrafico);
}

// ================================
// RENDER DE GRÁFICO
// ================================
function renderCharts(estacion, fecha, itemsGrafico){
  const canvas=document.querySelector("#myChart");
  if(!canvas){
    console.warn("No hay canvas #myChart en el DOM, se omite renderizado del gráfico.");
    return;
  }
  if(myChart) myChart.destroy();
  const ctx=canvas.getContext("2d");
  myChart=new Chart(ctx,{
    type:"line",
    data:{labels:fecha,datasets:itemsGrafico},
    options:{
      scales:{
        yAxes:[{ticks:{beginAtZero:true,fontColor:"white"}}],
        xAxes:[{ticks:{fontColor:"white"}}]
      },
      legend:{display:false},
      elements:{line:{borderWidth:2,fill:false},point:{radius:6,borderWidth:4,backgroundColor:"white"}},
      responsive:true,
      maintainAspectRatio:false,
      animation:{duration:0}
    }
  });
}

// ================================
// FUNCIÓN DE PELIGRO DE INCENDIO
// ================================
function fireDanger(fwi){
  const f=parseFloat(fwi);
  if(f>=50) return "Extremo";
  if(f>=38) return "Muy alto";
  if(f>=21.3) return "Alto";
  if(f>=11.2) return "Moderado";
  if(f>=5.2) return "Bajo";
  return "Muy bajo";
}
