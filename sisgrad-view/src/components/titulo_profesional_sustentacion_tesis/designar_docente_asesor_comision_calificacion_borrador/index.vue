<template>
  <div v-if="movimiento != null">
    <b-row class="justify-content-lg-center">
      <b-col col lg="8">
        <p class="text-justify">
          Expediente <b>{{ estados[movimiento.etiqueta] }}</b> por el procedimiento 
          <b>{{ movimiento.procedimiento_origen }}</b> a cargo de
          <b v-if="movimiento.administrativo != null">{{ movimiento.administrativo }}</b> 
          <b v-else>{{ movimiento.docente }}</b> 
          <b v-if="movimiento.rol_area_origen != null"> ({{ movimiento.rol_area_origen }})</b> 
          <b v-else> ({{ movimiento.tipo_rol }})</b> 
          con fecha <b>{{ movimiento.fecha }} hrs.</b>
        </p>                 
      </b-col>
    </b-row>

    <div class="row justify-content-center">
      <fieldset class="col-8 col-md-6 px-3">
        <legend>Elija una opción:</legend>
        <div class="row justify-content-center">      
          <template v-for="(ruta, index) in array_ruta">                             
            <b-form-radio 
              :key="index" 
              v-model="ruta_seleccionada" 
              :value="ruta"
              button
              name="acciones"
              button-variant="outline-primary"          
            >
              {{ ruta.etiqueta | capitalize }} Expediente
            </b-form-radio>            
          </template>                 
        </div>
      </fieldset>
    </div>   

    <template v-if="estados[movimiento.etiqueta] == 'aprobado' && ruta_seleccionada != null">           
      <aprobado_derivar
        :idgrado_modalidad="idgrado_modalidad"
        :idgrado_proc="idgrado_proc"
        :idusuario="idusuario"
        :codi_usuario="codi_usuario"
        :idrol_area="idrol_area"
        :tipo_rol="tipo_rol"
        :tipo_usuario="tipo_usuario"
        :expediente="expediente"
        :graduando="graduando"
        :ruta="ruta_seleccionada"                                        
        v-if="ruta_seleccionada.etiqueta == 'derivar'"                  
      />                             
    </template>          
    <template v-if="estados[movimiento.etiqueta] == 'denegado' && ruta_seleccionada != null">            
      <denegado_derivar
        :idgrado_modalidad="idgrado_modalidad"
        :idgrado_proc="idgrado_proc"
        :idusuario="idusuario"
        :codi_usuario="codi_usuario"
        :idrol_area="idrol_area"
        :tipo_rol="tipo_rol"
        :tipo_usuario="tipo_usuario"
        :expediente="expediente"
        :graduando="graduando"
        :movimiento="movimiento"          
        v-if="ruta_seleccionada.etiqueta == 'derivar'"                  
      />        
    </template>          
  </div>    
</template>

<script>
import aprobado_derivar from './aprobado_derivar.vue'
import denegado_derivar from './denegado_derivar.vue'

export default {   
  name: 'index',   
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
  components: {    
    aprobado_derivar,
    denegado_derivar
  },
  data() {
    return {             
      url: this.$root.API_URL,      
      movimiento : null,            
      array_ruta : [],   
      ruta_seleccionada: null,      
      estados : this.$root.estados,      
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
<style scoped>
  fieldset {    
    border-radius: 4px;
    border: 1px solid #ddd;
    height: 100px;
  }

  legend {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;    
    font-size: 14px;
    font-weight: bold;
    padding: 3px 5px 3px 7px;
    width: auto;
  }
</style>