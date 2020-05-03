<template>  
  <div id="app">
    <b-navbar toggleable="lg" type="dark" class="nav-unsa">
      <b-navbar-brand href="#">Grados y Títulos - UNSA</b-navbar-brand>
      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item to="/expedientes/inicio">Expedientes</b-nav-item>            
          <b-nav-item href="#">Reportes</b-nav-item>          
          <!-- Navbar dropdowns -->
          <b-nav-item-dropdown text="Mantenimiento" left>
            <b-dropdown-item to="/mantenimiento/rutas">Rutas</b-dropdown-item>
            <b-dropdown-item to="/mantenimiento/grado-titulo">Grado Título</b-dropdown-item>
            <b-dropdown-item to="/mantenimiento/programa-estudios">Programa Estudios</b-dropdown-item>
            <b-dropdown-item to="/mantenimiento/modalidad-obtencion">Modalidad Obtención</b-dropdown-item>
            <b-dropdown-item to="/mantenimiento/grado-procedimiento">Grado Procedimiento</b-dropdown-item>
            <b-dropdown-item to="/mantenimiento/grado-modalidad">Grado Modalidad</b-dropdown-item>
            <b-dropdown-item to="/mantenimiento/rol-area">Rol Area</b-dropdown-item>
            <b-dropdown-item to="/mantenimiento/procedimientos">Procedimiento</b-dropdown-item>
            <b-dropdown-item to="/mantenimiento/cargo">Cargo</b-dropdown-item>
            <b-dropdown-item to="/mantenimiento/autoridad">Autoridad</b-dropdown-item>
            <b-dropdown-item to="/mantenimiento/cargo-autoridad">Cargo Autoridad</b-dropdown-item>
          </b-nav-item-dropdown>
          <b-nav-item href="#">Configuración</b-nav-item>          
        </b-navbar-nav>        
      </b-collapse>
    </b-navbar>    
    <router-view/> <!--Mostrar contenido de la página-->
  </div>
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /*text-align: center;*/
  color: #2c3e50;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}

.nav-unsa {
  background-color: #990537;
  color: #fff;
}

table#tbl-programa-estudios .flip-list-move {
  transition: transform 1s;
}

table#tbl-modalidad-obtencion .flip-list-move {
  transition: transform 1s;
}  

table#tbl-rol-area .flip-list-move {
  transition: transform 1s;
}    

table#tbl-grado-titulo .flip-list-move {
  transition: transform 1s;
}

table#tbl-grado-modalidad .flip-list-move {
  transition: transform 1s;
}

/*table#tbl-procedimientos .flip-list-move {
    transition: transform 1s;
  }*/ 
/*table#tbl-grado-procedimiento .flip-list-move {
    transition: transform 1s;
}
table#tbl-rutas .flip-list-move {
    transition: transform 1s;
}*/ 
.overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.6);
} 
</style>
