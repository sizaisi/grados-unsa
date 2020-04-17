import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

/* Expedientes */
import Inicio from '../views/expedientes/Inicio.vue'
import Menu from '../views/expedientes/Menu.vue'
import InfoExpediente from '../views/expedientes/InfoExpediente.vue'

/* Mantenimiento */
import ProgramaEstudios from '../views/mantenimiento/ProgramaEstudios.vue'
import GradoProcedimiento from '../views/mantenimiento/GradoProcedimiento.vue'
import GradoTitulo from '../views/mantenimiento/GradoTitulo.vue'
import ModalidadObtencion from '../views/mantenimiento/ModalidadObtencion.vue'
import Rutas from '../views/mantenimiento/Rutas.vue'
import GradoModalidad from '../views/mantenimiento/GradoModalidad.vue'
import RolArea from '../views/mantenimiento/RolArea.vue'
import Procedimientos from '../views/mantenimiento/Procedimientos.vue'
import Cargo from '../views/mantenimiento/Cargo.vue'
import Autoridad from '../views/mantenimiento/Autoridad.vue'
import CargoAutoridad from '../views/mantenimiento/CargoAutoridad.vue'
//import About from '../views/About.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/expedientes/inicio',
    name: 'inicio',
    component: Inicio
  },
  {
    path: '/expedientes/menu',
    name: 'menu-procedimientos',
    component: Menu,
    props: true
  },
  {
    path: '/expedientes/info-expediente',
    name: 'info-expediente',
    component: InfoExpediente,
    props: true
  },
  {
    path: '/mantenimiento/rutas',
    name: 'rutas',
    component: Rutas
  },
  {
    path: '/mantenimiento/grado-titulo',
    name: 'grado-titulo',
    component: GradoTitulo
  },
  {
    path: '/mantenimiento/programa-estudios',
    name: 'programa-estudios',
    component: ProgramaEstudios
  },
  {
    path: '/mantenimiento/modalidad-obtencion',
    name: 'modalidad-obtencion',
    component: ModalidadObtencion
  },
  {
    path: '/mantenimiento/grado-procedimiento',
    name: 'grado-procedimiento',
    component: GradoProcedimiento
  },
  {
    path: '/mantenimiento/rol-area',
    name: 'rol-area',
    component: RolArea
  },
  {
    path: '/mantenimiento/procedimientos',
    name: 'procedimientos',
    component: Procedimientos
  },
  {
    path: '/mantenimiento/grado-modalidad',
    name: 'grado-modalidad',
    component: GradoModalidad
  },
  {
    path: '/mantenimiento/cargo',
    name: 'cargo',
    component: Cargo
  },
  {
    path: '/mantenimiento/autoridad',
    name: 'autoridad',
    component: Autoridad
  },
  {
    path: '/mantenimiento/cargo-autoridad',
    name: 'cargo-autoridad',
    component: CargoAutoridad
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,  
  routes
})

export default router
