import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

/* Expedientes */
import Inicio from '../views/expedientes/Inicio.vue'
import Menu from '../views/expedientes/Menu.vue'
import TituloProfesionalSustentacionTesis 
  from '../views/expedientes/TituloProfesional-SustentacionTesis.vue'

/* Mantenimiento */
import ProgramaEstudios from '../views/mantenimiento/ProgramaEstudios.vue'
import GradoProcedimiento from '../views/mantenimiento/GradoProcedimiento.vue'
import GradoTitulo from '../views/mantenimiento/GradoTitulo.vue'
import ModalidadObtencion from '../views/mantenimiento/ModalidadObtencion.vue'
import Rutas from '../views/mantenimiento/Rutas.vue'
import GradoModalidad from '../views/mantenimiento/GradoModalidad.vue'
import RolArea from '../views/mantenimiento/RolArea.vue'
import Procedimiento from '../views/mantenimiento/Procedimientos.vue'
import Cargo from '../views/mantenimiento/Cargo.vue'
import Autoridad from '../views/mantenimiento/Autoridad.vue'
import CargoAutoridad from '../views/mantenimiento/CargoAutoridad.vue'

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
    component: Inicio,  
    props: true  
  },
  {
    path: '/expedientes/menu',
    name: 'menu-procedimientos',
    component: Menu,
    props: true
  },
  {
    path: '/expedientes/info-expediente4',
    name: 'info-expediente4', //4=>id grado modalidad (titulo profesional - sustentacion tesis)
    component: TituloProfesionalSustentacionTesis,
    props: true
  },
  {
    path: '/reportes',
    name: 'reportes',
    component: Home,  
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
    path: '/mantenimiento/procedimiento',
    name: 'procedimiento',
    component: Procedimiento
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
  {
    path: '/configuracion',
    name: 'configuracion',
    component: Home,  
    props: true  
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,  
  routes
})

export default router
