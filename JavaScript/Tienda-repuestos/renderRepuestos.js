
// Importar la API que se va a ver en el navegador
import { getProductos } from "./api-repuestos.js";
// Fin

import { addCarrito, updateCarrito } from "./meterEnCarro.js";

updateCarrito()

const urlImg = "https://image.tmdb.org/t/p/w500"

export function displayRepuestos(inicio, fin){
    const repuestos = getProductos();
    let contenedor = "";
    if(repuestos && Array.isArray(repuestos)){
        repuestos.slice(inicio, fin).map(repuesto => {
            contenedor += `
            <div class="repuesto">
            <img class="imagen" src="${repuesto.img}" alt="${repuesto.nombre}"></img>
            <h3>${repuesto.nombre}</h3>
                <div class="repuesto-texto">
                <p class="precio">${repuesto.precio} €</p>
                <p class="marca">${repuesto.marca}</p>
                <p class="modelo_valido">${repuesto.modelo_valido}</p>
                <button data-set="${repuesto.id}" class="add">Comprar</button>
                </div>
            </div>
            `
        })
    }else{
        contenedor = "<p>No hay productos disponibles</p>"
    }
    document.getElementById("products").innerHTML = contenedor;

    const botonesComprar = document.querySelectorAll(".add");
    
    botonesComprar.forEach(boton => {
        boton.addEventListener("click", addCarrito)
    });
    }
