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
                    <b-tab title="1. Añadir observaciones" title-item-class="disabledTab" :disabled="tabIndex2 < 0">
                        <observaciones                    
                            :expediente="expediente"
                            :idgrado_proc="idgrado_proc"
                            :idusuario="idusuario"                                                                    
                            :ruta="ruta"                                                            
                            ref="observaciones"
                        />
                        <div v-if="errors.length" class="alert alert-danger" role="alert">
                            <ul><li v-for="(error, i) in errors" :key="i">{{ error }}</li></ul>
                        </div>           
                    </b-tab>
                    <b-tab title="2. Añadir documento" title-item-class="disabledTab" :disabled="tabIndex2 < 1">
                        <documentos               
                            :expediente="expediente"
                            :idgrado_proc="idgrado_proc"
                            :idusuario="idusuario"                                                                    
                            :ruta="ruta"                                                           
                            ref="documentos"
                            max_docs = "1"
                            nombre_asignado = "Nombre asignado prueba"
                        />
                        <div v-if="errors.length" class="alert alert-danger" role="alert">
                            <ul><li v-for="(error, i) in errors" :key="i">{{ error }}</li></ul>
                        </div>       
                    </b-tab>           
                    <b-tab title="3. Generar documento" title-item-class="disabledTab" :disabled="tabIndex2 < 2">
                        <generacion_documento                                        
                            :expediente="expediente"  
                            :graduando="graduando"
                            :movimiento="movimiento"                          
                            :asesor="asesor"       
                            nombre_archivo_pdf="resolucion_designacion_nuevo_asesor.php"
                            boton_nombre="Resolución nuevo asesor"
                        />                      
                    </b-tab>   
                    <b-tab title="4. Asignar asesor" title-item-class="disabledTab" :disabled="tabIndex2 < 3">
                        <asesores
                            :expediente="expediente"
                            :idgrado_proc="idgrado_proc"
                            :idusuario="idusuario"                                                
                            :ruta="ruta"       
                        />       
                    </b-tab>
                    <b-tab title="5. Asignar jurado" title-item-class="disabledTab" :disabled="tabIndex2 < 4">
                        <jurados
                            :expediente="expediente"
                            :idgrado_proc="idgrado_proc"
                            :idusuario="idusuario"                                                
                            :ruta="ruta"       
                        />       
                    </b-tab>
                    <b-tab :title="'6. '+ruta.etiqueta.charAt(0).toUpperCase()+ruta.etiqueta.slice(1)+' expediente'" 
                        title-item-class="disabledTab" :disabled="tabIndex2 < 5">
                        <movimiento_expediente
                            :idgrado_modalidad="idgrado_modalidad"
                            :idgrado_proc="idgrado_proc"                        
                            :idusuario="idusuario"
                            :codi_usuario="codi_usuario"
                            :idrol_area="idrol_area"
                            :tipo_rol="tipo_rol"
                            :tipo_usuario="tipo_usuario"
                            :expediente="expediente"                  
                            :ruta="ruta"                                                            
                        />
                    </b-tab>
                </b-tabs>
            </b-card>        
            <div class="text-center">
                <b-button-group class="mt-3">
                    <b-button class="mr-1" @click="prevTab" :disabled="tabIndex==0">Anterior</b-button>
                    <b-button @click="nextTab" :disabled="tabIndex==5">Siguiente</b-button>
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

import observaciones from '../resources/observaciones.vue'
import documentos from '../resources/documentos.vue'
import asesores from '../resources/asesores.vue'
import jurados from '../resources/jurados.vue'
import generacion_documento from '../resources/generacion_documento.vue'
import movimiento_expediente from '../resources/movimiento_expediente.vue'

export default {
    name: 'enviado-denegar',
    props: {
        idgrado_modalidad: String,
        idgrado_proc: String,    
        idusuario: String,
        codi_usuario: String,
        idrol_area: String,
        tipo_rol: String,
        tipo_usuario: String,
        expediente: Object,
        graduando: Object,
        movimiento: Object,
        ruta: Object            
    },
    components: {    
        observaciones,   
        documentos,   
        asesores,
        jurados,
        generacion_documento,
        movimiento_expediente,
    },
    data() {
        return {             
            url: this.$root.API_URL,      
            tabIndex: 0,         
            tabIndex2: 0, 
            existeRecursoRutaVecinas : false,                         
            asesor : null,  //object              
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
            
            if (this.tabIndex == 1) {
                pasar = true
            }                 

            if (this.tabIndex == 2) {
                pasar = true
            }     
            
            if (this.tabIndex == 3) {
                pasar = true
            }

            if (this.tabIndex == 4) {
                pasar = true
            }

            if (pasar) {
                this.tabIndex2++
                this.$nextTick(function () {
                    this.tabIndex++        
                })  
            }              
        },   
        validarTab1() {        
            if (this.$refs.observaciones.cantidadObservaciones() == 0) { //referencia al metodo del componente hijo
                this.errors.push("Debe registrar observaciones para el expediente seleccionado.")
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
                idgrado_proc: this.idgrado_proc,
                idusuario: this.idusuario,                
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
        getAsesor() {
            let me = this      
            var formData = this._toFormData({
                idexpediente: this.expediente.id
            })

            this.axios.post(`${this.url}/UsuarioExpediente/getAsesor`, formData)
            .then(function(response) {                
                if (!response.data.error) {                
                    me.asesor = response.data.asesor
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
        this.getAsesor()                      
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