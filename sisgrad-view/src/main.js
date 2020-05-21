import Vue from 'vue'
import App from './App.vue'

import Vuesax from 'vuesax'
import 'vuesax/dist/vuesax.css'
//Vue.use(Vuesax)
Vue.use(Vuesax, {
  theme:{
    colors:{
      primary:'#5b3cc4',
      success:'rgb(23, 201, 100)',
      danger:'rgb(242, 19, 93)',
      warning:'rgb(255, 130, 0)',
      dark:'rgb(36, 33, 69)'
    }
  }
})
import 'material-icons/iconfont/material-icons.css';

import router from './router'
import store from './store'
import config from './config'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import { BootstrapVueIcons } from 'bootstrap-vue'
import vSelect from 'vue-select'
import Multiselect from 'vue-multiselect'

Vue.use(BootstrapVueIcons) 
Vue.use(VueAxios, axios)

// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

Vue.component('v-select', vSelect)
Vue.component('multiselect', Multiselect)

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'bootstrap-vue/dist/bootstrap-vue-icons.min.css'
import 'vue-select/dist/vue-select.css';
import 'vue-multiselect/dist/vue-multiselect.min.css'
import './assets/css/main.css';

Vue.config.productionTip = false

new Vue({
  data: {
    API_URL: config.API_URL,
    FILE_URL: config.FILE_URL,    
    color_acciones : config.color_acciones,
    color_estados : config.color_estados,
    estados : config.estados,
  },  
  methods: {         
    mostrarNotificacion(titulo, color, tiempo, icono, mensaje, posicion) {
      this.$vs.notify({
        title: titulo,
        color: color,
        time: tiempo,
        icon: icono,
        text: mensaje,
        position: posicion,
      })
    },
  },       
  router,
  store,    
  render: h => h(App)
}).$mount('#app')