<template>
  <div>
    <div class="container" style="background-color: #fff; padding:20px;">
      <h5
        class="text-center font-weight-bold text-uppercase text-danger"
        v-text="grado_procedimiento.proc_nombre"
      ></h5>
      <p class="narrow text-center" v-text="grado_procedimiento.proc_descripcion"></p>
      <div class="text-center m-3">
        <b-button
          :to="{ name: 'bandeja', 
                      params: {                             
                          usuario: usuario,
                          grado_modalidad: grado_modalidad,
                          grado_procedimiento: grado_procedimiento,                               
                      } 
                }"
          variant="outline-info"
        >
          <b-icon icon="arrow-left-short"></b-icon>Atras
        </b-button>
      </div>
      <b-card no-body>
        <b-tabs card justified active-nav-item-class="font-weight-bold text-uppercase text-danger">
          <b-tab title="Información de Expediente" active>
            <b-card no-body>
              <b-tabs pills card vertical>
                <b-tab title="Expediente">
                  <!-- Información expediente -->
                  <div class="mb-3">
                    <h4 class="text-info text-center">
                      <i class="fa fa-folder-open" aria-hidden="true"></i> Expediente
                    </h4>
                  </div>
                  <b-card v-if="expediente != null">
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
                          <label class="lbl-data" v-text="expediente.escuela"></label>
                        </div>
                        <div class="form-group col-md-6">
                          <label class="text-info">Fecha de inicio de trámite</label>
                          <label class="lbl-data" v-text="expediente.fing"></label>
                        </div>
                      </div>
                    </form>
                  </b-card>
                </b-tab>
                <b-tab title="Graduando">
                  <!-- Información graduando -->
                  <div class="mb-3">
                    <h4 class="text-info text-center">
                      <i class="fa fa-user" aria-hidden="true"></i> Graduando
                    </h4>
                  </div>
                  <b-card v-if="graduando != null">
                    <form>
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
                  </b-card>
                </b-tab>
                <b-tab title="Documentos">
                  <!-- Información todos archivos -->
                  <div class="mb-3">
                    <h4 class="text-info text-center">
                      <i class="fa fa-files-o" aria-hidden="true"></i> Archivos
                    </h4>
                  </div>
                  <form ref="show_file" :action="url_show_file" target="my-frame" method="post">
                    <input type="hidden" name="file_id" />
                  </form>
                  <b-table
                    :items="array_archivo"
                    :fields="columnas_archivos"
                    striped
                    bordered
                    hover
                    small
                    responsive
                    show-empty
                    empty-text="No hay documentos que mostrar."
                    primary-key="id"
                  >
                    <template v-slot:cell(descargar)="data">
                      <b-button
                        variant="warning"
                        size="sm"
                        title="Descargar"
                        @click="mostrarArchivo(data.item.id, data.item.nombre)"
                      >
                        <b-icon icon="eye"></b-icon>
                      </b-button>
                    </template>
                  </b-table>
                </b-tab>
              </b-tabs>
            </b-card>
          </b-tab>
          <b-tab title="Información de Procedencia" v-if="movimiento != null">
            <b-card no-body>
              <b-tabs pills card vertical>
                <b-tab title="Estado de expediente">
                  <!-- Información procedimiento origen -->
                  <div class="mb-3">
                    <h4 class="text-info text-center">Estado de expediente</h4>
                  </div>
                  <b-row class="justify-content-lg-center">
                    <b-col col lg="10">
                      <table class="table table-bordered table-borderless">
                        <tbody>
                          <tr>
                            <th class="bg-light text-right">Procedimiento:</th>
                            <td v-text="movimiento.procedimiento_origen"></td>
                          </tr>
                          <tr>
                            <th class="bg-light text-right">Rol / Área:</th>
                            <td
                              v-if="movimiento.rol_area_origen != null"
                              v-text="movimiento.rol_area_origen"
                            ></td>
                            <td v-else v-text="movimiento.tipo_rol"></td>
                          </tr>
                          <tr>
                            <th class="bg-light text-right">Responsable:</th>
                            <td v-text="movimiento.nombre_usuario"></td>
                          </tr>
                          <tr>
                            <th class="bg-light text-right">Estado:</th>
                            <td>
                              <b-badge
                                :variant="color_acciones[movimiento.etiqueta]"
                                v-text="estados[movimiento.etiqueta]"
                                class="estado"
                              ></b-badge>
                            </td>
                          </tr>
                          <tr>
                            <th class="bg-light text-right">Fecha / Hora:</th>
                            <td v-text="movimiento.fecha + ' hrs.'">johncarter@mail.com</td>
                          </tr>
                        </tbody>
                      </table>
                    </b-col>
                  </b-row>
                </b-tab>
                <b-tab title="Archivos adjuntos" v-if="array_archivo_ultimo.length > 0">
                  <!-- Archivos procedimiento origen -->
                  <div class="mb-4">
                    <h4 class="text-info text-center">
                      <i class="fa fa-files-o" aria-hidden="true"></i> Archivos adjuntos
                    </h4>
                  </div>
                  <form
                    ref="show_file_ultimo"
                    :action="url_show_file"
                    target="my-frame"
                    method="post"
                  >
                    <input type="hidden" name="file_id" />
                  </form>
                  <b-table
                    :items="array_archivo_ultimo"
                    :fields="columnas_archivos_ultimo"
                    striped
                    bordered
                    borderless
                    responsive
                    show-empty
                    empty-text="No hay archivos que mostrar."
                    primary-key="id"
                  >
                    <template v-slot:cell(descargar)="data">
                      <b-button
                        variant="warning"
                        size="sm"
                        title="Descargar"
                        @click="mostrarArchivoUltimo(data.item.id, data.item.nombre)"
                      >
                        <b-icon icon="eye"></b-icon>
                      </b-button>
                    </template>
                  </b-table>
                </b-tab>
                <!--<b-tab title="Observaciones">
                    //Información observaciones procedimiento procedencia
                    <div class="mb-4">
                      <h4 class="text-info text-center">Observaciones</h4>
                    </div>                               
                </b-tab>-->
              </b-tabs>
            </b-card>
          </b-tab>
          <b-tab title="Procesamiento de Expediente" v-if="movimiento != null">
            <!-- Compoenente del procedimiento -->
            <component
              :is="nombre_componente"
              :grado_modalidad="grado_modalidad"
              :grado_procedimiento="grado_procedimiento"
              :usuario="usuario"
              :expediente="expediente"
              :graduando="graduando"
              :movimiento="movimiento"
              v-if="graduando != null"
            />
          </b-tab>
        </b-tabs>
      </b-card>
    </div>

    <!--Inicio del modal-->
    <div
      class="modal fade centered-modal"
      tabindex="-1"
      :class="{'mostrar' : modal}"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="nombre_documento"></h4>
            <button type="button" class="close" aria-label="Close" @click="modal = 0">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <iframe
              name="my-frame"
              :src="url_show_file"
              width="660"
              height="380"
              frameborder="0"
              allowtransparency="true"
            ></iframe>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="modal = 0">Cerrar</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
  </div>
</template>
<script>
import verificar_requisitos_grado from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/verificar_requisitos_grado/index.vue";
import verificar_pertinencia_tema from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/verificar_pertinencia_tema/index.vue";
import designar_asesor_comision_calificacion from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/designar_asesor_comision_calificacion/index.vue";
import resolver_asignacion_asesoria_proyecto from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/resolver_asignacion_asesoria_proyecto/index.vue";
import emitir_resolucion_asignacion_asesor_tema from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/emitir_resolucion_asignacion_asesor_tema/index.vue";
import dar_conformidad_asesoramiento_proyecto from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/dar_conformidad_asesoramiento_proyecto/index.vue";
import nombrar_jurado_adjuntar_resolucion from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/nombrar_jurado_adjuntar_resolucion/index.vue";
import revisar_documentacion_proyecto from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/revisar_documentacion_proyecto/index.vue";
import dictaminar_aprobacion_proyecto from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/dictaminar_aprobacion_proyecto/index.vue";
import verificar_pagos_adjuntar_documentos from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/verificar_pagos_adjuntar_documentos/index.vue";
import emitir_acta_dictamen from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/emitir_acta_dictamen/index.vue";
import dictaminar_resultado_sustentacion from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/dictaminar_resultado_sustentacion/index.vue";
import emitir_acta_conformidad_redaccion_trabajo from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/emitir_acta_conformidad_redaccion_trabajo/index.vue";
import aprobar_consejo_facultad_autorizar_emision_diploma from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/aprobar_consejo_facultad_autorizar_emision_diploma/index.vue";
import generar_imprimir_diploma from "@/components/titulo_profesional_sustentacion_tesis/procedimientos/generar_imprimir_diploma/index.vue";

export default {
  name: "info-expediente",
  props: {
    nombre_componente: String,
    usuario: Object,
    grado_modalidad: Object,
    grado_procedimiento: Object,
    idexpediente: String,
  },
  components: {
    verificar_requisitos_grado,
    verificar_pertinencia_tema,
    designar_asesor_comision_calificacion,
    resolver_asignacion_asesoria_proyecto,
    emitir_resolucion_asignacion_asesor_tema,
    dar_conformidad_asesoramiento_proyecto,
    nombrar_jurado_adjuntar_resolucion,
    revisar_documentacion_proyecto,
    dictaminar_aprobacion_proyecto,
    verificar_pagos_adjuntar_documentos,
    emitir_acta_dictamen,
    dictaminar_resultado_sustentacion,
    emitir_acta_conformidad_redaccion_trabajo,
    aprobar_consejo_facultad_autorizar_emision_diploma,
    generar_imprimir_diploma,
  },
  data() {
    return {
      url: this.$root.API_URL,
      url_show_file: `${this.$root.API_URL}/utils/show_file.php`,
      expediente: null,
      graduando: null, // autor del proyecto de graduacion
      movimiento: null, // ultimo movimiento ingresado al procedimiento y expediente seleccionado
      estados: this.$root.estados,
      color_acciones: this.$root.color_acciones,
      array_archivo: [], // archivos del expediente
      array_archivo_ultimo: [], // archivos del expediente del proc origen del ultimo movimiento
      columnas_archivos: [
        { key: "nombre", label: "Nombre", class: "text-left", sortable: true },
        {
          key: "procedimiento",
          label: "Procedimiento",
          class: "text-left",
          sortable: true,
        },
        {
          key: "area",
          label: "Rol-Area",
          class: "text-center",
          sortable: true,
        },
        { key: "descargar", label: "Archivo", class: "text-center" },
      ],
      columnas_archivos_ultimo: [
        { key: "nombre", label: "Nombre", class: "text-left" },
        { key: "procedimiento", label: "Procedimiento", class: "text-left" },
        { key: "area", label: "Rol-Area", class: "text-center" },
        { key: "descargar", label: "Archivo", class: "text-center" },
      ],
      modal: 0,
      nombre_documento: "",
    };
  },
  methods: {
    getLastMovimiento() {
      let me = this;
      let formData = this._toFormData({
        idgradproc_destino: this.grado_procedimiento.id,
        idexpediente: this.idexpediente,
      });

      this.axios
        .post(`${this.url}/Movimiento/ultimoMovimiento`, formData)
        .then(function (response) {
          if (!response.data.error) {
            me.movimiento = response.data.movimiento;
          } else {
            //console.log(response.data.message)
          }
        });
    },
    mostrarArchivo(id, nombre_documento) {
      this.$refs.show_file.file_id.value = id;
      this.$refs.show_file.submit();
      this.nombre_documento = nombre_documento;
      this.modal = 1;
    },
    mostrarArchivoUltimo(id, nombre_documento) {
      this.$refs.show_file_ultimo.file_id.value = id;
      this.$refs.show_file_ultimo.submit();
      this.nombre_documento = nombre_documento;
      this.modal = 1;
    },
    getExpediente() {
      // para mostrar los datos del expediente
      let me = this;

      let formData = this._toFormData({
        idexpediente: this.idexpediente,
      });

      this.axios
        .post(`${this.url}/Expediente/getExpById`, formData)
        .then(function (response) {
          if (!response.data.error) {
            me.expediente = response.data.expediente;
          } else {
            //console.log(response.data.message)
          }
        });
    },
    getGraduando() {
      // para mostrar la informacion del graduando o graduandos
      let me = this;
      let formData = this._toFormData({
        idexpediente: this.idexpediente,
      });

      this.axios
        .post(`${this.url}/GraduandoExpediente/getGraduando`, formData)
        .then(function (response) {
          if (!response.data.error) {
            me.graduando = response.data.graduando;
          } else {
            //console.log(response.data.message)
          }
        });
    },
    getArchivos() {
      let me = this;
      var formData = this._toFormData({
        idexpediente: this.idexpediente,
      });

      this.axios
        .post(`${this.url}/Archivo/index`, formData)
        .then(function (response) {
          if (!response.data.error) {
            me.array_archivo = response.data.array_archivo;
          } else {
            //console.log(response.data.message)
          }
        });
    },
    getArchivosProcOrigen() {
      let me = this;
      var formData = this._toFormData({
        idgrado_proc: this.grado_procedimiento.id, //procedimiento actual seria el destino
        idexpediente: this.idexpediente,
      });

      this.axios
        .post(`${this.url}/Archivo/show`, formData)
        .then(function (response) {
          if (!response.data.error) {
            me.array_archivo_ultimo = response.data.array_archivo_ultimo;
          } else {
            //console.log(response.data.message)
          }
        });
    },
    _toFormData(obj) {
      var fd = new FormData();

      for (var i in obj) {
        fd.append(i, obj[i]);
      }

      return fd;
    },
  },
  mounted: function () {
    if (this.idexpediente != null) {
      //si se ha establecido id del expediente
      this.getLastMovimiento();
      this.getExpediente();
      this.getGraduando();
      this.getArchivos();
      this.getArchivosProcOrigen();
    } else {
      this.$router.push({ name: "home" });
    }
  },
};
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
.estado {
  font-size: 0.8em;
}
/* Modal styles */
.modal .modal-dialog {
  max-width: 700px;
  margin: 3.75rem auto;
}
.modal .modal-header,
.modal .modal-body,
.modal .modal-footer {
  padding: 10px 20px;
  border-radius: 5px;
}
.modal .modal-content {
  border-radius: 5px;
}
.modal .modal-footer {
  background: #ecf0f1;
  border-radius: 5px;
}
.modal .modal-title {
  display: inline-block;
}
.modal form label {
  font-weight: 600;
}
.modal-content {
  width: 100% !important;
  position: absolute !important;
  left: 0%;
  margin-top: 20px !important;
}
.mostrar {
  display: list-item !important;
  opacity: 1 !important;
  position: fixed !important;
  background: rgba(0, 0, 0, 0.6) !important;
}
</style>

