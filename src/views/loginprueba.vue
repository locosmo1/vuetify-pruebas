<template>
  <v-data-table
    :headers="headers"
    :items="desserts"
    sort-by="calories"
    class="elevation-10"
  >
    <template v-slot:top>
      <v-toolbar color="blue">
        <v-toolbar-title>My CRUD</v-toolbar-title
        ><!-- Titulo de la pagina -->
        <v-divider class="mx-4" inset vertical></v-divider>
        <!-- -->
        <v-spacer></v-spacer>
        <!-- Espacio para separar Mycrud de nuevo producto -->
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
              Nuevo Producto
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="text-h5"> {{ formTitle }} </span>
            </v-card-title>
            <!-- Opciones de editar y nuevo producto -->
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.name"
                      label="Producto"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.calories"
                      label="Calorias"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.fat"
                      label="Fat (g)"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.carbs"
                      label="Carbohidratos"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field
                      v-model="editedItem.protein"
                      label="Proteinas"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">
                Cancelar
              </v-btn>
              <v-btn color="blue darken-1" text @click="nuevo"> Guardar </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
      <v-navigation-drawer
        absolute
        dark
        src="data:image/jpeg;base64,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"
        width="25%"
        v-model="dialogDelete"
      >
        <v-list>
          <v-list-item
            v-for="item in items"
            :key="item.title"
            :to="item.to"
            @click="dialogDelete = !dialogDelete"
            link
          >
            <v-list-item-icon>
              <!-- Error aqui -->
              <v-icon v-text="item.icon"></v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title v-text="item.title"> </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
    </template>

    <template v-slot:[`item.actions`]="{ item }">
      <!-- Editar -->
      <v-icon class="mr-2" @click.stop="editItem(item)"> mdi-pencil </v-icon>
      <!-- Eliminar -->
      <v-icon class="mr-2" @click.stop="deleteItem(item)"> mdi-delete </v-icon>

      <v-icon class="mr-2" @click.stop="dialogDelete = true"> mdi-home </v-icon>
    </template>

    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize"> Resetear datos </v-btn>
    </template>
  </v-data-table>
</template>

<script>
export default {
  data: () => ({
    indice: 0,
    editar: false,
    dialog: false,
    item_producto: {},
    prueba: false,
    dialogDelete: false,
    items: [
      { title: "Home", icon: "mdi-home-city" },
      { title: "My Account", icon: "mdi-account" },
      { title: "Users", icon: "mdi-account-group-outline" },
    ],
    headers: [
      {
        text: "Producto",
        align: "start",
        sortable: false,
        value: "name",
      },
      { text: "Calorias", value: "calories" },
      { text: "Fat (g)", value: "fat" },
      { text: "Carbohidratos (g)", value: "carbs" },
      { text: "Proteinas (g)", value: "protein" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    desserts: [], //arreglo de los productos
    editedIndex: -1,
    editedItem: {
      name: "",
      calories: 0,
      fat: 0,
      carbs: 0,
      protein: 0,
    },
    defaultItem: {
      name: "",
      calories: 0,
      fat: 0,
      carbs: 0,
      protein: 0,
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === this.editar ? "Edit Item" : "dialog";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
      this.desserts = [
        {
          id: 1,
          name: "Yogurt",
          calories: 159,
          fat: 6.0,
          carbs: 24,
          protein: 4.0,
        },
        {
          id: 2,
          name: "Sandwich",
          calories: 237,
          fat: 9.0,
          carbs: 37,
          protein: 4.3,
        },
        {
          id: 3,
          name: "Banana",
          calories: 262,
          fat: 16.0,
          carbs: 23,
          protein: 6.0,
        },
      ];
      (this.editar = false), (this.indice = 0);
    },

    editItem(item) {
      this.item_producto = this.editedItem;
      this.indice = item.id;
      this.dialog = true;
      this.editar = true;
    },

    deleteItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
      this.editar = false;
    },

    ////Se ejecuta cuando confirmamos el eliminar
    deleteItemConfirm() {
      this.desserts.splice(this.editedIndex, 1);
      this.closeDelete();
      this.editar = false;
    },

    //Se ejecuta cuando damos clic en cancelar
    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
        this.editar = false;
      });
    },

    //Cancelar del eliminar
    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
        this.editar = false;
      });
    },

    nuevo() {
      if (this.editar == true) {
        Object.assign(this.desserts[this.indice - 1], this.item_producto);
        this.close();
      } else {
        this.desserts.push(this.editedItem);
        this.close();
      }
    },
  },
};
</script>