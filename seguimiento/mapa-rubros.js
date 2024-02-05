
// Definir el mapas
let map = L.map('map', {
    fullscreenControl: true,
    fullscreenControlOptions:
        { position: 'topright' }
}).setView([-31.95528, -57.97186], 8);

// Referencias
const sidebar = document.querySelector('#sidebar');
const alert = document.querySelector('#alert');

// Agregados al mapa
new L.control.mousePosition({ position: 'topright' }).addTo(map);
new L.control.scale({ imperial: true }).addTo(map);

// Cuadro de Informacion
var info = new L.control({ position: 'bottomleft' });

// Crear un div con una clase info
info.onAdd = function () {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
};

// Agregar leyenda
info.update = function (props) {
    this._div.innerHTML = '<h6>Créditos MyPYME - Categorias productivas</h6>';
    //let path = APP_URL + "/public/mapas/libreria/isologoER_Gob.png"
    //this._div.innerHTML += '<img class=" img-thumbnail" src=' + path + ' alt="Ministerio">';
    this._div.innerHTML += '<h4>Ministerio de Desarrollo Económico - Entre Ríos</h4>';
};
info.addTo(map);


//Crear listado de lugares
const volar = (lugar) => {
    const zoom = (lugar.nombre == 'Todos') ? 8 : 12;
    map.flyTo(lugar.coordenadas, zoom)
}

// Primero limpiar el Active de cada item
const limpiarItems = () => {
    const listadoLi = document.querySelectorAll('li');
    listadoLi.forEach(li => {
        li.classList.remove('active');
    })
}

// Crear el listado
const crearListado = () => {
    const ul = document.createElement('ul');
    ul.classList.add('list-group');
    ul.classList.add('mt-4');
    sidebar.prepend(ul);

    const li = document.createElement('li');
    li.innerText = 'Seleccione un departamento';
    li.classList.add('list-group-item');
    ul.append(li);
    li.classList.add('text-center');
    li.classList.add('bg-warning');

    departamentos.forEach(lugar => {
        const li = document.createElement('li');
        li.innerText = lugar.nombre;
        li.classList.add('list-group-item');
        ul.append(li);

        li.addEventListener('click', () => {
            limpiarItems();
            li.classList.add('active');
            volar(lugar);
        })
    })
}

crearListado();

// Crear el mapa
let politico = L.tileLayer('https://wms.ign.gob.ar/geoserver/gwc/service/tms/1.0.0/capabaseargenmap@EPSG%3A3857@png/{z}/{x}/{-y}.png',
    {
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">IGN Argentina - Secretaria Desarrollo Productivo E.R.</a>'
    });
let streetView = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap - Secretaria Desarrollo Productivo E.R. </a>'
    });

// Funcion de Mayuscula primer letra 
const capitalize = (t) => { return t[0].toUpperCase() + t.substr(1).toLowerCase() };

const padLeft = (number, digits) => { return Array(Math.max(digits - String(number).length + 1, 0)).join(0) + number; }

const baseMaps = [
    {
        groupName: "Capas mapas",
        expanded: true,
        layers: {
            " Politico": politico,
            " StreetView": streetView,
        }
    },
];

const overlays = [
    {
        groupName: "Categorias",
        expanded: true,
        layers: {}

    }, {
        groupName: "Estados",
        expanded: true,
        layers: {}
    }
];

const options = {
    collapsed: false,
    container_width: "300px",
    container_maxHeight: "3000px",
    group_maxHeight: "700px",
    exclusive: false
};

politico.addTo(map);
let layerControl = L.Control.styledLayerControl(baseMaps, overlays, options).addTo(map);

// Definir marcadores por cada categoria - Tipo_Categoria
let mapRubros = () => {

    // Obtener valor año 
    const anio = Number(document.getElementById('anio').value)

    // Filtrar los expedientes x año
    let expedientesFiltrados = [];

    // Quitar capa
    layerControl.removeGroup("Categorias");

    if (anio > 0) {
        expedientesFiltrados = expedientes.filter((expediente) => {
            return expediente.anio == anio;
        });
    } else {
        expedientesFiltrados = expedientes
    }

    let index = -1

    rubros.forEach(rubro => {

        index++
        capaCategoria = L.layerGroup();

        let id_rubro = rubro.id_rubro
        let color = '#' + colores[index].hex

        expedientesFiltrados.forEach(expediente => {

            if (id_rubro == expediente.id_rubro) {

                let opciones = {
                    radius: 6,
                    fillColor: color,
                    color: color,
                    weight: 2,
                }

                L.circleMarker(L.latLng(expediente.latitud, expediente.longitud), opciones).addTo(capaCategoria).bindTooltip(expediente.titular, { sticky: true })
            }
        })

        // Agregar la nueva capa al grupo overlays, si tiene marcadores
        if (capaCategoria.getLayers().length > 0) {

            let cantidad = capaCategoria.getLayers().length
            let NombreCategoria = " " + padLeft(cantidad, 2) + " <i class='fa fa-circle fa' aria-hidden='true' style='color:" + color + "'></i> " + capitalize(rubro.nombre)
            layerControl.addOverlay(capaCategoria, NombreCategoria, { groupName: "Categorias", expanded: true });
        }
    })

    alert.innerText = `Expedientes : ${expedientesFiltrados.length}`
}


// Definir marcadores por cada estado - Tipo_Estado
let mapEstados = () => {

    // Obtener valor año 
    const anio = Number(document.getElementById('anio').value)

    // Quitar capa
    layerControl.removeGroup("Estados");

    // Filtrar los expedientes x año
    let expedientesFiltrados = [];

    if (anio > 0) {
        expedientesFiltrados = expedientes.filter((expediente) => {
            return expediente.anio == anio;
        });
    } else {
        expedientesFiltrados = expedientes
    }

    let index = -1

    estados.forEach(estado => {

        index++
        capaCategoria = L.layerGroup();

        let id_estado = estado.id_estado

        expedientesFiltrados.forEach(expediente => {

            if (id_estado == expediente.id_estado) {

                const fontAwesomeIcon = L.divIcon({
                    html: estado.icono,
                    iconSize: [5, 5],
                });

                L.marker([expediente.latitud, expediente.longitud], { icon: fontAwesomeIcon }).addTo(capaCategoria).bindTooltip(expediente.titular, { sticky: true })
            }
        })

        // Agregar la nueva capa al grupo overlays, si tiene marcadores
        if (capaCategoria.getLayers().length > 0) {

            let cantidad = capaCategoria.getLayers().length
            let NombreCategoria = " " + padLeft(cantidad, 3) + " " + estado.icono + " " + capitalize(estado.nombre)
            layerControl.addOverlay(capaCategoria, NombreCategoria, { groupName: "Estados", expanded: true });
        }

    })
}


document.getElementById('anio').addEventListener('change', function (e) {
    mapRubros();
    mapEstados();
})

mapRubros();
mapEstados();