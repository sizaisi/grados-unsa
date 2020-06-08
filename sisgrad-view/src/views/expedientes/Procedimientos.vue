<template>
<div>
   <div class="container p-4" style="background-color: #fff;">
      <h5 class="text-center font-weight-bold text-uppercase text-danger" 
          v-text="grado_modalidad.nombre_grado_titulo + ' - ' + grado_modalidad.nombre_modalidad_obtencion + ': Procedimientos'">
      </h5>
      <div class="text-center mt-3">                           
        <b-button 
          :to="{ name: 'inicio', 
                    params: {                             
                        usuario: usuario,
                        grado_modalidad: grado_modalidad                                
                    } 
            }"
          variant="outline-info"
        > 
          <b-icon icon="arrow-left-short"></b-icon>
          Atras
        </b-button>
      </div> 
      <div class="row text-center mt-3" v-for="(group, index) in objectGroups" :key="index">
         <div class="col-lg-4" v-for="(grado_procedimiento, i) in array_grado_procedimiento.slice(index * itemsPerRow, (index + 1) * itemsPerRow)" :key="i">           
            <div class="counter">
               <h5 class="count-text-title" v-text="grado_procedimiento.proc_nombre"></h5>               
               <h2 v-if="grado_procedimiento.total_expedientes == 0" class="timer count-title count-number" v-text="grado_procedimiento.total_expedientes"></h2>      
               <h2 v-else class="timer count-title count-number text-danger" v-text="grado_procedimiento.total_expedientes"></h2>
               <p class="count-text">Solicitudes pendientes</p><br>               
               <b-button 
                    pill 
                    variant="info"                   
                    :to="{ name: 'bandeja', 
                            params: {                             
                                usuario: usuario,
                                grado_modalidad: grado_modalidad,
                                grado_procedimiento: grado_procedimiento
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
    name: 'procedimientos',     
    props: {    
        usuario: Object,
        grado_modalidad: Object                
    },    
    data() {
        return {                               
            url: this.$root.API_URL,
            array_grado_procedimiento : [],                         
            itemsPerRow: 3, //mostrar nro de items por fila
        }
    },
    computed: {
        objectGroups () {
            return Array.from(Array(Math.ceil(this.array_grado_procedimiento.length / this.itemsPerRow)).keys())
        }
    },
    methods: {                
        getGradoProcedimientos() {
            let me = this
            let formData = this._toFormData({
                idgrado_modalidad: this.grado_modalidad.id,
                idrol_area: this.usuario.idrol_area,
                idusuario: this.usuario.id
            })

            this.axios.post(`${this.url}/GradoProcedimiento/gradoProcedimientos`, formData)
            .then(function(response) {            
                if (!response.data.error) {
                    me.array_grado_procedimiento = response.data.array_grado_procedimiento
                }
                else {                
                    //console.log(response.data.message)
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
        if (this.grado_modalidad != null) { //si se ha recibido el obj grado-modalidad
            this.getGradoProcedimientos()    
        }
        else {
            this.$router.push({ name: 'home' }); 
        }                
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
        /*color: #dc3545;*/
        color: #4ad1e5;
        height: 50px;
    }
</style>
