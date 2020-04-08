<template>
  <div>
    <div class="container-fluid pt-2 pb-3" style="background-color: #fff;">
        <div class="row mt-3">
          <div class="col-lg-6">
              <h3 class="text-info">Grados - Procedimientos</h3>
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
                              <!--<b-input-group-append>
                                  <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                              </b-input-group-append>-->
                          </b-input-group>
                      </b-form-group>
                  </b-col>                        
                </b-row>
                <b-table
                  id="tbl-grado-procedimiento"
                  :items="array_grado_procedimiento"
                  :fields="columnas"
                  thead-tr-class="bg-info text-light"
                  striped
                  bordered
                  primary-key="id"
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
                        <b-form-select id="gm_select" :options="select_grado_modalidad" v-model="grado_procedimiento.idgrado_modalidad"></b-form-select>
                      </div>
                      <div class="form-group">
                        <label for="proc_select">Procedimiento:</label>
                        <b-form-select id="proc_select" :options="select_procedimiento" v-model="grado_procedimiento.idprocedimiento"></b-form-select>
                      </div>
                      <div class="form-group">
                        <label for="rol-select">Rol-Área:</label>
                        <b-form-select id="rol-select" :options="select_rol_area" v-model="grado_procedimiento.idrol_area"></b-form-select>                        
                      </div>
                      <div class="form-group" v-if="grado_procedimiento.idrol_area == 4">
                        <label for="tipo-rol-select">Tipo-Rol:</label>
                        <b-form-select id="tipo-rol-select" v-model="grado_procedimiento.tipo_rol" :options="['asesor', 'jurado']"></b-form-select>       
                      </div>
                      <div class="form-group">
                        <label for="url_input">URL: </label>
                        <b-form-input id="url_input" type="text" v-model="grado_procedimiento.url_formulario"></b-form-input>
                        <span class="text-danger" v-if="errors.has('grado_procedimiento')">{{errors.first('grado_procedimiento')}}</span>
                      </div>
                      <div class="form-group">
                        <label for="url_orden">Orden: </label>
                        <b-form-input id="url_orden" type="number" min="1" max="50" v-model="grado_procedimiento.orden"></b-form-input>                        
                      </div>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="cerrarAddEditModal">Cancelar</button>
                  <button v-if="tipoAccion=='registrar'" type="button" @click="registrarGradoProcedimiento" class="btn btn-success">Guardar</button>
                  <button v-if="tipoAccion=='actualizar'" type="button" @click="actualizarGradoProcedimiento" class="btn btn-success">Actualizar</button>
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
              <b-button variant="success" @click="anularGradoProcedimiento">Aceptar</b-button>
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
    name: 'grado-procedimiento',  
    data() {
        return { 
            url: '//localhost/grados-unsa/backend2/controllers/',
            array_grado_procedimiento : [],
            select_grado_modalidad: [],
            select_procedimiento: [],
            select_rol_area: [],
            grado_procedimiento : {
              id: '',
              idgrado_modalidad: '',
              idprocedimiento: '',              
              idrol_area: '',
              tipo_rol: null,
              url_formulario: '',
              orden: 1,
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
            columnas: [
              { key: 'id', label: 'ID', sortable: true, class: 'text-center' },
              { key: 'gradname', label: 'Nombre del Grado/Título', sortable: true },
              { key: 'movname', label: 'Nombre de la modalidad', sortable: true },
              { key: 'procname', label: 'Procedimiento', sortable: true},
              { key: 'rolname', label: 'Rol', sortable: true},
              { key: 'url_formulario', label: "URL", sotrable: true},
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
     methods: {
        getAllGradoProcedimientos() {
            let me=this
          this.axios.get(this.url+"GradoProcedimientoController.php?action=read")
            .then(function(response) {
              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else {
                me.array_grado_procedimiento = response.data.array_grado_procedimiento
                me.totalRows = me.array_grado_procedimiento.length
              }
          })
        },
        getGradoModalidad() {
            let me=this
          this.axios.post(this.url+ "GradoProcedimientoController.php?action=readGradoModalidad")
            .then(function (response){
              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else{
                for(var gradmod of response.data.array_grado_modalidad){
                    me.select_grado_modalidad.push({value: gradmod.id, text: gradmod.gradname + ' / ' + gradmod.movname})
                }
              }
          })
        },
        getProcedimientos() {
            let me=this
          this.axios.post(this.url+ 'GradoProcedimientoController.php?action=readProcedimientos')
            .then(function(response){
              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else{
                for(var proc of response.data.array_procedimiento){
                    me.select_procedimiento.push({value: proc.id, text: proc.nombre})
                }
              }
          })
        },
        getRolArea() {
            let me=this
          this.axios.post(this.url+ 'GradoProcedimientoController.php?action=readRolArea')
            .then(function(response){
              if(response.data.error){
                me.erroMsg = response.data.message
              }
              else{
                for(var rol of response.data.array_rol_area){
                    me.select_rol_area.push({value: rol.id, text: rol.nombre})
                }
              }
          })          
        },
        abrirAddEditModal(accion, data = []) {
            this.showAddEditModal = true
            this.errors.clear()

            switch(accion) {
                case 'registrar':
                {
                    this.titleAddEditModal = 'Registrar Grado x Procedimiento'
                    this.grado_procedimiento.id = ''
                    this.tipoAccion = 'registrar'
                    break
                }
                case 'actualizar':
                {
                    this.titleAddEditModal = 'Actualizar Grado x Procedimiento'
                    this.grado_procedimiento.id = data.id
                    this.grado_procedimiento.idgrado_modalidad = data.idgrado_modalidad
                    this.grado_procedimiento.idprocedimiento = data.idprocedimiento
                    this.grado_procedimiento.orden = data.orden
                    this.grado_procedimiento.url_formulario = data.url_formulario
                    this.grado_procedimiento.idrol_area = data.idrol_area
                    this.grado_procedimiento.tipo_rol = data.tipo_rol
                    this.tipoAccion = 'actualizar'
                    break
                }
            }
        },
        registrarGradoProcedimiento() {
            let me=this

            if (!this.errors.any()) {
              var formData = this._toFormData(this.grado_procedimiento)

              this.axios.post(this.url+"GradoProcedimientoController.php?action=store", formData)
                .then(function(response) {
                  me.cerrarAddEditModal()
                  me.dismissCountDown = me.dismissSecs //contador para el alert

                  if (response.data.error) {
                    me.errorMsg = response.data.message
                  }
                  else {
                    me.successMsg = response.data.message
                    me.getAllGradoProcedimientos()
                  }
              })
            }
        },
        actualizarGradoProcedimiento() {
            let me=this

            console.log(this.grado_procedimiento.tipo_rol)

            if (!this.errors.any()) {
              var formData = this._toFormData(this.grado_procedimiento)

              this.axios.post(this.url+"GradoProcedimientoController.php?action=update", formData)
                .then(function(response) {
                  me.cerrarAddEditModal()
                  me.dismissCountDown = me.dismissSecs //contador para el alert

                  if (response.data.error) {
                    me.errorMsg = response.data.message
                  }
                  else {
                    me.successMsg = response.data.message
                    me.getAllGradoProcedimientos()
                  }
              })
            }
        },
        cerrarAddEditModal() {
            this.showAddEditModal = false
            this.grado_procedimiento.id = ''
            this.grado_procedimiento.idprocedimiento = ''
            this.grado_procedimiento.idgrado_modalidad = ''
            this.grado_procedimiento.idrol_area = ''
            this.grado_procedimiento.url_formulario = ''
            this.grado_procedimiento.orden = 1
            this.errorMsg = ''
            this.successMsg = ''
        },
        abrirDeleteModal(accion, data = []) {
            this.showDeleteModal = true
            this.errors.clear()

            switch(accion) {
                case 'activar':
                {
                    this.titleDeleteModal = 'Activar Grado x Procedimiento'
                    this.messageDeleteModal = '¿Desea activar este grado x procedimiento?'
                    this.grado_procedimiento.id = data.id
                    this.tipoAccion = 'activar'
                    break
                }
                case 'desactivar':
                {
                    this.titleDeleteModal = 'Desactivar Grado x Procedimiento'
                    this.messageDeleteModal = '¿Desea desactivar este grado x procedimiento?'
                    this.grado_procedimiento.id = data.id
                    this.tipoAccion = 'desactivar'
                    break
                }
            }
        },
        anularGradoProcedimiento() {
            let me=this
            var formData = this._toFormData(this.grado_procedimiento)

            this.axios.post(this.url+"GradoProcedimientoController.php?action="+this.tipoAccion, formData)
            .then(function(response) {
              me.cerrarDeleteModal()
              me.dismissCountDown = me.dismissSecs //contador para el alert

              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else {
                me.successMsg = response.data.message
                me.getAllGradoProcedimientos()
              }
            })
        },
        cerrarDeleteModal() {
            this.showDeleteModal = false
            this.grado_procedimiento.idprocedimiento = ''
            this.grado_procedimiento.idgrado_modalidad = ''
            this.grado_procedimiento.idrol_area = ''
            this.errorMsg = ''
            this.successMsg = ''
        },
        _toFormData(obj) {
            var fd = new FormData()

            for (var i in obj) {
              fd.append(i, obj[i])
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
          this.getAllGradoProcedimientos()   
          this.getGradoModalidad()
          this.getProcedimientos()
          this.getRolArea()          
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
    
    table#tbl-grado-procedimiento .flip-list-move {
        transition: transform 1s;
    }    
</style>
