<template>  
  <div id="app">
    <b-navbar toggleable="lg" type="dark" class="nav-unsa">
      <b-navbar-brand href="#">Grados y Títulos - UNSA</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item to="/inicio">Expedientes</b-nav-item>            
          <b-nav-item href="#">Reportes</b-nav-item>          
          <!-- Navbar dropdowns -->
          <b-nav-item-dropdown text="Mantenimiento" left>
            <b-dropdown-item to="/rutas">Rutas</b-dropdown-item>
            <b-dropdown-item to="/grado-titulo">Grado Título</b-dropdown-item>
            <b-dropdown-item to="/programa-estudios">Programa Estudios</b-dropdown-item>
            <b-dropdown-item to="/modalidad-obtencion">Modalidad Obtención</b-dropdown-item>
            <b-dropdown-item to="/grado-procedimiento">Grado Procedimiento</b-dropdown-item>
            <b-dropdown-item to="/grado-modalidad">Grado Modalidad</b-dropdown-item>
            <b-dropdown-item to="/rol-area">Rol Area</b-dropdown-item>
            <b-dropdown-item to="/procedimientos">Procedimiento</b-dropdown-item>
            <b-dropdown-item to="/cargo">Cargo</b-dropdown-item>
            <b-dropdown-item to="/autoridad">Autoridad</b-dropdown-item>
            <b-dropdown-item to="/cargo-autoridad">Cargo Autoridad</b-dropdown-item>

          </b-nav-item-dropdown>
          <b-nav-item href="#">Configuración</b-nav-item>          
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <b-nav-form>
            <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
            <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
          </b-nav-form>

          <b-nav-item-dropdown text="Lang" right>
            <b-dropdown-item href="#">EN</b-dropdown-item>
            <b-dropdown-item href="#">ES</b-dropdown-item>
            <b-dropdown-item href="#">RU</b-dropdown-item>
            <b-dropdown-item href="#">FA</b-dropdown-item>
          </b-nav-item-dropdown>

          <b-nav-item-dropdown right>
            <!-- Using 'button-content' slot -->
            <template v-slot:button-content>
              <em>User</em>
            </template>
            <b-dropdown-item href="#">Profile</b-dropdown-item>
            <b-dropdown-item href="#">Sign Out</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
    <!--<div id="nav">
      <router-link to="/">Home</router-link> |
      <router-link to="/about">About</router-link>
    </div>-->
    <router-view/>
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
/*table#tbl-procedimientos .flip-list-move {
    transition: transform 1s;
  }*/ 
table#tbl-rol-area .flip-list-move {
    transition: transform 1s;
}    
table#tbl-grado-titulo .flip-list-move {
    transition: transform 1s;
}
table#tbl-grado-modalidad .flip-list-move {
    transition: transform 1s;
}
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
