<template>
    <div>
    <b-card no-body>
        <b-tabs 
            v-model="tabIndex" 
            card        
            active-nav-item-class="font-weight-bold text-uppercase text-danger"   
            style="min-height: 250px"                        
          >   
            <b-tab title="1. Designar asesor" title-item-class="disabledTab" :disabled="tabIndex2 < 0">                                  
                <b-form @submit.prevent="registrarAsesor" class="mb-3">
                    <b-row class="justify-content-lg-center">
                        <b-col col lg="6">
                            <v-select   
                                v-model="docente"
                                :options="array_docente"                                              
                                :reduce="docente => docente" 
                                label="apn"
                                class="style-chooser"
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
            <b-tab title="2. Derivar expediente" title-item-class="disabledTab" :disabled="tabIndex2 < 1">
                <div class="text-center">                   
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
            </b-tab>
        </b-tabs>
    </b-card>
    <!-- Control buttons-->
    <div class="text-center">
        <b-button-group class="mt-3">
            <b-button class="mr-1" @click="prevTab" :disabled="tabIndex==0">Anterior</b-button>
            <b-button @click="nextTab" :disabled="tabIndex==1">Siguiente</b-button>
        </b-button-group>     
    </div>   
    </div>    
</template>

<script>
export default {
    name: 'aprobado-derivar',
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
        ruta: Object            
    },
    data() {
        return {             
            url: this.$root.API_URL,      
            tabIndex: 0,         
            tabIndex2: 0,                
            btn_color : this.$root.btn_colors,           
            asesor : null,  //object 
            docente : null,  //object              
            array_docente : [],         
            usuario_expediente : {
                id : null,
                idexpediente: null,
                idusuario: null, 
                tipo : 'asesor'           
            },                                     
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
            if (!this.asesor) {
                this.errors.push("Debe agregar un asesor al expediente")
            }     

            if (!this.errors.length) {
                return true
            }      

            return false
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
        resetearValores() {          
            this.docente = null                 
            this.usuario_expediente.id = null
            this.usuario_expediente.idexpediente = null
            this.usuario_expediente.idusuario = null                        
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
