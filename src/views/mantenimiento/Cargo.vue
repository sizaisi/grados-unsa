<template>
  <div>
     <div class="container pt-2 pb-3" style="background-color: #fff;">
        <div class="row mt-3">
          <div class="col-lg-6">
            <h3 class="text-info">Cargo</h3>
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
                  id="tbl-cargo"
                  :items="array_cargo"
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
                        <label for="cargo">Cargo:</label>
                        <input type="text" v-model="cargo.nombre" name="cargo" class="form-control" id="cargo"/>                        
                    </div>
                    <div class="form-group">
                        <label for="tipo-select">Tipo:</label>
                        <b-form-select id="tipo-select" v-model="cargo.tipo" :options="array_tipos"></b-form-select>       
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="cerrarAddEditModal">Cancelar</button>
                  <button v-if="tipoAccion=='registrar'" type="button" @click="registrarCargo" class="btn btn-success">Guardar</button>
                  <button v-if="tipoAccion=='actualizar'" type="button" @click="actualizarCargo" class="btn btn-success">Actualizar</button>
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
              <p class="font-weight-bold text-center" v-text="cargo.nombre"></p>
            </div>
            <div class="modal-footer">
              <b-button variant="secondary" @click="cerrarDeleteModal">Cancelar</b-button>
              <b-button variant="success" @click="anularCargo">Aceptar</b-button>
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
    name: 'cargo',  
    data() {
        return { 
            url: '//localhost/grados-unsa/backend2',
            array_cargo : [],
            array_tipos : ['Actual', 
                           'Antiguo'],
            cargo : {
              id: '',
              nombre: '',
              tipo: '',
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
              { key: 'tipo', label: 'Tipo', class: 'text-center' },
              { key: 'condicion', label: 'Condición', class: 'text-center' },
              { key: 'acciones', label: 'Acciones', class: 'text-center' }
            ]                                       
        }
    },
     methods: {
        getAllCargo() {
            let me = this

            this.axios.get(`${this.url}/Cargo/index`)
              .then(function(response) {
                if (response.data.error) {
                  me.errorMsg = response.data.message
                }
                else {
                  me.array_cargo = response.data.array_cargo                  
                }
              })
        },
        abrirAddEditModal(accion, data = []) {
            this.showAddEditModal = true            

            switch(accion) {
                case 'registrar':
                {
                    this.titleAddEditModal = 'Registrar Cargo'
                    this.cargo.id = ''
                    this.cargo.nombre = ''
                    this.cargo.tipo = ''
                    this.tipoAccion = 'registrar'
                    break
                }
                case 'actualizar':
                {
                    this.titleAddEditModal = 'Actualizar Cargo'
                    this.cargo.id = data.id
                    this.cargo.nombre = data.nombre
                    this.cargo.tipo = data.tipo
                    this.tipoAccion = 'actualizar'
                    break
                }
            }
        },
        registrarCargo() {
            let me = this

            var formData = this._toFormData(this.cargo)

            this.axios.post(`${this.url}/Cargo/store`, formData)
              .then(function(response) {
                me.cerrarAddEditModal();
                me.dismissCountDown = me.dismissSecs //contador para el alert

                if (response.data.error) {
                  me.errorMsg = response.data.message
                }
                else {
                  me.successMsg = response.data.message
                  me.getAllCargo()
                }
            })            
        },
        actualizarCargo() {
            let me = this
            
            var formData = this._toFormData(this.cargo)

            this.axios.post(`${this.url}/Cargo/update`, formData)
              .then(function(response) {
                me.cerrarAddEditModal();
                me.dismissCountDown = me.dismissSecs //contador para el alert

                if (response.data.error) {
                  me.errorMsg = response.data.message
                }
                else {
                  me.successMsg = response.data.message
                  me.getAllCargo()
                }
            })            
        },
        cerrarAddEditModal() {
            this.showAddEditModal = false
            this.cargo.id = ''
            this.cargo.nombre = ''
            this.cargo.tipo = ''
            this.errorMsg = ''
            this.successMsg = ''
        },
        abrirDeleteModal(accion, data = []) {
            this.showDeleteModal = true           

            switch(accion) {
                case 'activar':
                {
                    this.titleDeleteModal = 'Activar Cargo'
                    this.messageDeleteModal = '¿Desea activar este Cargo?'
                    this.cargo.id = data.id
                    this.cargo.nombre = data.nombre
                    this.cargo.tipo = data.tipo
                    this.tipoAccion = 'activar'
                    break
                }
                case 'desactivar':
                {
                    this.titleDeleteModal = 'Desactivar Cargo'
                    this.messageDeleteModal = '¿Desea desactivar este Cargo?'
                    this.cargo.id = data.id
                    this.cargo.nombre = data.nombre
                    this.cargo.tipo = data.tipo
                    this.tipoAccion = 'desactivar'
                    break
                }
            }
        },
        anularCargo() {
            let me = this
            var formData = this._toFormData(this.cargo)

            this.axios.post(`${this.url}/Cargo/${this.tipoAccion}`, formData)
            .then(function(response) {
              me.cerrarDeleteModal()
              me.dismissCountDown = me.dismissSecs //contador para el alert

              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else {
                me.successMsg = response.data.message
                me.getAllCargo()
              }
            })
        },
        cerrarDeleteModal() {
            this.showDeleteModal = false
            this.cargo.id = ''
            this.cargo.nombre = ''
            this.cargo.tipo = ''
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
          this.getAllCargo()
      },
}
</script>
