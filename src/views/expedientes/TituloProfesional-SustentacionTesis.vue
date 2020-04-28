<template>
  <div>      
   <div class="container" style="background-color: #fff; padding:20px;">                                    
      <div>
        <h5 class="text-center nav-link active font-weight-bold text-uppercase text-danger" v-text="grado_procedimiento.nombre"></h5>          
        <p class="narrow text-center" v-text="grado_procedimiento.descripcion"></p>
      </div>
      <b-card no-body class="p-3" bg-variant="light">
        <b-card no-body class="mb-3">
          <b-card-header class="p-1" header-text-variant="white" header-tag="header" role="tab">
            <b-button block href="#" v-b-toggle.accordion-1 variant="info">Información de Expediente</b-button>
          </b-card-header>
          <b-collapse id="accordion-1" visible role="tabpanel">
            <b-tabs pills card vertical>
                <b-tab title="Expediente">
                  <!-- Información expediente -->                                                                 
                  <div class="mb-4">
                    <h4 class="text-info text-center"><i class="fa fa-folder-open" aria-hidden="true"></i> Expediente</h4>
                  </div>           
                  <form>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                          <label class="text-info">Código</label>                                   
                          <label class="lbl-data" v-text="expediente.codigo"></label>                     
                        </div>
                        <div class="form-group col-md-9">
                          <label class="text-info">Título Proyecto</label>                                   
                          <label class="lbl-data" v-text="expediente.titulo"></label>                     
                        </div>
                    </div>               
                    <div class="form-row">
                        <div class="form-group col-md-6">
                          <label class="text-info">Programa de estudios</label>                                   
                          <label class="lbl-data" v-text="expediente.nesc"></label>                     
                        </div>
                        <div class="form-group col-md-6">
                          <label class="text-info">Fecha de inicio de trámite</label>                                   
                          <label class="lbl-data" v-text="expediente.fecha_inicio"></label>                     
                        </div>
                    </div>               
                  </form>                    
                </b-tab>
                <b-tab title="Graduando">
                  <!-- Información graduando -->                    
                  <div class="mb-4">
                    <h4 class="text-info text-center"><i class="fa fa-user" aria-hidden="true"></i> Graduando (s)</h4>
                  </div>            
                  <table class="table table-bordered table-sm">   
                    <thead>
                        <th class="text-center">CUI</th>
                        <th class="text-left">Apellidos y Nombres</th>
                        <th class="text-center">E-mail</th>                           
                        <th class="text-center">Teléfono</th>
                        <th class="text-left">Dirección</th>
                    </thead>
                    <tbody>
                        <tr v-for="(graduando, index) in array_graduando" :key="index">                              
                          <td class="text-center" v-text="graduando.cui"></td>
                          <td class="text-center" v-text="graduando.apell_nombres"></td>
                          <td class="text-center" v-text="graduando.email"></td>                              
                          <td class="text-center" v-text="graduando.telefono_movil"></td>
                          <td class="text-center" v-text="graduando.direccion"></td>
                        </tr>                                                
                    </tbody>
                  </table>
                  
                </b-tab>   
                <b-tab title="Archivos">
                  <!-- Información archivos -->                    
                  <div class="mb-4">
                    <h4 class="text-info text-center"><i class="fa fa-files-o" aria-hidden="true"></i> Archivos</h4>
                  </div>            
                  <table class="table table-bordered table-striped table-sm">                           
                      <thead>
                        <th class="text-center">Nombre </th>
                        <th class="text-center">Procedimiento</th>
                        <th class="text-center">Rol-Area</th>                           
                        <th class="text-center">Descargar</th>
                      </thead>
                      <tbody>                     
                        <form ref="show_file" :action="url_show_file" target="_blank" method="post">
                            <input type="hidden" name="file_id">                                            
                        </form>     
                        <tr v-for="(archivo, index) in array_archivo" :key="index">
                          <td v-text="archivo.nombre"></td>
                          <td v-text="archivo.procedimiento"></td>
                          <td class="text-center" v-text="archivo.area"></td>
                          <td class="text-center">                                                      
                            <b-button variant="info" size="sm" @click="mostrarArchivo(archivo.id)" title="Descargar">
                              <b-icon icon="download"></b-icon>
                            </b-button>
                          </td>                              
                        </tr>                                                
                      </tbody>
                  </table>                               
                </b-tab>               
            </b-tabs>
          </b-collapse>
        </b-card>
        <b-card no-body>
          <b-card-header class="p-1" header-text-variant="white" header-tag="header" role="tab">
            <b-button block href="#" v-b-toggle.accordion-2 variant="info">Procesamiento de Expediente</b-button>
          </b-card-header>  
          <b-collapse id="accordion-2" visible role="tabpanel">
            <!-- Compoenente del procedimiento -->                
            <component  :is="nombre_componente"                          
                        :idgrado_modalidad="grado_procedimiento.idgrado_modalidad"
                        :idgrado_proc="idgrado_proc"                        
                        :idusuario="idusuario"
                        :codi_usuario="codi_usuario"
                        :idrol_area="idrol_area"
                        :tipo_rol="tipo_rol"
                        :tipo_usuario="tipo_usuario"
                        :expediente="expediente"
                        :array_graduando="array_graduando"                       
                        v-if="array_graduando.length > 0"
            />  
          </b-collapse>
        </b-card>        

      </b-card>     
      
      <div class="text-center mt-3">                           
        <b-button 
          :to="{ name: 'menu-procedimientos', 
                 params: { 
                   idgrado_modalidad: grado_procedimiento.idgrado_modalidad, 
                   idgrado_proc: idgrado_proc, 
                   idusuario: idusuario,
                   codi_usuario: codi_usuario,
                   idrol_area: idrol_area,
                   tipo_rol: tipo_rol,
                   tipo_usuario: tipo_usuario
                 } 
              }" 
          variant="outline-warning"
        > 
          <b-icon icon="arrow-left-short"></b-icon>
          Volver
        </b-button>
      </div>      
   </div>   
</div>   
</template>
<script>
import tp_st_verificar_requisitos_grado 
  from '@/components/titulo_profesional_sustentacion_tesis/verificar_requisitos_grado.vue'
import tp_st_verificar_pertenencia_tema 
  from '@/components/titulo_profesional_sustentacion_tesis/verificar_pertinencia_tema.vue'
import tp_st_nombrar_jurado_adjuntar_resolucion 
  from '@/components/titulo_profesional_sustentacion_tesis/nombrar_jurado_adjuntar_resolucion.vue'
import tp_st_designar_docente_asesor_comision_calificacion_borrador
  from '@/components/titulo_profesional_sustentacion_tesis/designar_docente_asesor_comision_calificacion_borrador.vue'
import tp_st_resolver_asignacion_asesoria_proyecto
  from '@/components/titulo_profesional_sustentacion_tesis/resolver_asignacion_asesoria_proyecto.vue'
import tp_st_emitir_resolucion_asignacion_asesor_tema
  from '@/components/titulo_profesional_sustentacion_tesis/emitir_resolucion_asignacion_asesor_tema.vue'
import tp_st_dar_conformidad_asesoramiento_proyecto
  from '@/components/titulo_profesional_sustentacion_tesis/dar_conformidad_asesoramiento_proyecto.vue'
import tp_st_revisar_documentacion_proyecto
  from '@/components/titulo_profesional_sustentacion_tesis/revisar_documentacion_proyecto.vue'
import tp_st_dictaminar_aprobacion_proyecto
  from '@/components/titulo_profesional_sustentacion_tesis/dictaminar_aprobacion_proyecto.vue'
import tp_st_verificar_pagos_adjuntar_documentos
  from '@/components/titulo_profesional_sustentacion_tesis/verificar_pagos_adjuntar_documentos.vue'
import tp_st_emitir_acta_sustentacion
  from '@/components/titulo_profesional_sustentacion_tesis/emitir_acta_sustentacion.vue'
import tp_st_dictaminar_resultado_sustentacion
  from '@/components/titulo_profesional_sustentacion_tesis/dictaminar_resultado_sustentacion.vue'
import tp_st_emitir_acta_conformidad_redaccion_trabajo
  from '@/components/titulo_profesional_sustentacion_tesis/emitir_acta_conformidad_redaccion_trabajo.vue'
import tp_st_mostrar_tesis_pdf_copiar_url_repositorio
  from '@/components/titulo_profesional_sustentacion_tesis/mostrar_tesis_pdf_copiar_url_repositorio.vue'
import tp_st_aprobar_consejo_facultad_autorizar_emision_diploma
  from '@/components/titulo_profesional_sustentacion_tesis/aprobar_consejo_facultad_autorizar_emision_diploma.vue'
import tp_st_generar_imprimir_diploma
  from '@/components/titulo_profesional_sustentacion_tesis/generar_imprimir_diploma.vue'

export default {
  name: 'info-expediente',
  props: ['nombre_componente', 'idgrado_proc', 'idexpediente', 'idusuario', 'codi_usuario', 'idrol_area', 'tipo_rol', 'tipo_usuario'],
  components: {
    tp_st_verificar_requisitos_grado,
    tp_st_verificar_pertenencia_tema,
    tp_st_nombrar_jurado_adjuntar_resolucion,
    tp_st_designar_docente_asesor_comision_calificacion_borrador,
    tp_st_resolver_asignacion_asesoria_proyecto,
    tp_st_emitir_resolucion_asignacion_asesor_tema,
    tp_st_dar_conformidad_asesoramiento_proyecto,
    tp_st_revisar_documentacion_proyecto,
    tp_st_dictaminar_aprobacion_proyecto,
    tp_st_verificar_pagos_adjuntar_documentos,
    tp_st_emitir_acta_sustentacion,
    tp_st_dictaminar_resultado_sustentacion,
    tp_st_emitir_acta_conformidad_redaccion_trabajo,
    tp_st_mostrar_tesis_pdf_copiar_url_repositorio,
    tp_st_aprobar_consejo_facultad_autorizar_emision_diploma,
    tp_st_generar_imprimir_diploma
  },
  data() {
    return {     
      url: this.$root.API_URL,      
      url_show_file : `${this.$root.API_URL}/utils/show_file.php`,        
      grado_procedimiento : {},     
      expediente : {},  
      array_graduando : [], // autor y coautores del proyecto de graduacion
      array_archivo : [], // archivos del expediente                    
    }    
  },
  methods: {     
    mostrarArchivo(id) {               
        this.$refs.show_file.file_id.value = id
        this.$refs.show_file.submit()
    },        
    getGradoProcedimiento() {  // para mostrar el nombre del procedimiento seleccionado
        let me = this       

        var formData = this._toFormData({
            idgrado_procedimiento: this.idgrado_proc,            
        })

        this.axios.post(`${this.url}/GradoProcedimiento/getGradoProcedimiento`, formData)
        .then(function(response) {
          if (response.data.error) {
              me.errorMsg = response.data.message
          }
          else {
              me.grado_procedimiento = response.data.grado_procedimiento                                                         
          }
        })             
    },   
    getExpediente() {  // para mostrar los datos del expediente
        let me = this
        
        var formData = this._toFormData({
            idexpediente: this.idexpediente,
        })

        this.axios.post(`${this.url}/Expediente/getExpById`, formData)
        .then(function(response) {
          if (response.data.error) {
              me.errorMsg = response.data.message
          }
          else {
              me.expediente = response.data.expediente                                                  
          }
        })          
    },                                                             
    getGraduando() {  // para mostrar la informacion del graduando o graduandos
        let me = this       

        var formData = this._toFormData({
            idexpediente: this.idexpediente,
        })

        this.axios.post(`${this.url}/Usuario/getGradByIdExp`, formData)
        .then(function(response) {
          if (response.data.error) {
              me.errorMsg = response.data.message
          }
          else {
              me.array_graduando = response.data.array_graduando                                          
          }
        })               
    },   
    getArchivos() {
        let me = this
        var formData = this._toFormData({
            idexpediente: this.idexpediente,
        })       

        this.axios.post(`${this.url}/Archivo/index`, formData)
        .then(function(response) {
          if (response.data.error) {
              me.errorMsg = response.data.message
          }
          else {
              me.array_archivo = response.data.array_archivo                              
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
  mounted: function() { 
    
    if (this.idexpediente != null) { //si se ha establecido id del expediente      
      this.getGradoProcedimiento()
      this.getExpediente()
      this.getGraduando()
      this.getArchivos()                 
    }
    else {
      this.$router.push({ name: 'home' }); 
    }     
  },
}
</script>
<style scoped>
  .lbl-data {
   border: 0;
   padding: 0;
   font-weight: bold;
   display: block;
   width: 100%;   
   font-size: 1rem;
   margin-bottom: 0;    
 }
 
</style>

