<template>
    <div class="mb-3">    
        <!--<b-form class="mb-3" ref="frm_datos_pdf" @submit.prevent="generarPdf" :action="url_pdf+nombre_archivo_pdf" 
            target="frame" method="post">-->
        <b-form class="mb-3" ref="frm_datos_pdf" @submit.prevent="generarPdf" 
            :action="url_pdf+nombre_archivo_pdf" method="post">
            <input type="hidden" name="expediente">                
            <input type="hidden" name="movimiento">            
            <input type="hidden" name="asesor">                              
            <input type="hidden" name="graduando">
            <input type="hidden" name="jurados">                  
            <div class="row">
                <div class="mx-auto"> 
                    <b-button type="submit" variant="success">                        
                        <b-icon icon="file-earmark-arrow-down"></b-icon>                        
                        {{ boton_nombre }}
                    </b-button>
                </div>
            </div>
        </b-form>         
        <!--<iframe 
            name="frame" 
            :src="url_pdf+nombre_archivo_pdf"
            width="700" 
            height="580" 
            frameborder="0" 
            allowtransparency="true"
            :style="{ display: show_frame, margin: '0 auto'}"
        >
        </iframe>-->
    </div>
</template>
<script>
export default {
    name: 'resolucion-designacion-nuevo-asesor',
    props: {        
        expediente: Object,
        graduando: Object,            
        asesor: Object,      
        jurados: Array,
        nombre_archivo_pdf: String,  
        boton_nombre: String,        
    },
    data() {
        return {                                     
            url_pdf : `${this.$root.API_URL}/pdfs/titulo_profesional_sustentacion_tesis/`,
            show_frame: 'none'                        
        }
    },
    methods: {                    
        generarPdf() {             
            this.$refs.frm_datos_pdf.expediente.value = JSON.stringify(this.expediente)   
            this.$refs.frm_datos_pdf.graduando.value = JSON.stringify(this.graduando)               
            this.$refs.frm_datos_pdf.asesor.value = JSON.stringify(this.asesor)                   
            this.$refs.frm_datos_pdf.jurados.value = JSON.stringify(this.jurados) 
            this.$refs.frm_datos_pdf.submit()

            this.show_frame = 'block'
        },                                               
    }    
}
</script>