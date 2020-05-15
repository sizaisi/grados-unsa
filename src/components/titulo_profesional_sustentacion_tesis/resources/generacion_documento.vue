<template>
    <div class="mb-3">    
        <b-form ref="frm_datos_pdf" @submit.prevent="generarPdf" :action="url_pdf+nombre_archivo_pdf" 
            target="_blank" method="post">
            <input type="hidden" name="expediente">                
            <input type="hidden" name="movimiento">            
            <input type="hidden" name="asesor">                  
            <input type="hidden" name="graduando">
            <div class="row">
                <div class="mx-auto"> 
                    <b-button type="submit" variant="success">
                        <b-icon icon="file-earmark-text"></b-icon> 
                        {{ boton_nombre }}
                    </b-button>
                </div>
            </div>
        </b-form>                
    </div>
</template>
<script>
export default {
    name: 'resolucion-designacion-nuevo-asesor',
    props: {        
        expediente: Object,
        graduando: Object,
        movimiento: Object,        
        asesor: Object,      
        nombre_archivo_pdf: String,  
        boton_nombre: String,        
    },
    data() {
        return {                                     
            url_pdf : `${this.$root.API_URL}/pdfs/titulo_profesional_sustentacion_tesis/`,                        
        }
    },
    methods: {                    
        generarPdf() {             
            this.$refs.frm_datos_pdf.expediente.value = JSON.stringify(this.expediente)   
            this.$refs.frm_datos_pdf.graduando.value = JSON.stringify(this.graduando)   
            this.$refs.frm_datos_pdf.movimiento.value = JSON.stringify(this.movimiento)   
            this.$refs.frm_datos_pdf.asesor.value = JSON.stringify(this.asesor)                   
            this.$refs.frm_datos_pdf.submit()
        },                                               
    }    
}
</script>