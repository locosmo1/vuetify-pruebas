<template>
  <div>
    <v-chip-group>
      <v-card hover elevation="0" class="my-1 mb-1 px-1 pb-1 mt-1">
        <v-container>
          <v-row :justify="'start'">
            <v-col>
              <!-- Primera columna es la creacion de nuevos productos -->
              <v-dialog
                absolute
                v-model="$store.state.dialog"
                max-width="500px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-card-actions class="px-3 pb-3">
                    <v-spacer></v-spacer>
                    <v-btn
                      rounded
                      color="primary"
                      elevation="24"
                      dark
                      v-bind="attrs"
                      v-on="on"
                      @click="$store.state.editar = false"
                    >
                      <v-icon left> mdi-cart-plus </v-icon>
                      Nuevo Producto
                    </v-btn>
                  </v-card-actions>
                </template>

                <v-card elevation="0" shaped>
                  <v-row xs="12" sm="11" md="10" lg="8" xl="8">
                    <v-col
                      v-for="n in this.fotos.length"
                      :key="n"
                      class="d-flex child-flex"
                      cols="4"
                    >
                      <!--Boton que sea una imagen y dentro de el tenga href -->
                      <v-hover v-slot="{ hover }">
                        <v-card
                          :elevation="hover ? 24 : 0"
                          :class="{ 'on-hover': hover }"
                          hover
                          class="my-1 mb-1 px-1 pb-1 mt-1"
                        >
                          <v-img
                            :src="retornar_Imagen(n)"
                            aspect-ratio="0.6"
                            class="grey lighten-2"
                            @click="agregar_imagen_editar(n)"
                          >
                          </v-img>
                        </v-card>
                      </v-hover>

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
                    </v-col>
                  </v-row>

                  <v-container>
                    <v-row>
                      <v-col cols="4">
                        <v-text-field
                          v-model="buscar"
                          label="Buscar"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="2">
                        <v-btn
                          @click="obtenerImagenes()"
                          class="mx-2"
                          fab
                          dark
                          color="indigo"
                        >
                          <v-icon dark> mdi-magnify-plus-outline </v-icon>
                        </v-btn>
                      </v-col>

                      <v-col cols="6">
                        <v-btn
                          @click="mas_Imagenes()"
                          class="mx-2"
                          fab
                          dark
                          color="indigo"
                        >
                          <v-icon dark> mdi-plus </v-icon>
                        </v-btn>
                      </v-col>
                    </v-row>
                  </v-container>

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
                  <v-divider></v-divider>
                </v-card>
              </v-dialog>
            </v-col>

            <!--Segunda columna es para ver todos los productos que hay en el carrito -->
            <v-col>
              <v-dialog
                absolute
                v-model="$store.state.dialogProductos"
                max-width="500px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-card-actions class="px-3 pb-3">
                    <v-btn
                      v-bind="attrs"
                      v-on="on"
                      rounded
                      color="primary"
                      elevation="24"
                      dark
                    >
                      <v-icon left> mdi-cart-outline </v-icon>
                      Ir a carrito
                    </v-btn>
                  </v-card-actions>
                </template>

                <!-- AQUI LAS PRODUCTOS DEL CARRITO DE COMPRAS -->
                <buy-list> </buy-list>
              </v-dialog>
            </v-col>
          </v-row>
        </v-container>
      </v-card>
    </v-chip-group>
  </div>
</template>

<script>
import BuyList from "./buyList.vue";
export default {
  name: "agregarEditar",
  props: {
    fotos: Array,
    tasks: Array,
  },
  components: {
    BuyList,
  },
  data: () => ({
    pagina: 1,
    buscar: "cat",
    ultimo: "",
    editedItem: {
      titulo: "",
      subtitulo: "",
      precio: 0,
      imagen: "",
    },
  }),
  methods: {
    retornar_Imagen(id) {
      return this.fotos[id - 1];
    },

    async agregar_imagen_editar(id) {
      this.url_image = this.fotos[id - 1];
      //this.url_image = `https://picsum.photos/500/300?image=${id * 5 + 10}`;
    },

    cancelar() {
      this.$store.state.dialog = false;
    },

    nuevo() {
      console.log(this.$store.state.editar);
      if (this.$store.state.editar == true) {
        this.editarItem();
      } else {
        this.anadirTarea();
      }
    },

    editarItem() {
      let precio_v;
      let new_item;
      if (this.titulo_tarea != "") {
        precio_v = parseInt(this.editedItem.precio);
        new_item = {
          titulo: this.editedItem.titulo,
          subtitulo: this.editedItem.subtitulo,
          precio: precio_v,
          imagen: this.url_image,
        };
        Object.assign(this.tasks[this.$store.state.indice_editar], new_item);
        this.$store.state.dialog = false;
        this.editar = false;
      }
      let indice = this.encontrar_indice(new_item, this.tasks) + 1;

      let form = new FormData();
      form.append("id", indice);
      form.append("url", this.url_image);
      form.append("nombre", this.editedItem.titulo);
      form.append("precio", precio_v);

      fetch(
        "https://epsasesp.com/wp-content/practicas_php_vuejs/actualizarProducto.php",
        {
          method: "POST",
          body: form,
        }
      )
        .then((data) => data.json())
        .then((respuesta) => {})
        .catch((error) => console.log("Error: " + error));
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

    anadirTarea() {
      let form = new FormData();

      if (
        this.editedItem.titulo !== "" &&
        this.editedItem.subtitulo != "" &&
        this.editedItem.precio != "" &&
        this.url_image != ""
      ) {
        let precio_v = parseInt(this.editedItem.precio);
        form.append("id", this.tasks.length + 1);
        form.append("imagen", this.url_image);
        form.append("titulo", this.editedItem.titulo);
        form.append("subtitulo", this.editedItem.subtitulo);
        form.append("precio", precio_v);

        fetch(
          "https://epsasesp.com/wp-content/practicas_php_vuejs/Anadir_Producto.php",
          {
            method: "POST",
            body: form,
          }
        )
          .then((data) => data)
          .then((respuesta) => {})
          .catch((error) => console.log("Error: " + error));

        let nueva = {
          titulo: this.editedItem.titulo,
          subtitulo: this.editedItem.subtitulo,
          precio: precio_v,
          imagen: this.url_image,
        };
        this.tasks.push(nueva);
        this.editar = false;
        this.$store.state.dialog = false;
      }
    },

    async obtenerImagenes() {
      //const Url = "https://api.pexels.com/v1/curated?per_page-1"
      this.pagina = 1;
      if (this.ultimo === this.buscar) {
        //this.pagina = this.pagina + 1;
        this.ultimo = this.buscar;
      }
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

      this.fotos = this.vaciar_arreglo(this.fotos);

      respuesta.photos.forEach((element) => {
        this.fotos.push(element.src.tiny);
      });
    },

    async mas_Imagenes() {
      //const Url = "https://api.pexels.com/v1/curated?per_page-1"
      this.pagina = this.pagina + 1;
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
        this.fotos.push(element.src.tiny);
      });
    },

    vaciar_arreglo(arreglo) {
      for (let i = arreglo.length; i > 0; i--) {
        arreglo.pop();
      }
      return arreglo;
    },
  },
};
</script>

<style scoped>
</style>
