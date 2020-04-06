<template>
  <div>
    <div class="container-fluid pt-2 pb-3" style="background-color: #fff;">
        <div class="row mt-3">
          <div class="col-lg-6">
              <h3 class="text-info">Rutas</h3>
          </div>
          <div class="col-lg-6">
            <button class="btn btn-info float-right" @click="abrirAddEditModal('registrar')">
              <i class="fa fa-plus"></i>&nbsp;Nuevo Registro
            </button>
          </div>
        </div>
        <hr class="bg-info">
        <b-alert
          v-if="errorMsg"
          :show="dismissCountDown"
          dismissible
          variant="danger"
          @dismissed="dismissCountDown=0"
          @dismiss-count-down="_countDownChanged"
        >
          {{ errorMsg }}
        </b-alert>

        <b-alert
          v-if="successMsg"
          :show="dismissCountDown"
          dismissible
          variant="success"
          @dismissed="dismissCountDown=0"
          @dismiss-count-down="_countDownChanged"
        >
          {{ successMsg }}
        </b-alert>
        <div class="row">
          <div class="col-lg-12">
                <b-row>
                  <b-col md="4" class="my-1">
                      <b-form-group label-cols-sm="6" label="Registros por página: " class="mb-0">
                          <b-form-select v-model="perPage" :options="pageOptions"></b-form-select>
                      </b-form-group>
                  </b-col>
                  <b-col offset-md="4" md="4" class="my-1">
                      <b-form-group label-cols-sm="3" label="Buscar: " class="mb-0">
                          <b-input-group>
                              <b-form-input v-model="filter" placeholder="Escriba el texto a buscar..."></b-form-input>
                              <!--<b-input-group-meend>
                                  <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                              </b-input-group-meend>-->
                          </b-input-group>
                      </b-form-group>
                  </b-col>                        
                </b-row>
                <b-table
                  id="tbl-rutas"
                  :items="array_ruta"
                  :fields="columnas"
                  thead-tr-class="bg-info text-light"
                  striped
                  bordered
                  primary-key="idruta"
                  :tbody-transition-props="transProps"
                  :current-page="currentPage"
                  :per-page="perPage"
                  :filter="filter"
                  @filtered="onFiltered"               
                >
                  <template v-slot:cell(condicion)="data">
                    <b-badge v-if="data.item.condicion == 1" variant='success'>Activo</b-badge>
                    <b-badge v-else variant='secondary'>Inactivo</b-badge>
                  </template>
                  <template v-slot:cell(acciones)="data">
                    <b-button variant="warning" size="sm" data-toggle="tooltip" data-placement="left" title="Editar" @click="abrirAddEditModal('actualizar', data.item)"><i class="fa fa-edit"></i></b-button>
                    <b-button variant="danger" size="sm" data-toggle="tooltip" data-placement="left" title="Desactivar" @click="abrirDeleteModal('desactivar', data.item)" v-if="data.item.condicion == 1"><i class="fa fa-times"></i></b-button>
                    <b-button variant="success" size="sm" data-toggle="tooltip" data-placement="left" title="Activar" @click="abrirDeleteModal('activar', data.item)" v-else><i class="fa fa-check"></i></b-button>
                  </template>
                </b-table>
                <b-row>
                  <b-col offset-md="6" md="6" class="my-1">
                    <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    class="my-0"
                    align="right"
                    ></b-pagination>
                  </b-col>
                </b-row> 
          </div>
        </div>
    </div>

    <!--modal add edit-->
    <div class="overlay" v-show="showAddEditModal">
      <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                    <h5 class="modal-title" v-text="titleAddEditModal"></h5>
                    <button type="button" class="close" @click="cerrarAddEditModal">
                          <span aria-hidden="true">&times;</span>
                    </button>
              </div>
              <div class="modal-body">
                <form role="form">
                    <div class="form-group">
                      <div class="form-group">
                        <label for="gm_select">Grado x Modalidad:</label>
                        <b-form-select v-if="tipoAccion=='actualizar'" id="gm_select" :options="select_grado_modalidad" v-model="idgrado_modalidad" disabled></b-form-select>
                        <b-form-select v-else id="gm_select" :options="select_grado_modalidad" v-model="idgrado_modalidad"></b-form-select>
                      </div>
                      <div class="form-group">
                        <label for="grad_proc_select1">Grado Procedimiento Origen:</label>
                        <b-form-select id="grad_proc_select1" :options="select_grado_procedimiento_origen" v-model="ruta.idgradproc_origen"></b-form-select>
                      </div>
                      <div class="form-group">
                        <label for="grad_proc_select2">Grado Procedimiento Destino:</label>
                        <b-form-select id="grad_proc_select2" :options="select_grado_procedimiento_destino" v-model="ruta.idgradproc_destino"></b-form-select>
                      </div>
                      <div class="form-group">
                        <label for="etiqueta-select">Etiqueta:</label>
                        <b-form-select id="etiqueta-select" v-model="ruta.etiqueta" :options="etiquetas"></b-form-select>       
                      </div>                      
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="cerrarAddEditModal">Cancelar</button>
                  <button v-if="tipoAccion=='registrar'" type="button" @click="registrarRuta" class="btn btn-success">Guardar</button>
                  <button v-if="tipoAccion=='actualizar'" type="button" @click="actualizarRuta" class="btn btn-success">Actualizar</button>
              </div>
            </div>
      </div>
    </div>

    <!-- Modal activar desactivar -->
    <div class="overlay" v-show="showDeleteModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <form>
            <div class="modal-header">
              <h5 class="modal-title" v-text="titleDeleteModal"></h5>
              <button type="button" class="close" aria-hidden="true" @click="cerrarDeleteModal">&times;</button>
            </div>
            <div class="modal-body">
              <h5 class="text-danger text-center" v-text="messageDeleteModal"></h5>              
            </div>
            <div class="modal-footer">
              <b-button variant="secondary" @click="cerrarDeleteModal">Cancelar</b-button>
              <b-button variant="success" @click="anularRuta">Aceptar</b-button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- fin modal activar / desactivar -->
</div>
</template>

<script>

export default {
    name: 'programa-estudios',  
    data() {
        return { 
            url: 'http://localhost/backend/controlador/',
            array_ruta : [],
            select_grado_modalidad: [],
            select_grado_procedimiento_origen: [],
            select_grado_procedimiento_destino: [],
            select_rol_area: [],
            idgrado_modalidad: '',
            ruta : {
              id: '',              
              idgradproc_origen: '',              
              idgradproc_destino: '',              
              etiqueta : '',              
            },
            titleAddEditModal : '',
            titleDeleteModal : '',
            messageDeleteModal : '',
            showAddEditModal : false,
            showDeleteModal : false,
            tipoAccion : '',
            errorMsg : "",
            successMsg : "",
            dismissSecs: 3,
            dismissCountDown: 0,
            transProps: {
              // Transition name
              name: 'flip-list'
            },
            etiquetas : ['iniciar', 
                         'enviar',
                         'derivar', 
                         'aceptar',
                         'aprobar',
                         'devolver',                          
                         'denegar',
                         'observar',
                         'rechazar',                                                  
                         'finalizar'],
            columnas: [
              { key: 'idruta', label: 'ID', sortable: true, class: 'text-center' },
              { key: 'nombre_gradotitulo', label: 'Nombre del Grado/Título', sortable: true },
              { key: 'nombre_modobtencion', label: 'Nombre de la modalidad', sortable: true },
              { key: 'nombre_proc_origen', label: 'Procedimiento Origen', sortable: true},
              { key: 'nombre_proc_destino', label: 'Procedimiento Destino', sortable: true},              
              { key: 'etiqueta', label: 'Etiqueta', class: 'text-center' },
              { key: 'condicion', label: 'Condición', class: 'text-center' },              
              { key: 'acciones', label: 'Acciones', class: 'text-center' }
            ],
            totalRows: 1,
            currentPage: 1,
            perPage: 5,
            pageOptions: [5, 10, 15],
            filter: null,                                           
        }
    },
    watch: {
        idgrado_modalidad: function(val) {    
            let me=this
          if (val != '') {
            this.axios.get(this.url+"RutaController.php?action=getListGradProcedimientos", {
              params: {
                  'idgrado_modalidad': this.idgrado_modalidad
              }
            })
            .then(function(response) {
              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else {
                me.select_grado_procedimiento_origen = [] //reiniciamos el arreglo
                me.select_grado_procedimiento_destino = [] //reiniciamos el arreglo                

                me.select_grado_procedimiento_origen.push({value: 0, text: 'Inicio'}) //virtualizacion de proc inicio

                for (var grad_proc of response.data.array_grado_procedimiento) {
                  me.select_grado_procedimiento_origen.push({value: grad_proc.idgradoproc, text: grad_proc.proc_nombre})
                  me.select_grado_procedimiento_destino.push({value: grad_proc.idgradoproc, text: grad_proc.proc_nombre})
                }               

                me.select_grado_procedimiento_destino.push({value: 0, text: 'Fin'}) //virtualizacion de proc fin
              }
            })
          }               
        }
      },
      methods: {
        getAllRutas() {
            let me=this
            this.axios.get(this.url+"RutaController.php?action=read")
              .then(function(response) {
                if (response.data.error) {
                  me.errorMsg = response.data.message;
                }
                else {
                  me.array_ruta = response.data.array_ruta;
                  me.totalRows = me.array_ruta.length;                  
                }
            });
        },
        getListGradModalidad() {
            let me=this
            this.axios.post(this.url+ "RutaController.php?action=getListGradModalidad")
              .then(function (response){
                if (response.data.error) {
                  me.errorMsg = response.data.message;
                }
                else{
                  for(var gradmod of response.data.array_grado_modalidad){
                      me.select_grado_modalidad.push({value: gradmod.id, text: gradmod.gradname + ' / ' + gradmod.movname})
                  }
                }
            });
        },
        abrirAddEditModal(accion, data = []) {
            this.showAddEditModal = true
            this.errors.clear()

            switch(accion) {
                case 'registrar':
                {
                    this.titleAddEditModal = 'Registrar Ruta'
                    this.ruta.id = ''
                    this.tipoAccion = 'registrar'
                    break
                }
                case 'actualizar':
                {                    
                    this.titleAddEditModal = 'Actualizar Ruta'
                    this.idgrado_modalidad = data.idgrado_modalidad
                    this.ruta.id = data.idruta
                    this.ruta.idgradproc_origen = data.idgradproc_origen
                    this.ruta.idgradproc_destino = data.idgradproc_destino
                    this.ruta.etiqueta = data.etiqueta
                    
                    this.tipoAccion = 'actualizar'
                    break
                }
            }
        },
        registrarRuta() {
            let me=this

            if (!this.errors.any()) {
              var formData = this._toFormData(this.ruta)

              this.axios.post(this.url+"RutaController.php?action=store", formData)
                .then(function(response) {
                  me.cerrarAddEditModal();
                  me.dismissCountDown = me.dismissSecs //contador para el alert

                  if (response.data.error) {
                    me.errorMsg = response.data.message
                  }
                  else {
                    me.successMsg = response.data.message
                    me.getAllRutas()
                  }
              })
            }
        },
        actualizarRuta() {
            let me=this

            if (!this.errors.any()) {
              var formData = this._toFormData(this.ruta)

              this.axios.post(this.url+"RutaController.php?action=update", formData)
                .then(function(response) {
                  me.cerrarAddEditModal();
                  me.dismissCountDown = me.dismissSecs //contador para el alert

                  if (response.data.error) {
                    me.errorMsg = response.data.message
                  }
                  else {
                    me.successMsg = response.data.message
                    me.getAllRutas()
                  }
              })
            }
        },
        cerrarAddEditModal() {
          this.showAddEditModal = false
          this.idgrado_modalidad = ''
          this.ruta.id = ''            
          this.ruta.idgradproc_origen = ''
          this.ruta.idgradproc_destino = ''
          this.ruta.etiqueta = ''
          this.errorMsg = ''
          this.successMsg = ''
        },
        abrirDeleteModal(accion, data = []) {
          this.showDeleteModal = true
          this.errors.clear()

          switch(accion) {
              case 'activar':
              {
                  this.titleDeleteModal = 'Activar Ruta'
                  this.messageDeleteModal = '¿Desea activar esta ruta?'
                  this.ruta.id = data.idruta
                  this.tipoAccion = 'activar'
                  break
              }
              case 'desactivar':
              {
                  this.titleDeleteModal = 'Desactivar Ruta'
                  this.messageDeleteModal = '¿Desea desactivar esta ruta?'
                  this.ruta.id = data.idruta
                  this.tipoAccion = 'desactivar'
                  break
              }
          }
        },
        anularRuta() {
            let me=this
          var formData = this._toFormData(this.ruta)

          this.this.axios.post(this.url+"RutaController.php?action="+this.tipoAccion, formData)
          .then(function(response) {
            me.cerrarDeleteModal()
            me.dismissCountDown = me.dismissSecs //contador para el alert

            if (response.data.error) {
              me.errorMsg = response.data.message
            }
            else {
              me.successMsg = response.data.message
              me.getAllRutas()
            }
          })
        },
        cerrarDeleteModal() {
            this.showDeleteModal = false
            this.idgrado_modalidad = ''
            this.ruta.id = ''            
            this.ruta.idgradproc_origen = ''
            this.ruta.idgradproc_destino = ''
            this.ruta.etiqueta = ''
            this.errorMsg = ''
            this.successMsg = ''
        },
        _toFormData(obj) {
            var fd = new FormData()

            for (var i in obj) {
              fd.meend(i, obj[i])
            }

            return fd
        },
        onFiltered(filteredItems) {
          // Trigger pagination to update the number of buttons/pages due to filtering
          this.totalRows = filteredItems.length
          this.currentPage = 1
        },
        _countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
      },
      mounted: function() {
          this.getAllRutas()
          this.getListGradModalidad()                      
      },
}
</script>
<style scoped>
    .overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.6);
    }    
    
    table#tbl-rutas .flip-list-move {
        transition: transform 1s;
    }    
</style>
