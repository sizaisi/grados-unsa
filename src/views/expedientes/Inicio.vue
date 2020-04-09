<template>
<div>
   <div class="container p-4" style="background-color: #fff;">
      <div class="row">         
         <div class="col text-center">         
            <h3 class="text-info" v-if="codi_usuario == null" v-text="'No existe sesión de usuario'"></h3>		
            <h3 class="text-info" v-else-if="array_grado_modalidad > 0" v-text="'Solicitudes pendientes'"></h3>		
            <h3 class="text-info" v-else v-text="'No existen solicitudes pendientes'"></h3>		
         </div>          		
      </div>
      <div class="row text-center mt-3" v-for="(group, index) in objectGroups" :key="index">
         <div class="col-lg-4" v-for="(grado_modalidad, i) in array_grado_modalidad.slice(index * itemsPerRow, (index + 1) * itemsPerRow)" :key="i">           
            <div class="counter">
               <h5 class="count-text-title" v-text="grado_modalidad.nombre_grado_titulo+' - '+grado_modalidad.nombre_modalidad_obtencion"></h5>               
               <h2 class="timer count-title count-number" v-text="grado_modalidad.total_expedientes"></h2>      
               <p class="count-text">Solicitudes pendientes</p><br>
               <b-button pill variant="info" :href="'vista_menu.php?idgrado_modalidad='+grado_modalidad.idgrado_modalidad+'&codi_usuario=<?=$codi_oper?>'">
                  Ver lista
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
            //url: url_controller,
            array_grado_modalidad : [],                 
            codi_usuario: null,
            itemsPerRow: 3, //mostrar nro de items por fila
        }
    },
    computed: {
        objectGroups () {
            return Array.from(Array(Math.ceil(this.array_grado_modalidad.length / this.itemsPerRow)).keys())
        }
    },
    methods: {
        getAllModadalidadObtencion() {    
            let me = this           

            this.axios.get(this.url+"GradoModalidadController.php?action=read_escritorio", {
                params: {                           
                    codi_usuario: this.codi_usuario,                         
                }
            })
            .then(function(response) {
                if (response.data.error) {
                    me.errorMsg = response.data.message
                }
                else {
                    me.array_grado_modalidad = response.data.array_grado_modalidad                       
                }
            })
        },   
        getCodiOper() {
            let me = this

            this.axios.get("//localhost/grados-unsa/backend2/codi_oper.php")
                .then(function(response) {                  
                    if (response.data.error) {
                        me.codi_usuario = null                     
                    }
                    else {
                        me.codi_usuario = response.data.codi_oper                        
                        //me.getAllModadalidadObtencion()
                    }                  
                })
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
