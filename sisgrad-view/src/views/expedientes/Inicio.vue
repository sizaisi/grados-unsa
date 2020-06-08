<template>
<div>
   <div class="container p-4" style="background-color: #fff;">
      <div class="row">         
         <div class="col text-center">                     
            <h5 class="font-weight-bold text-uppercase text-danger" v-if="array_grado_modalidad.length > 0" v-text="'Grados - Modalidades'"></h5>		
            <h5 class="text-info" v-else v-text="'No existen solicitudes pendientes'"></h5>		                
         </div>          		
      </div>
      <div class="row text-center mt-3" v-for="(group, index) in objectGroups" :key="index">
         <div class="col-lg-4" v-for="(grado_modalidad, i) in array_grado_modalidad.slice(index * itemsPerRow, (index + 1) * itemsPerRow)" :key="i">           
            <div class="counter">
               <h5 class="count-text-title" v-text="grado_modalidad.nombre_grado_titulo+' - '+grado_modalidad.nombre_modalidad_obtencion"></h5>               
               <h2 class="timer count-title count-number text-danger" v-text="grado_modalidad.total_expedientes"></h2>      
               <p class="count-text">Solicitudes pendientes</p><br>               
               <b-button 
                    pill 
                    variant="info"                   
                    :to="{ name: 'procedimientos', 
                            params: {                             
                                usuario: usuario,
                                grado_modalidad: grado_modalidad                                
                            } 
                    }">
                        Ver procedimientos
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
    props: {            
        usuario: Object        
    }, 
    data() {
        return {                               
            url: this.$root.API_URL,
            array_grado_modalidad : [],                         
            itemsPerRow: 3, //mostrar nro de items por fila
        }
    },
    computed: {
        objectGroups () {
            return Array.from(Array(Math.ceil(this.array_grado_modalidad.length / this.itemsPerRow)).keys())
        }
    },
    methods: {                
        getGradosModalidades() {                         
            if (this.usuario.tipo == 'Administrativo') {
                this.getAllGradoModadalidadAdminitrativo()
            }
            else if(this.usuario.tipo == 'Docente') {
                this.getAllGradoModadalidadDocente()
            }                                
        },     
        getAllGradoModadalidadAdminitrativo() {    
            let me = this        
            let formData = this._toFormData({                           
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
            let formData = this._toFormData({                           
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
        _toFormData(obj) {
            var fd = new FormData()

            for (var i in obj) {
              fd.append(i, obj[i])
            }

            return fd
        },         
    },
    mounted: function() {                           
        this.getGradosModalidades()            
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
