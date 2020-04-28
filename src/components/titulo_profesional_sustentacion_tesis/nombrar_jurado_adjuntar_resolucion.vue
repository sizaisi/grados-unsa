<template>
  <div class="p-3">     
    <b-card no-body>
        <b-tabs 
            v-model="tabIndex" 
            card        
            active-nav-item-class="font-weight-bold text-uppercase text-danger"   
            style="min-height: 250px"                        
        >
            <b-tab title="1. Designar jurados" title-item-class="disabledTab" :disabled="tabIndex2 < 0">
                <div class="row">
                    <div class="col-6 mx-auto">                
                        <div class="form-group row">
                            <div class="col-4">
                                <label for="id_fecha_sorteo" class="col-form-label">Fecha de sorteo: </label>
                            </div>
                            <div class="col-8">
                                <input type="date" v-model="fecha_sorteo" class="form-control" id="id_fecha_sorteo">
                            </div>
                        </div>                   
                    </div>
                </div>

                <div class="row mb-3">            
                    <div class="col-lg-12">
                        <b-form inline @submit.prevent="registrarJurado">                                                      
                            <b-form-select 
                                class="mr-3" 
                                v-model="jurado.tipo" 
                                :options="jurado_tipo" 
                                id="tipo_jurado"
                                required    
                            >
                            </b-form-select>                                                
                            <div class="col-lg-7">
                                <v-select   
                                    v-model="jurado.iddocente"                                                                                                                                              
                                    :options="array_jurado"                                              
                                    :reduce="jurado => jurado.iddocente" 
                                    label="apell_nombres"
                                    placeholder="-- Elija Jurado --"                                                                                                             
                                > 
                                    <template #search="{attributes, events}">
                                        <input
                                            class="vs__search"
                                            :required="!jurado.iddocente"
                                            v-bind="attributes"
                                            v-on="events"
                                        />
                                    </template>
                                    <template slot="no-options">
                                        Opción no encontrada...
                                    </template>
                                </v-select>
                            </div>
                            <b-button variant="success" size="sm" type="submit" title="Añadir">
                                <b-icon icon="plus-circle"></b-icon>
                            </b-button>
                        </b-form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <b-table                              
                            :items="array_expediente_jurado"
                            :fields="columnas_jurado"                              
                            striped
                            bordered  
                            small                                                
                            show-empty
                            empty-text="No hay jurados que mostrar."
                            primary-key="id"
                        >         
                            <template v-slot:cell(eliminar)="data">                                 
                                <b-button variant="danger" size="sm" data-toggle="tooltip" data-placement="left" title="Eliminar" @click="eliminarJurado(data.item.id, data.item.tipo)">
                                    <b-icon icon="trash"></b-icon>
                                </b-button>
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
            <b-tab title="2. Generar resolución" title-item-class="disabledTab" :disabled="tabIndex2 < 1">
                <form ref="frm_datos_pdf" :action="url_pdf" target="_blank" method="post">
                    <input type="hidden" name="expediente">      
                    <input type="hidden" name="array_jurado">                      
                    <input type="hidden" name="nombre_asesor" :value="nombre_asesor">   
                    <input type="hidden" name="fecha_sorteo" :value="fecha_sorteo">            
                    <template v-for="(graduando, index) in array_graduando">
                        <input type="hidden" name="array_nombres[]" :value="graduando.apell_nombres" :key="index">
                    </template>                        
                </form>                   
                <div class="row">
                    <div class="mx-auto"> 
                        <b-button @click="generarPdf" variant="success">
                            <b-icon icon="file-earmark-text"></b-icon> Generar resolución
                        </b-button> 
                    </div>
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
                        <b-button class="m-1" :variant="btn_color[ruta.etiqueta]" @click="mover(ruta)" :key="index">
                            {{ ruta.etiqueta | capitalize }}
                        </b-button>                 
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
  },
  data() {
    return {    
        tabIndex: 0,         
        tabIndex2: 0,      
        name : '',
        url: this.$root.API_URL,      
        url_pdf : `${this.$root.API_URL}/pdfs/titulo_profesional_sustentacion_tesis/resolucion_designacion_jurado.php`,      
        url_show_file : `${this.$root.API_URL}/utils/show_file.php`,      
        array_ruta : [],
        btn_color : this.$root.btn_colors,              
        fecha_sorteo : null, 
        array_expediente_jurado : [],
        array_jurado : [],
        array_documento : [],
        nombre_asesor : '',               
        movimiento : {
            idexpediente : '',
            idusuario : '',
            idruta : '',
            idgradproc_destino : '',               
        },                 
        columnas_jurado: [               
            { key: 'tipo', label: 'Tipo / Cargo', class: 'text-center' },
            { key: 'nombre', label: 'Docente', class: 'text-left' },
            { key: 'eliminar', label: 'Eliminar', class: 'text-center' }
        ],
        columnas_documento: [               
            { key: 'nombre', label: 'Nombre' },                        
            { key: 'acciones', label: 'Acciones', class: 'text-center' },            
        ],
        jurado_tipo: [
                { value: null, text: '--Seleccione tipo--', disabled: true },
                { value: 'presidente', text: 'Presidente', disabled: false },
                { value: 'secretario', text: 'Secretario', disabled: false},                  
                { value: 'suplente', text: 'Suplente', disabled: false }               
        ],
        jurado : {
            id : '',
            idexpediente: null,
            iddocente: null,
            tipo: null,
        },  
        documento : {
            id : '',
        },
        file: null,
        estaOcupado: false,
        errors: [],        
    }
  },
  methods: {
    mostrarArchivo() {                           
        this.$refs.show_file.submit()
    },
    prevTab() {
        this.tabIndex2--       
        this.tabIndex--        
    },  
    nextTab() {      
        let pasar = false
        
        if (this.tabIndex == 0) {
            pasar = this.validarTab1()
        }        
        if (this.tabIndex == 1) {
            pasar = true
        }        
        if (this.tabIndex == 2) {
            pasar = this.validarTab3()
        }        

        if (pasar) {
            this.tabIndex2++
            this.$nextTick(function () {
                this.tabIndex++        
            })  
        }              
    },   
    validarTab1() {
        this.errors = []

        if (!this.fecha_sorteo) {
            this.errors.push("El campo fecha de sorteo es requerido")
        }
        if (!this.array_expediente_jurado.length) {
            this.errors.push("La lista de jurados debe contener 1 o más elementos.")
        }             

        if (!this.errors.length) {
            return true
        }      

        return false
    },
    validarTab3() {
        this.errors = []       

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
        this.$refs.frm_datos_pdf.array_jurado.value = JSON.stringify(this.array_expediente_jurado)        
        this.$refs.frm_datos_pdf.submit()
    },
    getRutas() { // rutas del procedimiento
        let me = this
        var formData = this._toFormData({
            idgradproc_origen: this.idgrado_proc,            
        })        

        this.axios.post(`${this.url}/Ruta/getRutasByProc`, formData)
        .then(function(response) {
          if (!response.data.error) {              
            me.array_ruta = response.data.array_ruta                      
          }
          else {             
            console.log(response.data.message)                              
          }
        })   
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
              this.movimiento.idexpediente = this.expediente.id
              this.movimiento.idusuario = this.idusuario
              this.movimiento.idruta = ruta.id
              this.movimiento.idgradproc_destino = ruta.idgradproc_destino                     

              var formData = this._toFormData(this.movimiento)

              this.axios.post(`${this.url}/Movimiento/mover`, formData)
              .then(function(response) {                                          
                if (!response.data.error) { //si no hay error
                  me.movimiento.iddocente = ''                                     
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
          .catch(err => {
            console.log(err)
          })        
    },
    getNombreAsesor() { //para asignar al jurado
        let me = this      
        var formData = this._toFormData({
            idexpediente: this.expediente.id
        })

        this.axios.post(`${this.url}/Usuario/getNombreAsesor`, formData)
        .then(function(response) {
            if (!response.data.error) {                
                me.nombre_asesor = response.data.nombre_asesor                                                        
            }
            else {                
                console.log(response.data.message)      
            }
        })    
    },
    getExpedienteJurados() { // para obtener los jurados de la tabla usuario_expediente
        let me = this      
        let formData = this._toFormData({
            idexpediente: this.expediente.id
        })

        this.axios.post(`${this.url}/Usuario/getExpJurados`, formData)
        .then(function(response) {
            console.log(response)
            if (!response.data.error) {
                me.array_expediente_jurado = response.data.array_expediente_jurado  

                for (var i in me.array_expediente_jurado) {                        
                    //deshabilitar los tipos jurados registrados 
                    me.deshabilitarTipoJurado(me.array_expediente_jurado[i].tipo) 
                }                                   
            }
            else {
                console.log(response.data.message)      
            }
        })   
    },    
    getCandidatosJurados() { // para mostrar una lista de asesores por facultad para que ser asignado
        let me = this       
        let formData = this._toFormData({
            idexpediente: this.expediente.id
        })

        this.axios.post(`${this.url}/Usuario/getDocentes`, formData)
        .then(function(response) {
            if (!response.data.error) {
                me.array_jurado = response.data.array_docente                                                                                                
            }
            else {
                console.log(response.data.message)
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
    registrarJurado() {                        
        let me = this
        this.jurado.idexpediente = this.expediente.id               
        var formData = this._toFormData(this.jurado)

        this.axios.post(`${this.url}/Usuario/storeJurado`, formData)
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
                    me.getExpedienteJurados()                                            
                }                      
            })         
            
    },
    habilitarTipoJurado(tipo) {
        for (var i in this.jurado_tipo) {
            if (this.jurado_tipo[i].value == tipo) {
                this.jurado_tipo[i].disabled = false                     
                break
            }
        }                             
    },
    deshabilitarTipoJurado(tipo) {
        for (var i in this.jurado_tipo) {
            if (this.jurado_tipo[i].value == tipo) {
                this.jurado_tipo[i].disabled = true                     
                break
            }
        }                             
    },
    eliminarJurado(id, tipo) {        
        let me = this        
        this.jurado.id = id                            
        var formData = this._toFormData(this.jurado)

        this.$bvModal.msgBoxConfirm(
          '¿Esta seguro de eliminar el jurado seleccionado?', {
          title: 'Eliminar jurado',                    
          okVariant: 'danger',
          okTitle: 'SI',
          cancelTitle: 'NO',          
          centered: true
        })
          .then(value => {
            if (value) {        
                this.axios.post(`${this.url}/Usuario/deleteJurado`, formData)
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
                        me.habilitarTipoJurado(tipo)                            
                        me.getExpedienteJurados()
                    }
                })                
            }
        })                  
    },    
    registrarDocumento() {         
        let me = this                      
        let formData = this._toFormData({
            nombre: 'Resolución de nombramiento de jurado',
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
    eliminarDocumento(id) {
        let me = this                  
        this.documento.id = id                            
        var formData = this._toFormData(this.documento)

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
        this.jurado.id = ''
        this.jurado.idexpediente = ''                
        this.jurado.iddocente = ''                
        this.jurado.tipo = null         
        this.file = null   
        this.errors = []   
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
  filters: {
    capitalize: function (value) {
        if (!value) return ''
        value = value.toString()
        return value.charAt(0).toUpperCase() + value.slice(1)
    }
  },
  mounted: function() {        
    this.getRutas()           
    this.getExpedienteJurados()
    this.getCandidatosJurados()  
    this.getNombreAsesor()          
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
</style>