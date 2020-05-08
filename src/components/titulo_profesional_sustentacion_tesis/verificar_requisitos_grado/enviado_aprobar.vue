<template>
    <div>
    <b-card no-body>
        <b-tabs 
            v-model="tabIndex" 
            card        
            active-nav-item-class="font-weight-bold text-uppercase text-danger"   
            style="min-height: 250px"                        
          >                      
            <b-tab :title="'1. '+ruta.etiqueta.charAt(0).toUpperCase()+ruta.etiqueta.slice(1)+' expediente'" 
                   title-item-class="disabledTab" :disabled="tabIndex2 < 0">
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
            <b-button @click="nextTab" :disabled="tabIndex==0">Siguiente</b-button>
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
                           
            if (pasar) {
                this.tabIndex2++
                this.$nextTick(function () {
                    this.tabIndex++        
                })  
            }              
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
    },
    filters: {
        capitalize: function (value) {
            if (!value) return ''
            value = value.toString()
            return value.charAt(0).toUpperCase() + value.slice(1)
        }
    },
    mounted: function() {                                 
        
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
