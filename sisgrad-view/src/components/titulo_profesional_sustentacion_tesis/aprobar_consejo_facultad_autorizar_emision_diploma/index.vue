<template>
  <div v-if="movimiento != null">
    <div class="row justify-content-center mb-1">
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
              class="m-2"                      
            >
              {{ ruta.etiqueta | capitalize }} Expediente
            </b-form-radio>            
          </template>                 
        </div>
      </fieldset>
    </div>   

    <template v-if="estados[movimiento.etiqueta] == 'derivado' && ruta_seleccionada != null">                 
      <derivado_derivar
        :grado_modalidad="grado_modalidad"
        :grado_procedimiento="grado_procedimiento"
        :usuario="usuario"        
        :expediente="expediente"
        :graduando="graduando"
        :ruta="ruta_seleccionada"
        :movimiento="movimiento"
        v-if="ruta_seleccionada.etiqueta == 'derivar'"                         
      />                    
    </template>              
  </div>    
</template>

<script>
import derivado_derivar from './derivado_derivar.vue'

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
    derivado_derivar
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