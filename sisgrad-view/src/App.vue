<template>  
  <div id="app">
    <b-navbar v-if="usuario.tipo == 'Administrativo'" toggleable="lg" type="dark" class="nav-administrativo">
      <b-navbar-brand href="#">Grados y Títulos - UNSA</b-navbar-brand>
      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>          
          <template v-for="(menu, index) in array_menu">
            <template v-if="menu.submenu.length == 1">
              <b-nav-item :key="index" :to="{ name: menu.submenu[0].componente, params: { usuario: usuario }}">
                {{ menu.nombre }}
              </b-nav-item>
            </template>                        
            <template v-else-if="menu.submenu.length > 1">
              <b-nav-item-dropdown :key="index" :text="menu.nombre" left>            
                <b-dropdown-item v-for="(submenu, index) in menu.submenu" :key="index" 
                  :to="{ name: submenu.componente }"> {{ submenu.nombre }}
                </b-dropdown-item>                
              </b-nav-item-dropdown>
            </template>                        
          </template>
        </b-navbar-nav>        
      </b-collapse>
    </b-navbar>    
    <b-navbar v-else-if="usuario.tipo == 'Docente'" toggleable="lg" type="dark" class="nav-docente">
      <b-navbar-brand href="#">Grados y Títulos - UNSA</b-navbar-brand>
      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>          
          <b-nav-item :to="{ name: 'inicio', params: { usuario: usuario }}">Expedientes</b-nav-item>
          <b-nav-item :to="{ name: 'reportes', params: { usuario: usuario }}">Reportes</b-nav-item>
        </b-navbar-nav>        
      </b-collapse>
    </b-navbar>    
    <router-view/> <!--Mostrar contenido de la página-->
  </div>
</template>

<script>
export default {
    name: 'app', 
    data() {
      return {                               
        url: this.$root.API_URL,            
        codi_usuario: null,
        codi_menu_grup: null,            
        usuario : {},      
        array_menu: [],
      }
    },    
    methods: {
      getCodiOper() {
        let me = this

        this.axios.get(`${this.url}/codi_oper.php`)
        .then(function(response) {                  
          if (!response.data.error) {
            me.codi_usuario = response.data.codi_oper
            me.codi_menu_grup = response.data.codi_menu_grup                                                                                                                                                                                       
            me.getUsuario()
          }
          else {
            me.$root.mostrarNotificacion('Advertencia!', 'warning', 4000, 'error', response.data.message, 'bottom-right')
          }                  
        })
      },   
      getUsuario() {               
        let me = this       
        let formData = this._toFormData({
            codi_usuario: this.codi_usuario
        })       

        this.axios.post(`${this.url}/Usuario/getIdUsuario`, formData)
        .then(function(response) {                
            if (!response.data.error) {
                me.usuario = response.data.usuario                   
                
                if (me.usuario.tipo == 'Administrativo') {
                    me.getMenus()
                }                
            }
            else {                                        
                console.log(response.data.message)            
            }
        })
      },     
      getMenus() {     
        let me = this                           
        let formData = this._toFormData({            
            codi_usuario: this.codi_usuario,
            codi_menu_grup: this.codi_menu_grup
        })        

        this.axios.post(`${this.url}/Usuario/menus`, formData)
        .then(function(response) {                
          if (!response.data.error) {
            me.array_menu = response.data.array_menu                      
          }
          else {
            console.log(response.data.message)
          }            
        })            
      },
      _toFormData(obj) {
        var fd = new FormData()

        for (var i in obj) {
            fd.append(i, obj[i])
        }

        return fd
      }, 
    },
    mounted: function() {
      this.getCodiOper()            
    },
}
</script>

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

.nav-administrativo {
  background-color: #990537;
  color: #fff;
}
.nav-docente {
  background-color: #4A9FCE;
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
