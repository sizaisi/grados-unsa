<template>
    <div>
        <b-form @submit.prevent="registrarDocumento" class="mb-3">                  
            <b-row v-if="array_opciones == null">    
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
                        <b-icon icon="plus-circle"></b-icon>
                    </b-button>
                </b-col>
            </b-row>            
            <b-row v-else> 
                <b-col sm="12" md="3" lg="3">
                    <b-form-select 
                        class="mr-3" 
                        v-model="opcion_documento" 
                        :options="array_opciones"                         
                        required    
                    >
                    </b-form-select> 
                </b-col>   
                <b-col sm="12" md="6" lg="6">
                    <b-form-file
                        v-model="file"                                    
                        placeholder="Seleccione un archivo..."                            
                        accept=".jpg, .png, .pdf"  
                        required                            
                    ></b-form-file>           
                </b-col>
                <b-col sm="12" md="3" lg="3">
                    <b-button type="submit" variant="success" title="Subir Archivo" :disabled="array_documento.length == max_docs">
                        <b-icon icon="plus-circle"></b-icon>
                    </b-button>
                </b-col>
            </b-row>
        </b-form>                       
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
                <form ref="show_file" :action="url_show_file" target="document-frame" method="post"> <!-- cambiar target a _blank para abrir pdf en nueva pestaña -->
                    <input type="hidden" name="file_id" :value="data.item.id">
                </form>                                   
                <b-button variant="warning" size="sm" title="Visualizar" @click="mostrarArchivo(data.item.nombre)" class="mr-1">
                    <b-icon icon="eye"></b-icon>
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

        <!--Inicio del modal-->
        <div class="modal fade centered-modal" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="nombre_documento"></h4>
                        <button type="button" class="close" aria-label="Close" @click="modal = 0">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe name="document-frame" :src="url_show_file"  width="660" height="380" frameborder="0" allowtransparency="true"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="modal = 0">Cerrar</button>                                          
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
                <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->        
    </div>    
</template>

<script>
export default {
    name: 'documentos',
    props: {        
        expediente: Object,
        idgrado_proc: String,    
        idusuario: String,                        
        ruta: Object,
        nombre_asignado : String,
        array_opciones: Array,
        max_docs : String,        
    },
    data() {
        return {             
            url: this.$root.API_URL,                              
            url_show_file : this.$root.API_URL+'/utils/show_file.php',                        
            array_documento : [],               
            columnas_documento: [               
                { key: 'nombre_asignado', label: 'Nombre documento' },
                { key: 'nombre_archivo', label: 'Nombre archivo' },                                                                              
                { key: 'acciones', label: 'Acciones', class: 'text-center' },            
            ],                         
            file: null,            
            estaOcupado: false,                            
            modal: 0,   
            nombre_documento: '',                     
            opcion_documento: null
        }
    },
    methods: {   
        cantidadDocumentos() {
            return this.array_documento.length
        },                
        mostrarArchivo(nombre_documento) {                           
            this.$refs.show_file.submit()            
            this.nombre_documento = nombre_documento
            this.modal = 1            
        },   
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
                    //console.log(response.data.message)
                }
            })   
        },       
        registrarDocumento() {         
            let me = this          
            let documento

            if (this.nombre_asignado != null) {
                documento = this.nombre_asignado
            }
            else {
                documento = this.opcion_documento
            }
            

            let formData = this._toFormData({
                idexpediente: this.expediente.id,
                idgrado_proc: this.idgrado_proc,
                idusuario: this.idusuario,
                idruta: this.ruta.id,
                nombre_asignado: documento,
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
            this.opcion_documento = null
            this.estaOcupado = false
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
    /* Modal styles */
    .modal .modal-dialog {
        max-width: 700px;
        margin: 3.75rem auto;
    }
    .modal .modal-header, .modal .modal-body, .modal .modal-footer {
        padding: 10px 20px;
        border-radius: 5px;
    }
    .modal .modal-content {
        border-radius: 5px;
    }
    .modal .modal-footer {
        background: #ecf0f1;
        border-radius: 5px;
    }
    .modal .modal-title {
        display: inline-block;
    }    
    .modal form label {
        font-weight: 600;
    }
    .modal-content {
        width: 100% !important;
        position: absolute !important;
        left: 0%;
        margin-top: 20px !important;
    }
    .mostrar {
        display: list-item !important;
        opacity: 1 !important;
        position: fixed !important;
        background: rgba(0, 0, 0, 0.6) !important;        
    }      
</style>