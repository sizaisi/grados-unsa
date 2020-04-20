<template>
  <div class="container text-center">
    <!--<ValidationProvider name="email" rules="required|email" v-slot="{ errors }">
      <input v-model="email" type="text">
      <span>{{ errors[0] }}</span>
    </ValidationProvider>-->
    <form ref="frm_datos_pdf" :action="url_pdf" target="_blank" method="post">
      <input type="hidden" name="codigo_expediente" :value="expediente.codigo">            
      <input type="hidden" name="titulo_proyecto" :value="expediente.titulo">                  
      <template v-for="(graduando, index) in array_graduando">
          <input type="hidden" name="array_nombres[]" :value="graduando.apell_nombres" :key="index">
      </template>                        
    </form>                   
    <b-button @click="generarPdf">Generar pdf</b-button>
    <template v-for="(ruta, index) in array_ruta">                     
      <b-button class="m-1" :variant="btn_color[ruta.etiqueta]" @click="mover(ruta)" :key="index">
        {{ ruta.etiqueta | capitalize }}
      </b-button>                 
    </template>                 
  </div>
</template>

<script>
import { extend } from 'vee-validate';
import { required, email } from 'vee-validate/dist/rules';

// No message specified.
extend('email', email);

// Override the default message.
extend('required', {
  ...required,
  message: 'This field is required'
});

export default {      
  props: {
    idgrado_modalidad: String,
    idgrado_proc: String,    
    idusuario: String,
    codi_usuario: String,
    idrol_area: String,
    expediente: Object,
    array_graduando: Array,
  },
  data() {
    return {       
      email: '',      
      url: this.$root.API_URL,
      url_pdf : `${this.$root.API_URL}/pdfs/titulo_profesional_sustentacion_tesis/pdf_emitir_resolucion_asesor_tema.php`,
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
    generarPdf() {              
      this.$refs.frm_datos_pdf.submit();   
    },
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
