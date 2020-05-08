<template>
    <div>
    <b-card no-body>
        <b-tabs 
            v-model="tabIndex" 
            card        
            active-nav-item-class="font-weight-bold text-uppercase text-danger"   
            style="min-height: 250px"                        
          >   
            <b-tab title="1. Designar nuevo asesor" title-item-class="disabledTab" :disabled="tabIndex2 < 0">                                  
                <b-form @submit.prevent="registrarAsesor" class="mb-3">
                    <b-row class="justify-content-lg-center">
                        <b-col col lg="6">
                            <v-select   
                                v-model="docente"
                                :options="array_docente"                                              
                                :reduce="docente => docente" 
                                label="apn"
                                placeholder="-- Elija un asesor --"                                                                                                             
                            > 
                                <template #search="{attributes, events}">
                                    <input
                                        class="vs__search"
                                        :required="!docente"
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
                <div class="row">
                    <div class="col-lg-12">
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
                    </div>                     
                </div>                 
                <div v-if="errors.length" class="alert alert-danger" role="alert">
                    <ul>
                        <li v-for="(error, i) in errors" :key="i">{{ error }}</li>
                    </ul>
                </div>           
            </b-tab>
            <b-tab title="2. Generar documento" title-item-class="disabledTab" :disabled="tabIndex2 < 1">
              <b-form @submit.prevent="generarPdf"  ref="frm_datos_pdf" :action="url_pdf" target="_blank" method="post" class="mb-3">                                       
                <input type="hidden" name="expediente">                
                <input type="hidden" name="asesor_anterior" :value="movimiento.docente">                
                <input type="hidden" name="asesor_actual">                  
                <input type="hidden" name="apell_nombres" :value="array_graduando[0].apell_nombres">                                                                       
                <div class="row">
                  <div class="mx-auto"> 
                    <b-button type="submit" variant="success">
                        <b-icon icon="file-earmark-text"></b-icon> Resolución nuevo asesor
                    </b-button> 
                  </div>
                </div>
              </b-form>  
              <div v-if="errors.length" class="alert alert-danger" role="alert">
                <ul>
                  <li v-for="(error, i) in errors" :key="i">{{ error }}</li>
                </ul>
              </div>     
            </b-tab>       
            <b-tab title="3. Adjuntar documento" title-item-class="disabledTab" :disabled="tabIndex2 < 2">
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
                            <b-button type="submit" variant="success" title="Subir Archivo" :disabled="array_documento.length > 0">
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
            </b-tab>
            <b-tab title="4. Derivar expediente" title-item-class="disabledTab" :disabled="tabIndex2 < 3">
                <div class="text-center">                    
                    <template v-for="(ruta, index) in array_ruta">                            
                        <div :key="index" v-if="ruta.etiqueta == accion">
                            <b-row class="justify-content-lg-center">
                            <b-col col lg="8">
                                <p class="text-justify">
                                    <b>Nota: </b> La acción {{ ruta.etiqueta }} permite derivar el expediente al procedimiento 
                                    <b>{{ ruta.procedimiento_destino }}</b> a cargo de <b>{{ ruta.rol_area_destino }}</b>
                                </p>                 
                            </b-col>
                            </b-row>
                            <b-button class="m-1" :variant="btn_color[ruta.etiqueta]" @click="mover(ruta)">
                                {{ ruta.etiqueta | capitalize }}
                            </b-button>                                         
                        </div>                                            
                    </template>              
                </div> 
            </b-tab>
        </b-tabs>
    </b-card>
    <!-- Control buttons-->
    <div class="text-center">
        <b-button-group class="mt-3">
            <b-button class="mr-1" @click="prevTab" :disabled="tabIndex==0">Anterior</b-button>
            <b-button @click="nextTab" :disabled="tabIndex==3">Siguiente</b-button>
        </b-button-group>     
    </div>   
    </div>    
</template>

<script>
export default {
    name: 'denegado-derivar',
    props: {
        idgrado_modalidad: String,
        idgrado_proc: String,    
        idusuario: String,
        codi_usuario: String,
        idrol_area: String,
        tipo_rol: String,
        tipo_usuario: String,
        expediente: Object,
        array_graduando: Array,
        movimiento: Object,        
    },
    data() {
        return {             
            url: this.$root.API_URL,      
            tabIndex: 0,         
            tabIndex2: 0,              
            btn_color : this.$root.btn_colors, 
            url_pdf : `${this.$root.API_URL}/pdfs/titulo_profesional_sustentacion_tesis/resolucion_designacion_nuevo_asesor.php`,
            url_show_file : this.$root.FILE_URL,            
            asesor : null,  //object 
            docente : null,  //object  
            array_documento : [],   
            array_docente : [],         
            columnas_documento: [               
                { key: 'nombre', label: 'Nombre' },                        
                { key: 'acciones', label: 'Acciones', class: 'text-center' },            
            ],             
            usuario_expediente : {
                id : null,
                idexpediente: null,
                idusuario: null, 
                tipo : 'asesor'           
            }, 
            file: null,
            accion: 'derivar',
            estaOcupado: false,
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
                pasar = this.validarTab2()
            }        

            if (pasar) {
                this.tabIndex2++
                this.$nextTick(function () {
                    this.tabIndex++        
                })  
            }              
        },   
        validarTab1() {        
            if (!this.asesor) {
                this.errors.push("Debe agregar un asesor al expediente")
            }     
            
            if (this.movimiento.nro_doc_docente == this.asesor.nro_documento) {                
                this.errors.push('Debe cambiar al asesor renunciante')                
            }

            if (!this.errors.length) {
                return true
            }      

            return false
        },
        validarTab2() {   
            if (!this.array_documento.length) {
                this.errors.push("La lista de documentos debe contener 1 elemento.")
            }                

            if (!this.errors.length) {
                return true
            }      

            return false
        },
        generarPdf() {             
            this.$refs.frm_datos_pdf.expediente.value = JSON.stringify(this.expediente)   
            this.$refs.frm_datos_pdf.asesor_actual.value = JSON.stringify(this.asesor)                   
            this.$refs.frm_datos_pdf.submit()
        },                                               
        mover(ruta) { // movimiento para derivar el expediente al siguiente procedimiento
            this.$bvModal.msgBoxConfirm(
                '¿Esta seguro de ' + ruta.etiqueta + ' este expediente?', {
                title: ruta.etiqueta.charAt(0).toUpperCase()+ruta.etiqueta.slice(1),                    
                okVariant: this.btn_color[ruta.etiqueta],
                okTitle: 'SI',
                cancelTitle: 'NO',          
                centered: true
                })
                .then(value => {
                    if (value) {
                    let me = this                               
                    let formData = this._toFormData({
                            idexpediente: this.expediente.id,
                            idusuario: this.idusuario,
                            idruta: ruta.id,
                            idgradproc_destino: ruta.idgradproc_destino                     
                        })                                    

                    this.axios.post(`${this.url}/Movimiento/mover`, formData)
                    .then(function(response) {                                          
                        if (!response.data.error) { //si no hay error                                                      
                        me.$root.$bvToast.toast(response.data.message, {
                            title: 'Éxito!',
                            variant: 'success',
                            toaster: 'b-toaster-bottom-right',                      
                        })
                        me.$router.push({name: 'menu-procedimientos',                   
                                            params: { 
                                                idgrado_modalidad: me.idgrado_modalidad, 
                                                idgrado_proc: me.idgrado_proc, 
                                                idusuario: me.idusuario,
                                                codi_usuario: me.codi_usuario,
                                                idrol_area: me.idrol_area,
                                                tipo_rol: me.tipo_rol,
                                                tipo_usuario: me.tipo_usuario,
                                            }
                                        })                  
                        }
                        else {                           
                        me.$bvToast.toast(response.data.message, {
                            title: 'Error!',
                            variant: 'danger',
                            toaster: 'b-toaster-bottom-right',                    
                        })                    
                        }
                    }) 
                    }                   
                })              
        },
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
            var formData = this._toFormData({
                idexpediente: this.expediente.id
            })

            this.axios.post(`${this.url}/UsuarioExpediente/getAsesor`, formData)
            .then(function(response) {                
                if (!response.data.error) {                
                    me.asesor = response.data.asesor
                }
                else {                
                    //console.log(response.data.message)      
                }
            })    
        },          
        registrarAsesor() {        
            if (this.movimiento.nro_doc_docente == this.docente.nro_documento) {
                this.errors = []
                this.errors.push('Debe agregar un asesor diferente al asignado anteriormente')
                return
            }
            
            let me = this            
            this.usuario_expediente.idusuario = this.docente.id               
            this.usuario_expediente.idexpediente = this.expediente.id               
            var formData = this._toFormData(this.usuario_expediente)

            this.axios.post(`${this.url}/UsuarioExpediente/store`, formData)
                .then(function(response) {                    
                    me.resetearValores()                                   
                    if (!response.data.error) {                        
                        me.$bvToast.toast(response.data.message, {
                            title: 'Éxito!',
                            variant: 'success',
                            toaster: 'b-toaster-bottom-right',                      
                        })
                        me.getAsesor()                           
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
        eliminarAsesor(id) {        
            let me = this        
            this.usuario_expediente.id = id                            
            var formData = this._toFormData(this.usuario_expediente)

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
                    this.axios.post(`${this.url}/UsuarioExpediente/delete`, formData)
                    .then(function(response) {                           
                        me.resetearValores()  
                        me.asesor = null //docente nulo para obligar a agregar un docente
                        if (!response.data.error) {
                            me.$bvToast.toast(response.data.message, {
                                title: 'Éxito!',
                                variant: 'success',
                                toaster: 'b-toaster-bottom-right',                      
                            })                            
                            me.getAsesor()                            
                        }
                        else {
                            me.$bvToast.toast(response.data.message, {
                                title: 'Error!',
                                variant: 'danger',
                                toaster: 'b-toaster-bottom-right',                      
                            })
                        }
                    })                
                }
            })                  
        },        
        getDocumento() { // para mostrar una lista de documentos del procedimiento
            let me = this       
            let formData = this._toFormData({
                idgrado_proc: this.idgrado_proc,
                idusuario: this.idusuario,
                idexpediente: this.expediente.id
            })

            this.axios.post(`${this.url}/Archivo/getDocumento`, formData)
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
                nombre: 'Resolución designación nuevo asesor',
                data: this.file,
                idgrado_proc: this.idgrado_proc,
                idusuario: this.idusuario,
                idexpediente: this.expediente.id
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
                    if (response.data.error) {                        
                        me.$bvToast.toast(response.data.message, {
                            title: 'Error!',
                            variant: 'danger',
                            toaster: 'b-toaster-bottom-right',                      
                        })                       
                    }
                    else {
                        me.$bvToast.toast(response.data.message, {
                            title: 'Éxito!',
                            variant: 'success',
                            toaster: 'b-toaster-bottom-right',                      
                        })                    
                        me.getDocumento()                                                
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
                        if (response.data.error) {                        
                            me.$bvToast.toast(response.data.message, {
                                title: 'Error!',
                                variant: 'danger',
                                toaster: 'b-toaster-bottom-right',                      
                            })
                        }
                        else {
                            me.$bvToast.toast(response.data.message, {
                                title: 'Éxito!',
                                variant: 'success',
                                toaster: 'b-toaster-bottom-right',                      
                            })                        
                            me.getDocumento()
                        }
                    })                
                }
            })                
        },        
        resetearValores() {          
            this.docente = null                 
            this.usuario_expediente.id = null
            this.usuario_expediente.idexpediente = null
            this.usuario_expediente.idusuario = null            
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
    filters: {
        capitalize: function (value) {
            if (!value) return ''
            value = value.toString()
            return value.charAt(0).toUpperCase() + value.slice(1)
        }
    },
    mounted: function() {                   
        this.getAsesor()           
        this.getCandidatosAsesores()
        this.getDocumento()                
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
