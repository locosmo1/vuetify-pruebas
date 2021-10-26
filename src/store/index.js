import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {//Datos globales
    conectado: false,
    nombre: "Jhon",
    apellido: "Stiwar",
    amigos: ['ana', 'caballo'],
    comprados: [],
    total_compra: 0,
    amigo: null,
    dialog: false,
    dialogProductos: false,
    editar: false,
    indice_editar: undefined
  },
  mutations: {//Se utilizan metodos que son asincronicos NO APIS
    add_amigo(state){
      state.amigos.push(state.amigo);
    },
  },
  actions: {//Metodos globales Se utitilizan metodos que son asyncronicos Consulta de APIS
    add_amigo_Action(context){
      context.commit('add_amigo');
    }
  },
  getters: {//Obtener datos globales
    dialogo( state ){
      return state.dialog;
    },
    editar( state ){
      return state.editar;
    },
    nombre( state ){
      return `${state.nombre} ${state.apellido}`
    },
    comprados(state){
      return state.comprados
    },
    conectado(state){
      return state.conectado
    }
  },
  modules: {//Recoleccion de estados, mutaciones, acciones, getters
  }
})
