<template>
  <div>      
   <div class="container" style="background-color: #fff; padding:20px;">                                    
      <div>
        <h5 class="text-center nav-link active font-weight-bold text-uppercase text-danger" v-text="grado_procedimiento.nombre"></h5>          
        <p class="narrow text-center" v-text="grado_procedimiento.descripcion"></p>
      </div>
      <b-card no-body>
        <b-tabs card justified active-nav-item-class="font-weight-bold text-uppercase text-danger">  
          <b-tab title="Información de Expediente" active> 
            <b-card no-body>         
              <b-tabs pills card vertical>
                  <b-tab title="Expediente">
                    <!-- Información expediente -->                                                                 
                    <div class="mb-4">
                      <h4 class="text-info text-center"><i class="fa fa-folder-open" aria-hidden="true"></i> Expediente</h4>
                    </div>           
                    <form v-if="expediente != null">
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
                      <h4 class="text-info text-center"><i class="fa fa-user" aria-hidden="true"></i> Graduando</h4>
                    </div>    
                    <form v-if="graduando != null">
                      <div class="form-row">
                          <div class="form-group col-md-3">
                            <label class="text-info">CUI</label>                                   
                            <label class="lbl-data" v-text="graduando.cui"></label>                     
                          </div>
                          <div class="form-group col-md-9">
                            <label class="text-info">Apellidos y Nombres</label>                                   
                            <label class="lbl-data" v-text="graduando.apell_nombres"></label>                     
                          </div>
                      </div>               
                      <div class="form-row">
                          <div class="form-group col-md-3">
                            <label class="text-info">E-mail</label>                                   
                            <label class="lbl-data" v-text="graduando.email"></label>                     
                          </div>
                          <div class="form-group col-md-3">
                            <label class="text-info">Teléfono</label>                                   
                            <label class="lbl-data" v-text="graduando.telefono_movil"></label>                     
                          </div>
                          <div class="form-group col-md-6">
                            <label class="text-info">Dirección</label>                                   
                            <label class="lbl-data" v-text="graduando.direccion"></label>                     
                          </div>
                      </div>               
                    </form>                              
                  </b-tab> 
                  <b-tab title="Documentos">
                    <!-- Información todos archivos -->                    
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
            </b-card>
          </b-tab>
          <b-tab title="Información de Procedencia">  
            <b-card no-body>         
              <b-tabs pills card vertical>   
                  <b-tab title="Estado de Expediente">
                    <!-- Información procedimiento origen -->                                                                 
                    <div class="mb-4">
                      <h4 class="text-info text-center">Estado de Expediente</h4>
                    </div>         
                    <b-row class="justify-content-lg-center" v-if="movimiento != null">
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
                  </b-tab>                 
                  <b-tab title="Archivos adjuntos" v-if="array_archivo_ultimo.length > 0">                    
                    <!-- Archivos procedimiento origen -->                    
                    <div class="mb-4">
                      <h4 class="text-info text-center"><i class="fa fa-files-o" aria-hidden="true"></i> Archivos Adjuntos</h4>
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
                          <tr v-for="(archivo, index) in array_archivo_ultimo" :key="index">
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
                  <b-tab title="Observaciones">
                    <!-- Información observaciones recientes -->                                                                 
                    <div class="mb-4">
                      <h4 class="text-info text-center">Observaciones</h4>
                    </div>                               
                  </b-tab>   
              </b-tabs>        
            </b-card>            
          </b-tab>
          <b-tab title="Procesamiento de Expediente">                        
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
                        :graduando="graduando" 
                        :movimiento="movimiento"                      
                        v-if="graduando != null"
            />            
          </b-tab>
        </b-tabs>    
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
import verificar_requisitos_grado 
  from '@/components/titulo_profesional_sustentacion_tesis/verificar_requisitos_grado/index.vue'
import tp_st_verificar_pertenencia_tema 
  from '@/components/titulo_profesional_sustentacion_tesis/verificar_pertinencia_tema.vue'
import tp_st_nombrar_jurado_adjuntar_resolucion 
  from '@/components/titulo_profesional_sustentacion_tesis/nombrar_jurado_adjuntar_resolucion.vue'
import designar_docente_asesor_comision_calificacion_borrador
  from '@/components/titulo_profesional_sustentacion_tesis/designar_docente_asesor_comision_calificacion_borrador/index.vue'  
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
    verificar_requisitos_grado,
    tp_st_verificar_pertenencia_tema,
    tp_st_nombrar_jurado_adjuntar_resolucion,
    designar_docente_asesor_comision_calificacion_borrador,
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
      expediente : null,  
      graduando : null, // autor del proyecto de graduacion
      movimiento : null, // ultimo movimiento ingresado al procedimiento y expediente seleccionado
      estados : this.$root.estados,
      array_archivo : [], // archivos del expediente                    
      array_archivo_ultimo : [], // archivos del expediente del proc origen del ultimo movimiento 
    }    
  },
  methods: {  
    getLastMovimiento() {
      let me = this
      var formData = this._toFormData({
          idgradproc_destino: this.idgrado_proc, 
          idexpediente: this.idexpediente         
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
          if (!response.data.error) {
              me.graduando = response.data.graduando                                                        
          }
          else {
              console.log(response.data.message)
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
          if (!response.data.error) {
            me.array_archivo = response.data.array_archivo
          }
          else {              
            console.log(response.data.message)
          }
        })          
    },    
    getArchivosProcOrigen() {
        let me = this
        var formData = this._toFormData({
          idgrado_proc: this.idgrado_proc, //procedimiento actual seria el destino
          idexpediente: this.idexpediente,
        })       

        this.axios.post(`${this.url}/Archivo/show`, formData)
        .then(function(response) {          
          if (!response.data.error) {
            me.array_archivo_ultimo = response.data.array_archivo_ultimo
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
  mounted: function() { 
    
    if (this.idexpediente != null) { //si se ha establecido id del expediente      
      this.getLastMovimiento()
      this.getGradoProcedimiento()
      this.getExpediente()
      this.getGraduando()
      this.getArchivos()  
      this.getArchivosProcOrigen()               
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

