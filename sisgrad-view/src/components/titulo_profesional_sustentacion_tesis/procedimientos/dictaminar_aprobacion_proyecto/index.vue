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

    <template v-if="(estados[movimiento.etiqueta] == 'aprobado' || estados[movimiento.etiqueta] == 'enviado') && (ruta_seleccionada != null)">                 
      <aprobado_enviado_aprobar
        :grado_modalidad="grado_modalidad"
        :grado_procedimiento="grado_procedimiento"        
        :usuario="usuario"             
        :expediente="expediente"
        :graduando="graduando"
        :ruta="ruta_seleccionada"
        :movimiento="movimiento"
        v-if="ruta_seleccionada.etiqueta == 'aprobar'"                         
      />              
      <aprobado_enviado_denegar
        :grado_modalidad="grado_modalidad"
        :grado_procedimiento="grado_procedimiento"
        :usuario="usuario"               
        :expediente="expediente"
        :graduando="graduando"
        :ruta="ruta_seleccionada"
        :movimiento="movimiento"
        v-if="ruta_seleccionada.etiqueta == 'denegar'"                  
      />       
      <aprobado_enviado_rechazar
        :grado_modalidad="grado_modalidad"
        :grado_procedimiento="grado_procedimiento"
        :usuario="usuario"                
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
import aprobado_enviado_aprobar from './aprobado_enviado_aprobar.vue'
import aprobado_enviado_denegar from './aprobado_enviado_denegar.vue'
import aprobado_enviado_rechazar from './aprobado_enviado_rechazar.vue'


export default {  
  name: 'index',  
  props: {
    grado_modalidad: Object,
    grado_procedimiento: Object,    
    usuario: Object,       
    expediente: Object,
    graduando: Object,
    movimiento: Object,
  },
  components: {    
    aprobado_enviado_aprobar,
    aprobado_enviado_denegar,
    aprobado_enviado_rechazar,    
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
        let formData = this._toFormData({
            idgradproc_origen: this.grado_procedimiento.id,            
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