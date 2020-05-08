<template>
    <div>
    <b-card no-body>
        <b-tabs 
            v-model="tabIndex" 
            card        
            active-nav-item-class="font-weight-bold text-uppercase text-danger"   
            style="min-height: 250px"                        
          >   
            <b-tab title="1. Añadir observaciones" title-item-class="disabledTab" :disabled="tabIndex2 < 0">
                <b-form @submit.prevent="guardarObservaciones" class="mb-3">
                    <b-row class="justify-content-lg-center mb-2">
                        <b-col col lg="6">
                          <b-form-group
                            class="mb-0"
                            label="Observaciones:"
                            label-for="observaciones"                            
                          >
                            <b-form-textarea                          
                              id="observaciones"
                              v-model="observacion.descripcion"                            
                              placeholder="Ingrese al menos 30 caracteres"  
                              :state="observacion.descripcion.length >= 30"                            
                              required
                              rows="2"
                            ></b-form-textarea>                            
                          </b-form-group>
                        </b-col>                    
                    </b-row>
                    <b-row class="justify-content-lg-center">
                        <b-col col lg="6" class="text-right">
                            <b-button style="height:34px" variant="success" size="sm" type="submit" title="Guardar">
                              Guardar
                            </b-button>
                        </b-col>                    
                    </b-row>  
                </b-form>   
                <div class="row">
                  <div class="col-lg-12">
                    <b-table                              
                        :items="array_observaciones"
                        :fields="columnas_observaciones"                              
                        striped
                        bordered     
                        small                                             
                        show-empty
                        empty-text="No hay observaciones que mostrar."
                        primary-key="id"                        
                    >  
                      <template v-slot:cell(acciones)="data">                                                           
                          <b-button variant="warning" size="sm" title="Editar" @click="editarObservaciones(data.item)" class="mr-1">
                              <b-icon icon="pencil-square"></b-icon>
                          </b-button>
                          <b-button variant="danger" size="sm" @click="eliminarObservaciones(data.item.id)" title="Eliminar">
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
            <b-tab :title="'2. '+ruta.etiqueta.charAt(0).toUpperCase()+ruta.etiqueta.slice(1)+' expediente'" 
                   title-item-class="disabledTab" :disabled="tabIndex2 < 1">
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
            array_ruta : [],      
            btn_color : this.$root.btn_colors, 
            columnas_observaciones: [               
                { key: 'descripcion', label: 'Observaciones' },                        
                { key: 'acciones', label: 'Acciones', class: 'text-center' },            
            ],
            observacion : {
              id : null,
              descripcion : ''
            }, 
            array_observaciones : [],                    
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
            if (!this.array_observaciones.length) {
                this.errors.push("Debe registrar observaciones para el expediente seleccionado.")
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
        editarObservaciones(data) {          
          this.observacion = Object.assign({}, data)
        },
        guardarObservaciones() {
          if (this.observacion.id == null) {
            this.registrarObservaciones()
          }
          else {
            this.actualizarObservaciones()
          }            
        },         
        getObservaciones() {
          let me = this      
          var formData = this._toFormData({
            idgrado_proc: this.idgrado_proc,
            idusuario: this.idusuario,
            idexpediente: this.expediente.id
          })

          this.axios.post(`${this.url}/Observaciones/show`, formData)
          .then(function(response) {                
            if (!response.data.error) {                
              me.array_observaciones = response.data.array_observaciones
            }
            else {                
              console.log(response.data.message)      
            }
          })    
        },  
        registrarObservaciones() {   
            if (this.observacion.descripcion.length < 30) {
              this.errors = []
              this.errors.push("Debe ingresar al menos 20 caracteres.")
              return
            }        

            let me = this        
            let formData = this._toFormData({
              descripcion: this.observacion.descripcion,
              idgrado_proc: this.idgrado_proc,
              idusuario: this.idusuario,                  
              idexpediente: this.expediente.id
            })  

            this.axios.post(`${this.url}/Observaciones/store`, formData)
              .then(function(response) {      
                  me.resetearValores()
                  if (!response.data.error) {                        
                      me.$bvToast.toast(response.data.message, {
                          title: 'Éxito!',
                          variant: 'success',
                          toaster: 'b-toaster-bottom-right',                      
                      })
                      me.getObservaciones()                           
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
        actualizarObservaciones() {   
            if (this.observacion.descripcion.length < 30) {
              this.errors = []
              this.errors.push("Debe ingresar al menos 20 caracteres.")
              return
            }                   

            let me = this        
            let formData = this._toFormData({
              id: this.observacion.id,              
              descripcion: this.observacion.descripcion,              
            })  

            this.axios.post(`${this.url}/Observaciones/update`, formData)
              .then(function(response) {    
                  me.resetearValores()                                                                      
                  if (!response.data.error) {                        
                      me.$bvToast.toast(response.data.message, {
                          title: 'Éxito!',
                          variant: 'success',
                          toaster: 'b-toaster-bottom-right',                      
                      })
                      me.getObservaciones()                           
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
        eliminarObservaciones(id) {        
            let me = this                    
            let formData = this._toFormData({
              id: id,              
            })  

            this.$bvModal.msgBoxConfirm(
              '¿Esta seguro de eliminar estas observaciones?', {
              title: 'Eliminar asesor',                    
              okVariant: 'danger',
              okTitle: 'SI',
              cancelTitle: 'NO',          
              centered: true
            })
            .then(value => {
                if (value) {        
                    this.axios.post(`${this.url}/Observaciones/delete`, formData)
                    .then(function(response) {                           
                        me.resetearValores()
                        if (!response.data.error) {
                            me.$bvToast.toast(response.data.message, {
                                title: 'Éxito!',
                                variant: 'success',
                                toaster: 'b-toaster-bottom-right',                      
                            })                            
                            me.getObservaciones()                            
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
            this.observacion.id = null
            this.observacion.descripcion = ''                            
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
        this.getObservaciones()                 
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
