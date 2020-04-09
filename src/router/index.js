import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

/* Expedientes */
import Inicio from '../views/expedientes/Inicio.vue'

/* Mantenimiento */
import ProgramaEstudios from '../views/mantenimiento/ProgramaEstudios.vue'
import GradoProcedimiento from '../views/mantenimiento/GradoProcedimiento.vue'
import GradoTitulo from '../views/mantenimiento/GradoTitulo.vue'
import ModalidadObtencion from '../views/mantenimiento/ModalidadObtencion.vue'
import Rutas from '../views/mantenimiento/Rutas.vue'
import GradoModalidad from '../views/mantenimiento/GradoModalidad.vue'
import RolArea from '../views/mantenimiento/RolArea.vue'
import Procedimientos from '../views/mantenimiento/Procedimientos.vue'
//import About from '../views/About.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/inicio',
    name: 'inicio',
    component: Inicio
  },
  {
    path: '/rutas',
    name: 'rutas',
    component: Rutas
  },
  {
    path: '/grado-titulo',
    name: 'grado-titulo',
    component: GradoTitulo
  },
  {
    path: '/programa-estudios',
    name: 'programa-estudios',
    component: ProgramaEstudios
  },
  {
    path: '/modalidad-obtencion',
    name: 'modalidad-obtencion',
    component: ModalidadObtencion
  },
  {
    path: '/grado-procedimiento',
    name: 'grado-procedimiento',
    component: GradoProcedimiento
  },
  {
    path: '/rol-area',
    name: 'rol-area',
    component: RolArea
  },
  {
    path: '/procedimientos',
    name: 'procedimientos',
    component: Procedimientos
  },
  {
    path: '/grado-modalidad',
    name: 'grado-modalidad',
    component: GradoModalidad
  },
  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  }


]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,  
  routes
})

export default router
