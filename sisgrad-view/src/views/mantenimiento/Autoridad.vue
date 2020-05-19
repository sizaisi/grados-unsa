<template>
  <div>
     <div class="container pt-2 pb-3" style="background-color: #fff;">
        <div class="row mt-3">
          <div class="col-lg-6">
            <h3 class="text-info">Autoridades</h3>
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
                <b-table
                  id="tbl-autoridad"
                  :items="array_autoridad"
                  :fields="columnas"
                  thead-tr-class="bg-info text-light"
                  striped
                  bordered
                  primary-key="id"
                  :tbody-transition-props="transProps"
                >
                  <template v-slot:cell(condicion)="data">
                    <b-badge v-if="data.item.condicion == 1" variant='success'>Activo</b-badge>
                    <b-badge v-else variant='secondary'>Inactivo</b-badge>
                  </template>
                  <template v-slot:cell(acciones)="data">
                    <b-button variant="warning" size="sm" data-toggle="tooltip" data-placement="left" title="Editar" @click="abrirAddEditModal('actualizar', data.item)"><b-icon icon="pencil-square"></b-icon></b-button>&nbsp;
                    <b-button variant="danger" size="sm" data-toggle="tooltip" data-placement="left" title="Desactivar" @click="abrirDeleteModal('desactivar', data.item)" v-if="data.item.condicion == 1"><b-icon icon="x"></b-icon></b-button>
                    <b-button variant="success" size="sm" data-toggle="tooltip" data-placement="left" title="Activar" @click="abrirDeleteModal('activar', data.item)" v-else><b-icon icon="check"></b-icon></b-button>
                  </template>
                </b-table>
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
                        <label for="autoridad">Autoridad:</label>
                        <input type="text" v-model="autoridad.nombre" name="autoridad" class="form-control" id="autoridad"/>                        
                    </div>
                    <div class="form-group">
                        <label for="grado-select">Grado:</label>
                        <b-form-select id="grado-select" v-model="autoridad.grado" :options="array_grados"></b-form-select>       
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="cerrarAddEditModal">Cancelar</button>
                  <button v-if="tipoAccion=='registrar'" type="button" @click="registrarAutoridad" class="btn btn-success">Guardar</button>
                  <button v-if="tipoAccion=='actualizar'" type="button" @click="actualizarAutoridad" class="btn btn-success">Actualizar</button>
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
              <p class="font-weight-bold text-center" v-text="autoridad.nombre"></p>
            </div>
            <div class="modal-footer">
              <b-button variant="secondary" @click="cerrarDeleteModal">Cancelar</b-button>
              <b-button variant="success" @click="anularAutoridad">Aceptar</b-button>
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
    name: 'autoridad',  
    data() {
        return { 
            url: '//localhost/grados-unsa/backend2',
            array_autoridad : [],
            array_grados : ['Bachiller', 
                           'Titulado',
                           'Maestria',
                           'Doctorado',],
            autoridad : {
              id: '',
              nombre: '',
              grado: '',
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
              { key: 'nombre', label: 'Nombre', sortable: true, class: 'text-left' },
              { key: 'grado', label: 'Grado', sortable: true, class: 'text-left' },
              { key: 'condicion', label: 'Condición', class: 'text-center' },
              { key: 'acciones', label: 'Acciones', class: 'text-center' }
            ]                                       
        }
    },
     methods: {
        getAllAutoridad() {
            let me = this

            this.axios.get(`${this.url}/Autoridad/index`)
              .then(function(response) {
                if (response.data.error) {
                  me.errorMsg = response.data.message
                }
                else {
                  me.array_autoridad = response.data.array_autoridad                  
                }
              })
        },
        abrirAddEditModal(accion, data = []) {
            this.showAddEditModal = true            

            switch(accion) {
                case 'registrar':
                {
                    this.titleAddEditModal = 'Registrar Autoridad'
                    this.autoridad.id = ''
                    this.autoridad.nombre = ''
                    this.autoridad.grado = ''
                    this.tipoAccion = 'registrar'
                    break
                }
                case 'actualizar':
                {
                    this.titleAddEditModal = 'Actualizar Autoridad'
                    this.autoridad.id = data.id
                    this.autoridad.nombre = data.nombre
                    this.autoridad.grado = data.grado
                    this.tipoAccion = 'actualizar'
                    break
                }
            }
        },
        registrarAutoridad() {
            let me = this

            var formData = this._toFormData(this.autoridad)

            this.axios.post(`${this.url}/Autoridad/store`, formData)
              .then(function(response) {
                me.cerrarAddEditModal();
                me.dismissCountDown = me.dismissSecs //contador para el alert

                if (response.data.error) {
                  me.errorMsg = response.data.message
                }
                else {
                  me.successMsg = response.data.message
                  me.getAllAutoridad()
                }
            })            
        },
        actualizarAutoridad() {
            let me = this
            
            var formData = this._toFormData(this.autoridad)

            this.axios.post(`${this.url}/Autoridad/update`, formData)
              .then(function(response) {
                me.cerrarAddEditModal();
                me.dismissCountDown = me.dismissSecs //contador para el alert

                if (response.data.error) {
                  me.errorMsg = response.data.message
                }
                else {
                  me.successMsg = response.data.message
                  me.getAllAutoridad()
                }
            })            
        },
        cerrarAddEditModal() {
            this.showAddEditModal = false
            this.autoridad.id = ''
            this.autoridad.nombre = ''
            this.autoridad.grado = ''
            this.errorMsg = ''
            this.successMsg = ''
        },
        abrirDeleteModal(accion, data = []) {
            this.showDeleteModal = true           

            switch(accion) {
                case 'activar':
                {
                    this.titleDeleteModal = 'Activar Autoridad'
                    this.messageDeleteModal = '¿Desea activar esta Autoridad?'
                    this.autoridad.id = data.id
                    this.autoridad.nombre = data.nombre
                    this.autoridad.grado = data.grado
                    this.tipoAccion = 'activar'
                    break
                }
                case 'desactivar':
                {
                    this.titleDeleteModal = 'Desactivar Autoridad'
                    this.messageDeleteModal = '¿Desea desactivar esta Autoridad?'
                    this.autoridad.id = data.id
                    this.autoridad.nombre = data.nombre
                    this.autoridad.grado = data.grado
                    this.tipoAccion = 'desactivar'
                    break
                }
            }
        },
        anularAutoridad() {
            let me = this
            var formData = this._toFormData(this.autoridad)

            this.axios.post(`${this.url}/Autoridad/${this.tipoAccion}`, formData)
            .then(function(response) {
              me.cerrarDeleteModal()
              me.dismissCountDown = me.dismissSecs //contador para el alert

              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else {
                me.successMsg = response.data.message
                me.getAllAutoridad()
              }
            })
        },
        cerrarDeleteModal() {
            this.showDeleteModal = false
            this.autoridad.id = ''
            this.autoridad.nombre = ''
            this.autoridad.grado = ''
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
        _countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
      },
      mounted: function() {
          this.getAllAutoridad()
      },
}
</script>
