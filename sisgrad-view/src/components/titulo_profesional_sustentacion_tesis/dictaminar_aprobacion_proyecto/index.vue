<template>
  <div v-if="movimiento != null">
    <div class="row justify-content-center mb-1">
      <fieldset class="col-10 col-md-8 px-3">
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
              class="m-2"                      
            >
              {{ ruta.etiqueta | capitalize }} Expediente
            </b-form-radio>            
          </template>                 
        </div>
      </fieldset>
    </div>   

    <template v-if="estados[movimiento.etiqueta] == 'aprobado' && ruta_seleccionada != null">                 
      <aprobado_aprobar
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
        :movimiento="movimiento"
        v-if="ruta_seleccionada.etiqueta == 'aprobar'"                         
      />              
      <aprobado_denegar
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
        :movimiento="movimiento"
        v-if="ruta_seleccionada.etiqueta == 'denegar'"                  
      />       
      <aprobado_rechazar
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
        :movimiento="movimiento"
        v-if="ruta_seleccionada.etiqueta == 'rechazar'"                  
      />                             
    </template>              
    <template v-else-if="estados[movimiento.etiqueta] == 'enviado' && ruta_seleccionada != null">                 
      <enviado_aprobar
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
        :movimiento="movimiento"
        v-if="ruta_seleccionada.etiqueta == 'aprobar'"                         
      />              
      <enviado_denegar
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
        :movimiento="movimiento"
        v-if="ruta_seleccionada.etiqueta == 'denegar'"                  
      />       
      <enviado_rechazar
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
        :movimiento="movimiento"
        v-if="ruta_seleccionada.etiqueta == 'rechazar'"                  
      />                             
    </template>              
  </div>    
</template>

<script>
import aprobado_aprobar from './aprobado_aprobar.vue'
import aprobado_denegar from './aprobado_denegar.vue'
import aprobado_rechazar from './aprobado_rechazar.vue'
import enviado_aprobar from './enviado_aprobar.vue'
import enviado_denegar from './enviado_denegar.vue'
import enviado_rechazar from './enviado_rechazar.vue'

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
    movimiento: Object,
  },
  components: {    
    aprobado_aprobar,
    aprobado_denegar,
    aprobado_rechazar,
    enviado_aprobar,
    enviado_denegar,
    enviado_rechazar
  },
  data() {
    return {             
      url: this.$root.API_URL,                 
      array_ruta : [],   
      ruta_seleccionada: null,      
      estados : this.$root.estados,  
    }
  },
  methods: {              
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
    }    
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