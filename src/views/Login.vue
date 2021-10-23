<template>
  <div class="login-container">
    <v-container fill-height fluid>
      <v-row align="center" justify="center">
        <v-col cols="3">
          <form>
            <!-- :error-messages="nameErrors" -->
            <v-text-field
              v-model="usuario"
              :counter="10"
              label="Usuario"
              required
              @input="$v.name.$touch()"
              @blur="$v.name.$touch()"
            ></v-text-field>
            <!-- :error-messages="emailErrors" -->

            <v-text-field
              type="password"
              v-model="password"
              label="Contraseña"
              required
              @input="$v.email.$touch()"
              @blur="$v.email.$touch()"
            ></v-text-field>

            <v-row align="center" justify="center">
              <v-col cols="6">
                <v-btn class="mr-4" @click="submit"> Entrar </v-btn>
                <v-btn @click="clear"> Borrar </v-btn>
              </v-col>
            </v-row>
          </form>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
//$v es para manipular los datos de vuelidate
/*$dirty | Este valor nos indica si el usuario toco el campo o el formulario al menos una vez
$invalid | Este valor muestra el estado de validación del modelo
$error | Valor que nos permite decidir si se muestra o no un error en el formulario
$pending | Indica si algún tipo de validación asíncrona está pendiente de resolverse. Por defecto es siempre false para validaciones síncronas
$model | Referencia al valor del modelo validado. $v.value.$model es lo mismo que this.value
Veamos a hora los métodos:

$touch | Setea de forma recursiva el valor de \$dirty, tanto del modelo como de todos sus elementos secundarios a true
$reset | Hace los mismo que $touch pero seteando el valor a false
mas informacion en https://www.antoniomasia.com/potencia-tus-formularios-con-vuelidate/*/

import { validationMixin } from "vuelidate";
import { required, maxLength, email } from "vuelidate/lib/validators";

export default {
  name: "Login",

  mixins: [validationMixin],

  validations: {
    name: { required, maxLength: maxLength(10) },
    email: { required, email },
    select: { required },
    checkbox: {
      checked(val) {
        return val;
      },
    },
  },

  data: () => ({
    password: "",
    usuario: "",
    select: null,
    items: ["Item 1", "Item 2", "Item 3", "Item 4"],
    checkbox: false,
  }),

  computed: {
    nameErrors() {
      const errors = [];
      if (!this.$v.name.$dirty) return errors;
      !this.$v.name.maxLength &&
        errors.push("Name must be at most 10 characters long");
      !this.$v.name.required && errors.push("Name is required.");
      return errors;
    },
    emailErrors() {
      const errors = [];
      if (!this.$v.email.$dirty) return errors;
      !this.$v.email.email && errors.push("Necesita un email valido");
      !this.$v.email.required && errors.push("E-mail es requerido");
      return errors;
    },
  },

  methods: {
    submit() {
      if (this.usuario === "stiwar" && this.password === "123") {
        console.log("Correcto iniciando sesion");
        this.$router.push({ path: 'consultas' })
      } else {
        console.log("Usuario o contraseña incorrectos");
        this.usuario = "";
        this.password = "";
      }
    },
    clear() {
      this.$v.$reset();
      this.name = "";
      this.email = "";
      this.select = null;
      this.checkbox = false;
    },
  },
};
</script>


<style>
.login-container {
  height: 150px;
  /*IMPORTANTE*/
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>