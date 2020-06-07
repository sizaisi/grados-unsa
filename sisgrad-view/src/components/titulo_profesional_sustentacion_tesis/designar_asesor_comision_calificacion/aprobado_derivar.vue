<template>
    <b-card>
        <template v-if="!existeRecursoRutaVecinas">
            <b-card no-body>
                <b-tabs 
                    v-model="tabIndex" 
                    card        
                    active-nav-item-class="font-weight-bold text-uppercase text-danger"   
                    style="min-height: 250px"                        
                >            
                    <b-tab title="1. Asignar asesor" title-item-class="disabledTab" :disabled="tabIndex2 < 0">
                        <asesores
                            :expediente="expediente"
                            :idgrado_proc="grado_procedimiento.id"
                            :idusuario="usuario.id"                                                
                            :ruta="ruta"                              
                            ref="asesores"     
                        /> 
                        <div v-if="errors.length" class="alert alert-danger" role="alert">
                            <ul><li v-for="(error, i) in errors" :key="i">{{ error }}</li></ul>
                        </div>                 
                    </b-tab>                               
                    <b-tab :title="'2. '+ruta.etiqueta.charAt(0).toUpperCase()+ruta.etiqueta.slice(1)+' expediente'" 
                        title-item-class="disabledTab" :disabled="tabIndex2 < 1">
                        <movimiento_expediente
                            :grado_modalidad="grado_modalidad"
                            :grado_procedimiento="grado_procedimiento"                        
                            :usuario="usuario"
                            :tipo_rol="tipo_rol"                            
                            :expediente="expediente"
                            :movimiento="movimiento"
                            :ruta="ruta"                                                            
                        />
                    </b-tab>
                </b-tabs>
            </b-card>        
            <div class="text-center">
                <b-button-group class="mt-3">
                    <b-button class="mr-1" @click="prevTab" :disabled="tabIndex == 0">Anterior</b-button>
                    <b-button @click="nextTab" :disabled="tabIndex == 1">Siguiente</b-button>
                </b-button-group>     
            </div> 
        </template>
        <template v-else>
            <div class="alert alert-danger" role="alert">
                <ul><li>Debe deshacer las acciones realizadas en otras opciones de este procedimiento</li></ul>
            </div>                                                                 
        </template>
    </b-card>       
</template>
<script>
import asesores from '../resources/asesores.vue'
import movimiento_expediente from '../resources/movimiento_expediente.vue'

export default {
    name: 'aprobado-derivar',
    props: {
        grado_modalidad: Object,
        grado_procedimiento: Object,    
        usuario: Object,
        tipo_rol: String,        
        expediente: Object,
        graduando: Object,        
        ruta: Object,
        movimiento: Object
    },
    components: {            
        asesores,
        movimiento_expediente,           
    },
    data() {
        return {             
            url: this.$root.API_URL,      
            tabIndex: 0,         
            tabIndex2: 0, 
            existeRecursoRutaVecinas : false,                                          
            errors: [], 
        }
    },
    methods: {            
        prevTab() {
            this.errors = [] 
            this.tabIndex2--       
            this.tabIndex--        
        },  
        nextTab() {      
            this.errors = [] 
            let pasar = false    

            if (this.tabIndex == 0) {
                pasar = this.validarTab1()
            }                                    
                       
            if (pasar) {
                this.tabIndex2++
                this.$nextTick(function () {
                    this.tabIndex++        
                })  
            }              
        },   
        validarTab1() {        
            if (!this.$refs.asesores.existeAsesor()) { //referencia al metodo del componente hijo
                this.errors.push("Debe asignar un asesor al expediente selecccionado.")
            }                        

            if (!this.errors.length) {
                return true
            }      

            return false
        },        
        //verifica si las rutas vecinas de este procedimiento se registro observaciones, archivos o personas sin confirmar
        verificarRecursoRutasVecinas() { 
            let me = this      
            var formData = this._toFormData({
                idexpediente: this.expediente.id,
                idgrado_proc: this.grado_procedimiento.id,
                idusuario: this.usuario.id,                
                idruta: this.ruta.id
            })

            this.axios.post(`${this.url}/Recurso/verify`, formData)
            .then(function(response) {                                
                if (!response.data.error) {                
                    me.existeRecursoRutaVecinas = response.data.existeRecursoRutaVecinas
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
        this.verificarRecursoRutasVecinas()                      
    },     
}
</script>
<style scoped>
    ul {
        margin-bottom: 0px;    
    }         
</style>
<style>
    .disabledTab{
        pointer-events: none;
    }          
</style>