<template>
    <div class="text-center">                   
        <b-row class="justify-content-lg-center">
        <b-col col lg="8">
            <p class="text-justify">
                <b>Nota: </b> La acción {{ ruta.etiqueta }} permite derivar el expediente al procedimiento 
                <b>{{ ruta.procedimiento_destino }}</b> a cargo de <b>{{ ruta.rol_area_destino }}</b>
            </p>                 
        </b-col>
        </b-row>
        <b-button class="m-1" :variant="color_acciones[ruta.etiqueta]" @click="mover(ruta)">
            {{ ruta.etiqueta | capitalize }}
        </b-button>                                                           
    </div>            
</template>
<script>

export default {
    name: 'movimiento-expediente',
    props: {
        idgrado_modalidad: String,
        idgrado_proc: String,    
        idusuario: String,
        codi_usuario: String,
        idrol_area: String,
        tipo_rol: String,
        tipo_usuario: String,
        expediente: Object,        
        ruta: Object            
    },    
    data() {
        return {             
            url: this.$root.API_URL,                        
            color_acciones : this.$root.color_acciones            
        }
    },
    methods: {                    
        mover(ruta) { // movimiento para derivar el expediente al siguiente procedimiento
            this.$bvModal.msgBoxConfirm(
                '¿Seguro que quiere ' + ruta.etiqueta + ' este expediente?', {
                title: ruta.etiqueta.charAt(0).toUpperCase()+ruta.etiqueta.slice(1) + ' Expediente',                    
                okVariant: this.color_acciones[ruta.etiqueta],
                okTitle: ruta.etiqueta.charAt(0).toUpperCase()+ruta.etiqueta.slice(1),
                cancelTitle: 'Cancelar',          
                centered: true
            }).then(value => {
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
                        if (!response.data.error) {
                            me.$root.mostrarNotificacion('Éxito!', 'success', 5000, 'done', response.data.message, 'bottom-right')
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
                            me.$root.mostrarNotificacion('Error!', 'danger', 5000, 'error_outline', response.data.message, 'bottom-right')
                        }
                    }) 
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