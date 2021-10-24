<template>
  <div class="about pa-2 ma-4">
    <v-list two-line flat>
      <v-divider></v-divider>

      <!-- Crear o editar producto -->
      <hr />
      <agregarEditar :fotos="fotos" :tasks="tasks"></agregarEditar>

      <!-- Barra horizontal separadora -->
      <hr />
      <!-- Boton para finalizar las compras -->
      <finalizarCompra> </finalizarCompra> 

      <!-- Carrusel de productos Listos para comprar -->
      <carrusel :tasks="tasks"> </carrusel>
      <hr />
      
    </v-list>
  </div>
</template>

<script>
const axios = require("axios");
import carrusel from "../components/movieCard";
import buyList from "../components/buyList";
import agregarEditar from "../components/agregarEditar";
import finalizarCompra from "../components/finalizarCompra";

export default {
  components: {
    carrusel,
    buyList,
    agregarEditar,
    finalizarCompra,
  },
  data: () => ({
    datos_Tabla: [],
    headers: [
      { text: "Titulo" },
      { text: "Subtitulo" },
      { text: "Precio" },
      { text: "Unidades" },
    ],
    botonGuardar: false,
    terminar_Compra: false,
    tasks: [
      {
        titulo: "Computador portatil",
        subtitulo: "Vendido por: barak team",
        precio: 10,
        imagen: "https://cdn.vuetifyjs.com/images/parallax/material.jpg",
      },
      {
        titulo: "Plantas",
        subtitulo: "Plantas",
        precio: 2,
        imagen: "https://picsum.photos/500/300?image=18",
      },
      {
        titulo: "Escritorio",
        subtitulo: "Escritorio",
        precio: 4,
        imagen: "https://picsum.photos/500/300?image=20",
      },
    ],
    datos: null,
    comprados: [],
    subtotales: [],
    fotos: [],
    pagina: 1,
    buscar: "cat",
    ultimo: "",
    editedItem: {
      titulo: "",
      subtitulo: "",
      precio: 0,
      imagen: "",
    },
    url_image: "",
    indice_editar: 0,
    id_imagen: 0,
    total_compra: 0,
    unidades: 0,
    editar: false,
    dialog: false,
  }),
  created() {
    this.iniciar_data();
    this.iniciar_imagenes();
  },
  updated: function () {
  },
  methods: {
    getDatos(indice) {
      return (
        this.$store.getters.comprados[indice].titulo +
        " " +
        "Precio: " +
        this.$store.getters.comprados[indice].precio +
        " " +
        "Unidades: " +
        this.$store.getters.comprados[indice].unidades +
        "."
      );
      /*let acum = ""
      for(let indice = 0; indice<this.$store.getters.comprados.length; indice++){
        acum += " "+this.$store.getters.comprados[indice].titulo + " " +
        "Precio: " + this.$store.getters.comprados[indice].precio + " " +
        "Unidades: " + this.$store.getters.comprados[indice].unidades + "."
      }
      return acum*/
    },

    initialize() {
      //this.datos_Tabla = this.$store.getters.comprados
      Object.assign(this.datos_Tabla, this.$store.getters.comprados);
    },

    cancelar() {
      this.terminar_Compra = false;
    },

    iniciar_data() {
      let nuevo = [];
      axios
        .get(
          "https://epsasesp.com/wp-content/practicas_php_vuejs/obtenerProducto.php",
          {
            responseType: "json",
          }
        )
        .then(function (res) {
          if (res.status == 200) {
            for (let i = 0; i < res.data.datos.length; i++) {
              let np = {
                titulo: res.data.datos[i].nombre,
                subtitulo: res.data.datos[i].nombre,
                precio: res.data.datos[i].precio,
                imagen: res.data.datos[i].urlImagen,
              };
              nuevo.push(np);
            }
          } else {
            console.log("Algo ah fallado");
          }
        })
        .catch(function (err) {
          console.log("Error en axios: " + err);
        });
      this.tasks = nuevo;
      //Object.assign(this.tasks, nuevo);
      //this.$set(this.tasks, nuevo);
    },

    async iniciar_imagenes() {
      //const Url = "https://api.pexels.com/v1/curated?per_page-1"
      this.pagina = 1;
      const Url =
        "https://api.pexels.com/v1/search?query=" +
        this.buscar +
        "&per_page=9&page=" +
        this.pagina;
      const apikey = "563492ad6f917000010000017248196f0f5f40ec82d8a0b3a18955a7";

      const res = await fetch(Url, {
        method: "GET",
        headers: {
          Accept: "application/json",
          Authorization: apikey,
        },
      });
      const respuesta = await res.json();
      respuesta.photos.forEach((element) => {
        this.fotos.push(element.src.original);
      });
    },

    objetos_iguales(obj1, obj2) {
      return (
        obj1.titulo === obj2.titulo &&
        obj1.subtitulo === obj2.subtitulo &&
        obj1.precio === obj2.precio
      );
    },

    encontrar_indice(producto, arreglo) {
      let x, indice;
      for (x = 0; x < arreglo.length; x++) {
        if (arreglo[x].titulo == producto.titulo) {
          indice = x;
        }
      }
      return indice;
    },

    anadir_subtotal(a, b) {
      this.subtotales.push(a * b);
    },

    retornar_subtotal(indice) {
      return this.subtotales[indice];
    },

    suma_subtotales() {
      let total = 0,
        i = 0;
      if (this.subtotales.length > 0) {
        for (i = 0; i < this.subtotales.length; i++) {
          let precio_v = parseInt(this.subtotales[i].precio);
          total += precio_v;
        }
      }
      this.total_compra = total;
      return this.total_compra;
    },

    async obtenerDatos() {
      axios
        .get("https://epsasesp.com/wp-content/practicas_php/consulta.php", {
          responseType: "json",
        })
        .then(function (res) {
          if (res.status == 200) {
            res.data.datos.forEach((element) => {
              console.log(element.nombre);
              console.log(element.telefono);
              console.log(element.latitud);
              console.log(element.longitud);
              console.log(" ");
            });
          } else {
            console.log("Algo ah fallado");
          }
        })
        .catch(function (err) {
          console.log(err);
        });
    },

    enviarDatos() {
      let form = new FormData();
      form.append("latitudusuario", 333);
      form.append("longitudusuario", 555);
      form.append("nombre", "stiwar");

      fetch("https://epsasesp.com/wp-content/practicas_php/actualizarvue.php", {
        method: "POST",
        body: form,
      })
        .then((data) => data.json())
        .then((respuesta) => {})
        .catch((error) => console.log("Error: " + error));
    },
  },
};
</script>
