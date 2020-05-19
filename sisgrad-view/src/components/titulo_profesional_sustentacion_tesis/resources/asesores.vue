<template>
    <div>    
        <b-form @submit.prevent="registrarAsesor" class="mb-3">
            <b-row class="justify-content-lg-center">
                <b-col col lg="6">
                    <v-select   
                        v-model="docente_seleccionado"
                        :options="array_docente"                                              
                        :reduce="docente => docente" 
                        label="apn"
                        class="style-chooser"
                        placeholder="-- Elija un asesor --"                                                                                                             
                    > 
                        <template #search="{attributes, events}">
                            <input
                                class="vs__search"
                                :required="!docente_seleccionado"
                                v-bind="attributes"
                                v-on="events"
                            />
                        </template>
                        <template slot="no-options">
                            Opción no encontrada...
                        </template>
                    </v-select>
                </b-col>                    
                <b-col col lg="2">
                    <b-button style="height:34px" variant="success" size="sm" type="submit" title="Añadir" :disabled="asesor!=null">
                        <b-icon icon="plus-circle"></b-icon> Asignar
                    </b-button>
                </b-col>                    
            </b-row>  
        </b-form>        
        <table class="table table-bordered table-sm" v-if="asesor != null">   
            <thead>
                <th class="text-center">Nro. Documento</th> 
                <th class="text-left">Docente</th> 
                <th class="text-center">Tipo</th>                                                               
                <th class="text-center">Eliminar</th>
            </thead>
            <tbody>
                <tr>                              
                <td class="text-center" v-text="asesor.nro_documento"></td>
                <td class="text-left" v-text="asesor.apn"></td>
                <td class="text-center" v-text="asesor.tipo"></td>                                
                <td class="text-center">
                    <b-button variant="danger" size="sm" title="Eliminar asesor" @click="eliminarAsesor(asesor.id)">
                        <b-icon icon="trash"></b-icon>
                    </b-button>
                </td>                                                            
                </tr>                                                
            </tbody>
        </table>        
        <div v-if="errors.length" class="alert alert-danger" role="alert">
            <ul>
                <li v-for="(error, i) in errors" :key="i">{{ error }}</li>
            </ul>
        </div>          
    </div>    
</template>

<script>
export default {
    name: 'asesores',
    props: {        
        expediente: Object,
        idgrado_proc: String,    
        idusuario: String,                        
        ruta: Object
    },
    data() {
        return {             
            url: this.$root.API_URL,                                         
            asesor : null,  //object 
            docente_seleccionado : null,  //object              
            array_docente : [],                                                          
            errors: [], 
        }
    },
    methods: {                     
        getCandidatosAsesores() { // para mostrar una lista de asesores por facultad para que ser asignado
            let me = this       
            let formData = this._toFormData({
                idexpediente: this.expediente.id
            })

            this.axios.post(`${this.url}/Usuario/getDocentes`, formData)
            .then(function(response) {
                if (!response.data.error) {
                    me.array_docente = response.data.array_docente                                                                                                
                }
                else {
                    console.log(response.data.message)
                }
            })
        },
        getAsesor() {
            let me = this                  
            let formData = this._toFormData({
                idexpediente: this.expediente.id,
                idgrado_proc: this.idgrado_proc,
                idusuario: this.idusuario,                                
            })

            this.axios.post(`${this.url}/Persona/get_asesor`, formData)
            .then(function(response) {                 
                if (!response.data.error) {                
                    me.asesor = response.data.asesor
                }
                else {                
                    console.log(response.data.message)      
                }
            })    
        },          
        registrarAsesor() {                   
            let me = this            
            let formData = this._toFormData({              
              idexpediente: this.expediente.id,
              idgrado_proc: this.idgrado_proc,
              idusuario: this.idusuario,                  
              idruta: this.ruta.id,
              iddocente: this.docente_seleccionado.id,
              tipo: 'asesor'
            })           

            this.axios.post(`${this.url}/Persona/store`, formData)
                .then(function(response) {                                                 
                    me.resetearValores()                                   
                    if (!response.data.error) {                        
                        me.$root.mostrarNotificacion('Éxito!', 'success', 4000, 'done', response.data.message, 'bottom-right')
                        me.getAsesor()                           
                    }
                    else {
                        me.$root.mostrarNotificacion('Error!', 'danger', 4000, 'error_outline', response.data.message, 'bottom-right')                                                          
                    }                      
                })      
        },
        eliminarAsesor(id) {        
            let me = this        
            let formData = this._toFormData({
              id: id,          
              idexpediente: this.expediente.id,
              idgrado_proc: this.idgrado_proc,              
              tipo: 'asesor'    
            })  

            this.$bvModal.msgBoxConfirm(
                '¿Esta seguro de eliminar el asesor seleccionado?', {
                title: 'Eliminar asesor',                    
                okVariant: 'danger',
                okTitle: 'SI',
                cancelTitle: 'NO',          
                centered: true
            })
            .then(value => {
                if (value) {        
                    this.axios.post(`${this.url}/Persona/delete`, formData)
                    .then(function(response) {                                                   
                        me.resetearValores()  
                        me.asesor = null //docente nulo para obligar a agregar un docente
                        if (!response.data.error) {
                            me.$root.mostrarNotificacion('Éxito!', 'success', 4000, 'done', response.data.message, 'bottom-right')                          
                            me.getAsesor()                            
                        }
                        else {
                            me.$root.mostrarNotificacion('Error!', 'danger', 4000, 'error_outline', response.data.message, 'bottom-right')
                        }
                    })                
                }
            })                  
        },                
        resetearValores() {          
            this.docente_seleccionado = null                                                     
            this.errors = []               
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
        this.getAsesor()           
        this.getCandidatosAsesores()                 
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
    .style-chooser .vs__search::placeholder,
    .style-chooser .vs__dropdown-toggle,
    .style-chooser .vs__dropdown-menu {    
        max-height: 150px;
    }
</style>
