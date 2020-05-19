<template>
  <div>
    <div class="container pt-2 pb-3" style="background-color: #fff;">
      <div class="row mt-3">
        <div class="col-lg-6">
            <h3 class="text-info">Rol / Área</h3>
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
                id="tbl-rol-area"
                :items="array_rol_area"
                :fields="columnas"
                thead-tr-class="bg-info text-light"
                striped
                bordered
                primary-key="id"
                :tbody-transition-props="transProps"
              >            
                <template v-slot:cell(condicion)="data">
                  <span class="badge" :class="data.item.condicion == 'Activo' ? 'badge-success' : 'badge-secondary'">
                    {{ data.item.condicion }}
                  </span>
                </template>            
                <template v-slot:cell(acciones)="data">
                  <b-button variant="warning" size="sm" data-toggle="tooltip" data-placement="left" title="Editar" @click="abrirAddEditModal('actualizar', data.item)"><b-icon icon="pencil-square"></b-icon></b-button>&nbsp;
                  <b-button variant="danger" size="sm" data-toggle="tooltip" data-placement="left" title="Desactivar" @click="abrirDeleteModal('desactivar', data.item)" v-if="data.item.condicion == 'Activo'"><b-icon icon="x"></b-icon></b-button>
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
                      <label for="rol_area">Rol-Area</label>
                      <input type="text" v-model="rol_area.nombre" name="rol_area" class="form-control" id="rol_area"/>                      
                  </div>
              </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="cerrarAddEditModal">Cancelar</button>
                <button v-if="tipoAccion=='registrar'" type="button" @click="registrarRolArea" class="btn btn-success">Guardar</button>
                <button v-if="tipoAccion=='actualizar'" type="button" @click="actualizarRolArea" class="btn btn-success">Actualizar</button>
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
            <p class="font-weight-bold text-center" v-text="rol_area.nombre"></p>
          </div>
          <div class="modal-footer">
            <b-button variant="secondary" @click="cerrarDeleteModal">Cancelar</b-button>
            <b-button variant="success" @click="anularRolArea">Aceptar</b-button>
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
    name: 'rol-area',  
    data() {
        return { 
            url: this.$root.API_URL,
            array_rol_area : [],
            rol_area : {
              id: '',
              nombre: '',
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
              { key: 'nombre', label: 'Nombre', sortable: true },
              { key: 'condicion', label: 'Condición', class: 'text-center' },
              { key: 'acciones', label: 'Acciones', class: 'text-center' }
            ]                                           
        }
    },
    methods: {
        getAllRolArea() {
          let me = this

          this.axios.get(`${this.url}/RolArea/index`)
            .then(function(response) {
              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else {
                me.array_rol_area = response.data.array_rol_area                            
              }
          })
        },
        abrirAddEditModal(accion, data = []) {
          this.showAddEditModal = true;         

          switch(accion) {
              case 'registrar':
              {
                  this.titleAddEditModal = 'Registrar Rol-Área'
                  this.rol_area.id = ''
                  this.rol_area.nombre = ''
                  this.tipoAccion = 'registrar'
                  break
              }
              case 'actualizar':
              {
                  this.titleAddEditModal = 'Actualizar Rol-Área'
                  this.rol_area.id = data.id
                  this.rol_area.nombre = data.nombre
                  this.tipoAccion = 'actualizar'
                  break
              }
          }
        },
        registrarRolArea() {
          let me = this          
          var formData = this._toFormData(this.rol_area)

          this.axios.post(`${this.url}/RolArea/store`, formData)
            .then(function(response) {
              me.cerrarAddEditModal()
              me.dismissCountDown = me.dismissSecs //contador para el alert

              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else {
                me.successMsg = response.data.message
                me.getAllRolArea()
              }
          })
          
        },
        actualizarRolArea() {
          let me = this          
          var formData = this._toFormData(this.rol_area)

          this.axios.post(`${this.url}/RolArea/update`, formData)
            .then(function(response) {
              me.cerrarAddEditModal()
              me.dismissCountDown = me.dismissSecs //contador para el alert

              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else {
                me.successMsg = response.data.message
                me.getAllRolArea()
              }
          })          
        },
        cerrarAddEditModal() {
          this.showAddEditModal = false
          this.rol_area.id = ''
          this.rol_area.nombre = ''
          this.errorMsg = ''
          this.successMsg = ''
        },
        abrirDeleteModal(accion, data = []) {
          this.showDeleteModal = true         

          switch(accion) {
              case 'activar':
              {
                  this.titleDeleteModal = 'Activar Rol-Área'
                  this.messageDeleteModal = '¿Desea activar este Rol-Área?'
                  this.rol_area.id = data.id
                  this.rol_area.nombre = data.nombre
                  this.tipoAccion = 'activar'
                  break
              }
              case 'desactivar':
              {
                  this.titleDeleteModal = 'Desactivar Rol-Área'
                  this.messageDeleteModal = '¿Desea desactivar este Rol-Área?'
                  this.rol_area.id = data.id
                  this.rol_area.nombre = data.nombre
                  this.tipoAccion = 'desactivar'
                  break
              }
          }
        },
        anularRolArea() {
          let me = this
          var formData = this._toFormData(this.rol_area)

          this.axios.post(`${this.url}/RolArea/${this.tipoAccion}`, formData)
          .then(function(response) {
            me.cerrarDeleteModal()
            me.dismissCountDown = me.dismissSecs //contador para el alert

            if (response.data.error) {
              me.errorMsg = response.data.message
            }
            else {
              me.successMsg = response.data.message
              me.getAllRolArea()
            }
          })
        },
        cerrarDeleteModal() {
          this.showDeleteModal = false
          this.rol_area.id = ''
          this.rol_area.nombre = ''
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
          this.getAllRolArea()
      },
}
</script>