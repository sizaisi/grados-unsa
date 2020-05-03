<template>
  <div v-if="movimiento != null">     
    <template v-if="movimiento.etiqueta == 'aprobar'">
      <b-row class="justify-content-lg-center">
        <b-col col lg="8">
          <p class="text-justify">
            Expediente aprobado por el procedimiento <b>{{ movimiento.procedimiento_origen }}</b> 
            a cargo de <b>{{ movimiento.rol_area_origen }}</b> con fecha <b>{{ movimiento.fecha }} hrs.</b>
          </p>                 
        </b-col>
      </b-row>
      <b-card no-body>
        <div class="p-3 text-center">         
          <template v-for="(ruta, index) in array_ruta">                     
            <b-button class="m-1" :variant="btn_color[ruta.etiqueta]" @click="mover(ruta)" :key="index">
              {{ ruta.etiqueta | capitalize }}
            </b-button>                 
          </template>
        </div>  
      </b-card>
    </template>          
    <template v-if="movimiento.etiqueta == 'denegar'">
      <b-row class="justify-content-lg-center">
        <b-col col lg="8">
          <p class="text-justify">
            Expediente <b>denegado</b> por el procedimiento 
            <b>{{ movimiento.procedimiento_origen }}</b> a cargo de
            <b v-if="movimiento.nomb_oper!=null">{{ movimiento.nomb_oper }}</b> 
            <b v-else>{{ movimiento.apn }}</b> 
            <b v-if="movimiento.rol_area_origen!=null"> ({{ movimiento.rol_area_origen }})</b> 
            <b v-else> ({{ movimiento.tipo_rol }})</b> 
            con fecha <b>{{ movimiento.fecha }} hrs.</b>
          </p>                 
        </b-col>
      </b-row>
      <b-card no-body>
        <div class="p-3 text-center">         
          <h3>DENEGADO</h3>
        </div>  
      </b-card>
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
    array_graduando: Array,
  },
  data() {
    return {             
      url: this.$root.API_URL,      
      movimiento : null,
      array_ruta : [],
      btn_color : this.$root.btn_colors,                                                  
    }
  },
  methods: {    
    getLastMovimiento() {
        let me = this
        var formData = this._toFormData({
            idgradproc_destino: this.idgrado_proc, 
            idexpediente: this.expediente.id         
        })        

        this.axios.post(`${this.url}/Movimiento/getLastMovimientoByProc`, formData)
        .then(function(response) {
          if (!response.data.error) {              
            me.movimiento = response.data.movimiento         
            console.log(me.movimiento)              
          }
          else {              
            console.log(response.data.message)
          }
        })   
    },                       
    getRutas() {
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
    this.getLastMovimiento()                     
    this.getRutas()                     
  },
}
</script>
