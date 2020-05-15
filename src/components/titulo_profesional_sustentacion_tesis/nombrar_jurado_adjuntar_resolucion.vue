<template>
  <div class="p-3 text-center">         
    <template v-for="(ruta, index) in array_ruta">                     
      <b-button class="m-1" :variant="btn_color[ruta.etiqueta]" @click="mover(ruta)" :key="index">
        {{ ruta.etiqueta | capitalize }}
      </b-button>                 
    </template>                 
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
    graduando: Object,
  },
  data() {
    return {             
      url: this.$root.API_URL,      
      array_ruta : [],
      btn_color : this.$root.btn_colors,           
      movimiento : {
          idexpediente : '',
          idusuario : '',
          idruta : '',
          idgradproc_destino : '',               
      },                                   
    }
  },
  methods: {    
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
            me.errorMsg = response.data.message
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
  },
}
</script>
