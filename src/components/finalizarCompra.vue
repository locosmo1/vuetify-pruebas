<template>
  <div>
    <v-chip-group>
      <v-spacer></v-spacer>

      <v-dialog absolute v-model="terminarCompra" max-width="500px">
        <!-- Boton de terminar compras -->
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
            >
              <v-icon left> mdi-skip-next </v-icon>
              Terminar compras
            </v-btn>
          </v-card-actions>
        </template>

        <v-card elevation="5" shaped outlined>
          <!-- Opciones de editar y nuevo producto -->
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="10" sm="4" md="10">
                  <v-text-field v-model="nombre" label="Nombre"></v-text-field>
                </v-col>
                <v-col cols="10" sm="4" md="10">
                  <v-text-field v-model="pais" label="Pais"></v-text-field>
                </v-col>
                <v-col cols="10" sm="4" md="10">
                  <v-text-field
                    v-model="departamento"
                    label="Departamento"
                  ></v-text-field>
                </v-col>
                <v-col cols="10" sm="4" md="10">
                  <v-text-field
                    v-model="municipio"
                    label="Municipio"
                  ></v-text-field>
                </v-col>
                <v-col cols="10" sm="4" md="10">
                  <v-text-field
                    v-model="direccion"
                    label="Direccion"
                  ></v-text-field>
                </v-col>
                <v-col cols="10" sm="4" md="10">
                  <v-text-field
                    v-model="telefono"
                    label="Telefono"
                  ></v-text-field>
                </v-col>
                <v-col cols="10" sm="4" md="10">
                  <v-text-field
                    v-model="tarjeta"
                    label="Numero de la tarjeta"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer> </v-spacer>

            <v-btn
              color="primary"
              class="mb-2"
              dark
              @click="terminarCompra = false"
            >
              Cancelar
            </v-btn>

            <!-- Boton guardar datos del usuario supermasivo -->
            <v-dialog absolute v-model="botonGuardar" max-width="500px">
              <template v-slot:activator="{ on, attrs }">
                <v-card-actions class="px-3 pb-3">
                  <v-spacer></v-spacer>
                  <v-btn
                    color="primary"
                    dark
                    class="mb-2"
                    v-bind="attrs"
                    v-on="on"
                  >
                    Guardar
                  </v-btn>
                </v-card-actions>
              </template>

              <v-card elevation="5" shaped outlined>
                <v-card-text>
                  <v-container>
                    <v-row>
                      <div><v-btn disabled></v-btn></div>
                    </v-row>
                    <!-- datos de los productos a comprar -->
                    <v-row>
                      <div>
                        <div class="text-center d-flex pb-4">
                          <v-btn @click="all"> Expandir </v-btn>
                          <v-btn @click="none"> Contraer </v-btn>
                        </div>

                        <v-expansion-panels v-model="panel" multiple>
                          <v-expansion-panel
                            v-for="(elemento, indice) in $store.state.comprados"
                            :key="indice"
                          >
                            <v-expansion-panel-header
                              >Producto
                              {{ indice + 1 }}</v-expansion-panel-header
                            >
                            <v-expansion-panel-content>
                              <v-alert type="success">
                                {{ $store.getters.comprados[indice].titulo }}
                                <br />
                                Precio:
                                {{ $store.getters.comprados[indice].precio }}
                                <br />
                                Unidades:
                                {{ $store.getters.comprados[indice].unidades }}
                                <br />
                                Subtotal: 
                                {{ $store.getters.comprados[indice].precio*$store.getters.comprados[indice].unidades }}
                                <br />
                              </v-alert>
                            </v-expansion-panel-content>
                          </v-expansion-panel>
                        </v-expansion-panels>
                      </div>
                    </v-row>
                    <v-alert dark prominent type="success">
                      <strong> Total: {{ $store.state.total_compra }} </strong>
                    </v-alert>
                  </v-container>
                </v-card-text>

                <!-- Datos del cliente que quiere comprar -->
                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="12" sm="4" md="10">
                        <v-alert
                          color="primary"
                          dark
                          icon="mdi-vuetify"
                          border="left"
                          prominent
                        >
                          <strong>
                            <h4>Datos de la persona</h4>
                            Nombre: {{ nombre }} <br />
                            Pais: {{ pais }} <br />
                            Departamento: {{ departamento }} <br />
                            Municipio: {{ municipio }} <br />
                            Direccion: {{ direccion }} <br />
                            Telefono: {{ telefono }} <br />
                            Tarjeta: {{ tarjeta }} <br />
                          </strong>
                        </v-alert>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    color="blue darken-1"
                    text
                    @click="terminarCompra = false"
                  >
                    Salir
                  </v-btn>
                </v-card-actions>
              </v-card>
              <v-divider></v-divider>
            </v-dialog>
          </v-card-actions>
        </v-card>
        <v-divider></v-divider>
      </v-dialog>
    </v-chip-group>
  </div>
</template>

<script>
export default {
  data: () => ({
    terminarCompra: false,
    botonGuardar: false,
    nombre: "stiwar",
    pais: "Colombia",
    departamento: "Caqueta",
    municipio: "Florencia",
    direccion: "Calle 10a",
    telefono: "3508426005",
    tarjeta: "1651610321321",
    panel: [],
    items: 5,
  }),
  methods: {
    getDatos(indice) {
      return (
        this.$store.getters.comprados[indice].titulo +
        ", " +
        "Precio: " +
        this.$store.getters.comprados[indice].precio +
        ", " +
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

    all() {
      this.panel = [...Array(this.items).keys()].map((k, i) => i);
    },
    // Reset the panel
    none() {
      this.panel = [];
    },
  },
};
</script>