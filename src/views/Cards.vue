<template>
  <div class="about pa-2 ma-4">
    <v-list two-line flat>
      <v-divider></v-divider>

      <!-- Agregar nuevo producto -->
      <hr />
      <v-chip-group>
        <!-- Boton 1 -->
        <v-dialog absolute v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-card-actions class="px-3 pb-3">
              <v-spacer></v-spacer>
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                Nuevo Producto
              </v-btn>
            </v-card-actions>
          </template>

          <v-row>
            <v-col v-for="n in 9" :key="n" class="d-flex child-flex" cols="4">
              <v-img
                :src="`https://picsum.photos/500/300?image=${n * 5 + 10}`"
                :lazy-src="`https://picsum.photos/10/6?image=${n * 5 + 10}`"
                aspect-ratio="1"
                class="grey lighten-2"
                @click="agregar_imagen_editar(n)"
              >
                <template v-slot:placeholder>
                  <v-row
                    class="fill-height ma-0"
                    align="center"
                    justify="center"
                  >
                    <v-progress-circular
                      indeterminate
                      color="grey lighten-5"
                    ></v-progress-circular>
                  </v-row>
                </template>
              </v-img>
            </v-col>
          </v-row>
          <v-card elevation="5" shaped outlined>
            <!-- Opciones de editar y nuevo producto -->
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.titulo"
                      label="Titulo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.subtitulo"
                      label="Subtitulo"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.precio"
                      label="Precio"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="cancelar">
                Cancelar
              </v-btn>
              <v-btn color="blue darken-1" text @click="nuevo()">
                Guardar
              </v-btn>
            </v-card-actions>
          </v-card>
          <v-divider></v-divider>
        </v-dialog>
      </v-chip-group>

      <!-- Lista de productos a comprar -->
      <v-list-item v-for="(task, index) in comprados" :key="index">
        <template>
          <v-list-item-action> </v-list-item-action>

          <v-list-item-content>
            <v-chip-group>
              <v-list-item-title
                :class="{ 'text-decoration-line-through': task.done }"
                >{{ task.titulo }}
                <v-spacer> Precio unidad: {{ task.precio }} </v-spacer>
                <v-spacer> Unidades: {{ task.unidades }} </v-spacer>
              </v-list-item-title>
            </v-chip-group>
            <h4>Subtotal {{ task.precio * task.unidades }}</h4>
          </v-list-item-content>
        </template>
        <v-chip-group>
          <v-icon class="mr-2" @click="aumentar_cantidad(index)">
            mdi-numeric-positive-1
          </v-icon>
          <v-icon class="mr-2" @click="disminuir_cantidad(index)">
            mdi-numeric-negative-1
          </v-icon>
          <v-icon class="mr-2" @click="eliminar_producto(index)">
            mdi-delete
          </v-icon>
          <hr />
        </v-chip-group>
      </v-list-item>

      <!-- Barra horizontal separadora -->
      <hr />
      <strong> Totales: {{ this.total_compra }} </strong>

      <!-- Productos en carrusel -->
      <v-chip-group>
        {{ this.datos }}
        <v-list-item
          :class="{ 'blue lighten-2': task.done }"
          v-for="(task, index) in tasks"
          :key="index"
        >
          <v-card
            width="500px"
            class="justify-start my-5 mb-3 px-3 pb-3 mt-5"
            elevation="24"
          >
            <v-img :src="agregar_imagen_lista(index)"> </v-img>
            <v-card-title> {{ task.titulo }} </v-card-title>
            <v-card-subtitle>
              {{ task.subtitulo }}
            </v-card-subtitle>
            <v-card-text>
              <p>Precio: {{ task.precio }}</p>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue" dark class="mb-2" @click="comprar(index)">
                Comprar
              </v-btn>
              <v-btn
                color="blue"
                dark
                class="mb-2"
                @click="accion_editar(index)"
              >
                Editar
              </v-btn>
              <v-btn
                color="blue"
                dark
                class="mb-2"
                @click="accion_borrar(index)"
              >
                Eliminar
              </v-btn>
            </v-card-actions>
            <v-divider vertical> </v-divider>
          </v-card>
        </v-list-item>
      </v-chip-group>
      <hr />
    </v-list>
  </div>
</template>

<script>
const axios = require("axios");

export default {
  data: () => ({
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
    editedItem: {
      titulo: "",
      subtitulo: "",
      precio: 0,
      imagen: "",
    },
    url_image: "",
    dialog: false,
    editar: false,
    indice_editar: 0,
    id_imagen: 0,
    total_compra: 0,
    unidades: 0,
  }),
  methods: {
    anadir_Tarea() {
      if (
        this.editedItem.titulo !== "" &&
        this.editedItem.subtitulo != "" &&
        this.editedItem.precio != "" &&
        this.url_image != ""
      ) {
        let precio_v = parseInt(this.editedItem.precio);
        let nueva = {
          titulo: this.editedItem.titulo,
          subtitulo: this.editedItem.subtitulo,
          precio: precio_v,
          imagen: this.url_image,
        };
        this.tasks.push(nueva);
        this.editar = false;
        this.dialog = false;
      }
    },

    editar_item() {
      let new_item;
      if (this.titulo_tarea != "") {
        let precio_v = parseInt(this.editedItem.precio);
        new_item = {
          titulo: this.editedItem.titulo,
          subtitulo: this.editedItem.subtitulo,
          precio: precio_v,
          imagen: this.url_image,
        };
        Object.assign(this.tasks[this.indice_editar], new_item);
        this.dialog = false;
        this.editar = false;
      }
    },

    nuevo() {
      if (this.editar == true) {
        this.editar_item();
      } else {
        this.anadir_Tarea();
      }
    },

    accion_editar(id) {
      this.indice_editar = id;
      this.dialog = true;
      this.editar = true;
    },

    accion_borrar(id) {
      this.editar = false;
      this.borrar_item(id);
    },

    borrar_item(id) {
      this.tasks.splice(id, 1);
    },

    cancelar() {
      this.dialog = false;
    },

    agregar_imagen_editar(id) {
      this.url_image = `https://picsum.photos/500/300?image=${id * 5 + 10}`;
    },

    agregar_imagen_lista(id) {
      return this.tasks[id].imagen;
    },

    comprar(id) {
      let indice = undefined;
      let unidades = 1;
      let i = 0;
      let iguales = false;
      let salir = false;
      let producto = {
        titulo: this.tasks[id].titulo,
        subtitulo: this.tasks[id].subtitulo,
        precio: this.tasks[id].precio,
        unidades: 1,
      };

      if (this.comprados.length == 0) {
        this.total_compra += producto.precio;
        this.comprados.push(producto);
      } else {
        do {
          if (i < this.comprados.length) {
            iguales = this.objetos_iguales(producto, this.comprados[i])
              ? true
              : false;
            i++;
            salir = iguales ? true : false;
          } else {
            salir = true;
          }
        } while (!salir);

        if (!iguales) {
          this.comprados.push(producto);
        } else if (iguales) {
          indice = this.encontrar_indice(producto);
          unidades = this.comprados[indice].unidades + 1;
          this.$set(this.comprados[indice], "unidades", unidades);
        }
        this.total_compra += producto.precio;
      }
      this.anadir_subtotal(producto.precio, 1);
      this.editar = false;
      this.dialog = false;
    },

    eliminar_producto(id) {
      this.total_compra -=
        this.comprados[id].precio * this.comprados[id].unidades;
      this.comprados.splice(id, 1);
    },

    aumentar_cantidad(index) {
      let valor = this.comprados[index].unidades + 1; //Aumentar total_compra

      this.total_compra += this.comprados[index].precio;

      this.$set(this.comprados[index], "unidades", valor);
    },

    disminuir_cantidad(index) {
      let valor = this.comprados[index].unidades - 1;

      if (valor >= 1) {
        this.total_compra -= this.comprados[index].precio;
        this.$set(this.comprados[index], "unidades", valor);
      }
    },

    objetos_iguales(obj1, obj2) {
      return (
        obj1.titulo === obj2.titulo &&
        obj1.subtitulo === obj2.subtitulo &&
        obj1.precio === obj2.precio
      );
    },

    encontrar_indice(producto) {
      let x, indice;
      for (x = 0; x < this.comprados.length; x++) {
        if (this.comprados[x].titulo == producto.titulo) {
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
      form.append('latitudusuario', 333)
      form.append('longitudusuario', 555)
      form.append('nombre', 'stiwar')

      fetch("https://epsasesp.com/wp-content/practicas_php/actualizarvue.php", {
        method: "POST",
        body: form,
      })
        .then(data => data.json())
        .then(respuesta => {
          console.log("respuesta: "+respuesta);
        })
        .catch((error) => console.log("Error: " + error));
    },
  },
};
</script>