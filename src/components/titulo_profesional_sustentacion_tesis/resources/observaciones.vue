<template>
<div>    
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
                    rows="3"
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
        <div v-if="errors.length" class="alert alert-danger" role="alert">
            <ul><li v-for="(error, i) in errors" :key="i">{{ error }}</li></ul>
        </div>     
</div>    
</template>
<script>
export default {
    name: 'observaciones',
    props: {        
        idgrado_proc: String,    
        idusuario: String,        
        expediente: Object,        
        ruta: Object
    },
    data() {
        return {             
            url: this.$root.API_URL,                              
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
        cantidadObservaciones() {
            return this.array_observaciones.length
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
            this.errors = []

            if (this.observacion.descripcion.length < 30) {              
              this.errors.push("Debe ingresar al menos 30 caracteres.")
              return
            }        

            let me = this        
            let formData = this._toFormData({              
              idexpediente: this.expediente.id,
              idgrado_proc: this.idgrado_proc,
              idusuario: this.idusuario,                  
              idruta: this.ruta.id,
              descripcion: this.observacion.descripcion,
            })  

            this.axios.post(`${this.url}/Observaciones/store`, formData)
              .then(function(response) {                        
                  me.resetearValores()
                  if (!response.data.error) {                                              
                    me.$root.mostrarNotificacion('Éxito!', 'success', 4000, 'done', response.data.message, 'bottom-right')
                    me.getObservaciones()                           
                  }
                  else {
                    me.$root.mostrarNotificacion('Error!', 'danger', 4000, 'error_outline', response.data.message, 'bottom-right')
                  }                      
            })                        
        },
        actualizarObservaciones() {   
            this.errors = []
            
            if (this.observacion.descripcion.length < 30) {              
              this.errors.push("Debe ingresar al menos 30 caracteres.")
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
                    me.$root.mostrarNotificacion('Éxito!', 'success', 4000, 'done', response.data.message, 'bottom-right')
                    me.getObservaciones()                           
                  }
                  else {
                    me.$root.mostrarNotificacion('Error!', 'danger', 4000, 'error_outline', response.data.message, 'bottom-right')
                  }                      
            })    
        },
        eliminarObservaciones(id) {        
            let me = this                    
            let formData = this._toFormData({
              id: id,              
            })  

            this.$bvModal.msgBoxConfirm(
              '¿Seguro que quieres eliminar estas observaciones?', {
              title: 'Eliminar observaciones',                    
              okVariant: 'danger',
              okTitle: 'Eliminar',
              cancelTitle: 'Cancelar',          
              centered: true
            })
            .then(value => {
                if (value) {        
                    this.axios.post(`${this.url}/Observaciones/delete`, formData)
                    .then(function(response) {                                       
                        me.resetearValores()
                        if (!response.data.error) {
                            me.$root.mostrarNotificacion('Éxito!', 'success', 4000, 'done', response.data.message, 'bottom-right')
                            me.getObservaciones()                            
                        }
                        else {
                            me.$root.mostrarNotificacion('Error!', 'danger', 4000, 'error_outline', response.data.message, 'bottom-right')
                        }
                    })                
                }
            })                  
        },                        
        resetearValores() {                
            this.observacion.id = null
            this.observacion.descripcion = ''                                                    
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