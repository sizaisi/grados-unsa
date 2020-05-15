<template>
    <div>
        <b-form @submit.prevent="registrarDocumento" class="mb-3">                  
            <b-row>    
                <b-col sm="12" md="8" lg="8">
                    <b-form-file
                        v-model="file"                                    
                        placeholder="Seleccione un archivo..."                            
                        accept=".jpg, .png, .pdf"  
                        required                            
                    ></b-form-file>           
                </b-col>
                <b-col sm="12" md="4" lg="4">
                    <b-button type="submit" variant="success" title="Subir Archivo" :disabled="array_documento.length == max_docs">
                        <b-icon icon="upload"></b-icon>
                    </b-button>
                </b-col>
            </b-row>            
        </b-form>               

        <div class="row">
            <div class="col-lg-12">
                <b-table                              
                    :items="array_documento"
                    :fields="columnas_documento"                              
                    striped
                    bordered     
                    small                                             
                    show-empty
                    empty-text="No hay documentos que mostrar."
                    primary-key="id"
                    :busy="estaOcupado"
                >  
                    <template v-slot:cell(acciones)="data">                                 
                        <form ref="show_file" :action="url_show_file" target="_blank" method="post">
                            <input type="hidden" name="file_id" :value="data.item.id">                                            
                        </form>   
                        <b-button variant="info" size="sm" title="Descargar" @click="mostrarArchivo" class="mr-1">
                            <b-icon icon="download"></b-icon>
                        </b-button>
                        <b-button @click="eliminarDocumento(data.item.id)" variant="danger" size="sm" title="Eliminar">
                            <b-icon icon="trash"></b-icon>
                        </b-button>
                    </template> 
                    <template v-slot:table-busy>
                        <div class="text-center text-danger my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Cargando...</strong>
                        </div>
                    </template>                                                 
                </b-table>
            </div>
        </div> 
        <div v-if="errors.length" class="alert alert-danger" role="alert">
            <ul>
                <li v-for="(error, i) in errors" :key="i">{{ error }}</li>
            </ul>
        </div>            
    </div>    
</template>

<script>
export default {
    name: 'documentos',
    props: {        
        idgrado_proc: String,    
        idusuario: String,        
        expediente: Object,        
        ruta: Object,
        nombre_asignado : String,
        max_docs : String,        
    },
    data() {
        return {             
            url: this.$root.API_URL,                              
            url_show_file : this.$root.FILE_URL,                        
            array_documento : [],               
            columnas_documento: [               
                { key: 'nombre', label: 'Nombre' },                        
                { key: 'acciones', label: 'Acciones', class: 'text-center' },            
            ],                         
            file: null,            
            estaOcupado: false,
            errors: [], 
        }
    },
    methods: {           
        getDocumento() { // para mostrar una lista de documentos del procedimiento
            let me = this       
            let formData = this._toFormData({
                idgrado_proc: this.idgrado_proc,
                idusuario: this.idusuario,
                idexpediente: this.expediente.id
            })

            this.axios.post(`${this.url}/Archivo/get`, formData)
            .then(function(response) {                
                if (!response.data.error) {
                    me.array_documento = response.data.array_documento                    
                }
                else {
                    console.log(response.data.message)
                }
            })   
        },       
        registrarDocumento() {         
            let me = this                      
            let formData = this._toFormData({
                idexpediente: this.expediente.id,
                idgrado_proc: this.idgrado_proc,
                idusuario: this.idusuario,
                idruta: this.ruta.id,
                nombre_asignado: this.nombre_asignado,
                file: this.file,
            })       
            this.estaOcupado = true

            this.axios.post(`${this.url}/Archivo/store`, formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(response) {           
                    console.log(response.data)         
                    me.resetearValores()                                                         
                    if (!response.data.error) {                        
                        me.$root.mostrarNotificacion('Éxito!', 'success', 4000, 'done', response.data.message, 'bottom-right')
                        me.getDocumento()
                    }
                    else {
                        me.$root.mostrarNotificacion('Error!', 'danger', 4000, 'error_outline', response.data.message, 'bottom-right')                                                                    
                    }
            })         
        },          
        eliminarDocumento(iddocumento) {
            let me = this               
            let formData = this._toFormData({
                id: iddocumento
            })       

            this.$bvModal.msgBoxConfirm(
                '¿Esta seguro de eliminar el documento?', {
                title: 'Eliminar documento',                    
                okVariant: 'danger',
                okTitle: 'SI',
                cancelTitle: 'NO',          
                centered: true
            })
            .then(value => {
                if (value) {                         
                    this.axios.post(`${this.url}/Archivo/delete`, formData)
                    .then(function(response) {    
                        me.resetearValores()                       
                        if (!response.data.error) {                        
                            me.$root.mostrarNotificacion('Éxito!', 'success', 4000, 'done', response.data.message, 'bottom-right')
                            me.getDocumento()
                        }
                        else {
                            me.$root.mostrarNotificacion('Error!', 'danger', 4000, 'error_outline', response.data.message, 'bottom-right')                            
                        }
                    })                
                }
            })                
        },        
        resetearValores() {                              
            this.file = null   
            this.errors = []   
            this.estaOcupado = false                     
        },
        mostrarArchivo() {                           
            this.$refs.show_file.submit()
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
        this.getDocumento()                
    },
}
</script>
<style scoped>
    ul {
        margin-bottom: 0px;    
    }         
</style>