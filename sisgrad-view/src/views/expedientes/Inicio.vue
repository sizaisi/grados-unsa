<template>
<div>
   <div class="container p-4" style="background-color: #fff;">
      <div class="row">         
         <div class="col text-center">         
            <h3 class="text-info" v-if="codi_usuario == null" v-text="'No existe sesión de usuario'"></h3>		
            <h3 class="text-info" v-else-if="array_grado_modalidad.length > 0" v-text="'Solicitudes pendientes'"></h3>		
            <h3 class="text-info" v-else v-text="'No existen solicitudes pendientes'"></h3>		
         </div>          		
      </div>
      <div class="row text-center mt-3" v-for="(group, index) in objectGroups" :key="index">
         <div class="col-lg-4" v-for="(grado_modalidad, i) in array_grado_modalidad.slice(index * itemsPerRow, (index + 1) * itemsPerRow)" :key="i">           
            <div class="counter">
               <h5 class="count-text-title" v-text="grado_modalidad.nombre_grado_titulo+' - '+grado_modalidad.nombre_modalidad_obtencion"></h5>               
               <h2 class="timer count-title count-number" v-text="grado_modalidad.total_expedientes"></h2>      
               <p class="count-text">Solicitudes pendientes</p><br>               
               <b-button 
                  pill 
                  variant="info"                   
                  :to="{ name: 'menu-procedimientos', 
                         params: { 
                            idgrado_modalidad: grado_modalidad.idgrado_modalidad, 
                            idusuario: usuario.id,
                            codi_usuario: usuario.codi_usuario,
                            idrol_area: usuario.idrol_area,
                            tipo_usuario: usuario.tipo,
                         } 
                    }">
                  Ver expedientes
               </b-button>
            </div>
         </div>                            
      </div>      
   </div>           
</div>
</template>

<script>

export default {
    name: 'inicio', 
    data() {
        return {                               
            url: this.$root.API_URL,
            array_grado_modalidad : [],  
            codi_usuario: null,                
            usuario : {},      
            itemsPerRow: 3, //mostrar nro de items por fila
        }
    },
    computed: {
        objectGroups () {
            return Array.from(Array(Math.ceil(this.array_grado_modalidad.length / this.itemsPerRow)).keys())
        }
    },
    methods: {
        getIdUsuario() {            
            let me = this       
            var formData = this._toFormData({
                codi_usuario: this.codi_usuario
            })

            this.axios.post(`${this.url}/Usuario/getIdUsuario`, formData)
            .then(function(response) {
                if (!response.data.error) {
                    me.usuario = response.data.usuario                   
                    
                    if (me.usuario.tipo == 'Administrativo') {
                        me.getAllGradoModadalidadAdminitrativo()
                    }
                    else if(me.usuario.tipo == 'Docente') {
                        me.getAllGradoModadalidadDocente()
                    }                    
                }
                else {                                        
                    me.$bvToast.toast(response.data.message, {
                        title: 'Error!',
                        variant: 'danger',
                        toaster: 'b-toaster-bottom-right',                    
                    })              
                }
            })
        },     
        getAllGradoModadalidadAdminitrativo() {    
            let me = this        
            var formData = this._toFormData({                           
                    codi_usuario: this.usuario.codi_usuario,                         
                    idrol_area: this.usuario.idrol_area,                         
                })

            this.axios.post(`${this.url}/GradoModalidad/inicioAdminitrativo`, formData)
                .then(function(response) {                   
                    if (!response.data.error) {
                        me.array_grado_modalidad = response.data.array_grado_modalidad                                                                       
                    }
                    else {
                       console.log(response.data.message)
                    }
                })
        }, 
        getAllGradoModadalidadDocente() {                
            let me = this        
            var formData = this._toFormData({                           
                    codi_usuario: this.usuario.codi_usuario,                         
                    idrol_area: this.usuario.idrol_area,                         
                })

            this.axios.post(`${this.url}/GradoModalidad/inicioDocente`, formData)
                .then(function(response) {                   
                    if (!response.data.error) {
                        me.array_grado_modalidad = response.data.array_grado_modalidad                                                                       
                    }
                    else {
                       console.log(response.data.message)
                    }
                })
        },   
        getCodiOper() {
            let me = this

            this.axios.get(`${this.url}/codi_oper.php`)
                .then(function(response) {                  
                    if (response.data.error) {
                        me.codi_usuario = null                                                                   
                    }
                    else {
                        me.codi_usuario = response.data.codi_oper                                                                        
                        me.getIdUsuario()                        
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
<style scoped>
    .counter {
        background-color:#f5f5f5;
        padding: 25px 15px;
        border-radius: 5px;
        min-height: 250px;
    }

    .count-title {
        font-size: 40px;
        font-weight: normal;
        margin-top: 10px;
        margin-bottom: 0;
        text-align: center;
    }

    .count-text {
        font-size: 15px;
        font-weight: normal;
        margin-top: 10px;
        margin-bottom: 0;
        text-align: center;
    }
    
    .count-text-title {
        color: #4ad1e5;
        height: 50px;
    }
</style>
