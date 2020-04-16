<template>
  <div>
     <div class="container pt-2 pb-3" style="background-color: #fff;">
        <div class="row mt-3">
          <div class="col-lg-6">
            <h3 class="text-info">Cargo - Autoridad</h3>
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
                  id="tbl-cargo-autoridad"
                  :items="array_cargo_autoridad"
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
                        <label for="cargo_select">Cargo:</label>
                        <b-form-select id="cargo_select" :options="array_cargos" v-model="cargo_autoridad.idcargo"></b-form-select>
                    </div>
                    <div class="form-group">
                        <label for="autoridad_select">Autoridad:</label>
                        <b-form-select id="autoridad_select" :options="array_autoridades" v-model="cargo_autoridad.idautoridad"></b-form-select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha Inicio:</label>
                        <input type="date" v-model="cargo_autoridad.fecha_inicio" name="fecha_inicio" class="form-control" id="fecha_inicio"/>                        
                    </div>
                    <div class="form-group">
                        <label for="fecha_fin">Fecha Fin:</label>
                        <input type="date" v-model="cargo_autoridad.fecha_fin" name="fecha_fin" class="form-control" id="fecha_fin"/>                        
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="cerrarAddEditModal">Cancelar</button>
                  <button v-if="tipoAccion=='registrar'" type="button" @click="registrarCargoAutoridad" class="btn btn-success">Guardar</button>
                  <button v-if="tipoAccion=='actualizar'" type="button" @click="actualizarCargoAutoridad" class="btn btn-success">Actualizar</button>
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
              <p class="font-weight-bold text-center" v-text="cargo_autoridad.id"></p>
            </div>
            <div class="modal-footer">
              <b-button variant="secondary" @click="cerrarDeleteModal">Cancelar</b-button>
              <b-button variant="success" @click="anularCargoAutoridad">Aceptar</b-button>
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
    name: 'cargo-autoridad',  
    data() {
        return { 
            url: '//localhost/grados-unsa/backend2',
            array_cargo_autoridad : [],
            array_cargos: [],
            array_autoridades: [],
            cargo_autoridad : {
              id: '',
              idcargo: '',
              idautoridad: '',
              fecha_inicio: '',
              fecha_fin: '',
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
              { key: 'idcargo', label: 'Cargo', sortable: true, class: 'text-left' },
              { key: 'idautoridad', label: 'Autoridad', class: 'text-center' },
              { key: 'fecha_inicio', label: 'Fecha Inicio', class: 'text-center' },
              { key: 'fecha_fin', label: 'Fecha Fin', class: 'text-center' },
              { key: 'acciones', label: 'Acciones', class: 'text-center' }
            ]                                       
        }
    },
     methods: {
       getCargos() {
          let me = this

          this.axios.post(`${this.url}/CargoAutoridad/readCargo`)
            .then(function (response){
              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else { 
                me.array_cargos.push({ value: '', text: 'Seleccione Cargo...', disabled: true })
                
                for(var cargo of response.data.array_cargo_autoridades){
                  me.array_cargos.push({value: cargo.cargoid, text: cargo.cargoname})
                }
              }
          })
        },
        getAutoridades() {
          let me = this

          this.axios.post(`${this.url}/CargoAutoridad/readAutoridad`)
            .then(function (response){
              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else { 
                me.array_autoridades.push({ value: '', text: 'Seleccione Autoridad...', disabled: true })
                
                for(var autoridad of response.data.array_cargo_autoridades){
                  me.array_autoridades.push({value: autoridad.autoridadid, text: autoridad.autoridadname})
                }
              }
          })
        },
        getAllCargoAutoridad() {
            let me = this

            this.axios.get(`${this.url}/CargoAutoridad/index`)
              .then(function(response) {
                if (response.data.error) {
                  me.errorMsg = response.data.message
                }
                else {
                  me.array_cargo_autoridad = response.data.array_cargo_autoridad                  
                }
              })
        },
        abrirAddEditModal(accion, data = []) {
            this.showAddEditModal = true            

            switch(accion) {
                case 'registrar':
                {
                    this.titleAddEditModal = 'Registrar Cargo Autoridad'
                    this.cargo_autoridad.id = this.array_cargo_autoridad.length + 1
                    this.cargo_autoridad.idcargo = ''
                    this.cargo_autoridad.idautoridad = ''
                    this.cargo_autoridad.fecha_inicio = ''
                    this.cargo_autoridad.fecha_fin = ''
                    this.tipoAccion = 'registrar'
                    break
                }
                case 'actualizar':
                {
                    this.titleAddEditModal = 'Actualizar Cargo Autoridad'
                    this.cargo_autoridad.id = data.id
                    this.cargo_autoridad.idcargo = data.idcargo
                    this.cargo_autoridad.idautoridad = data.idautoridad
                    this.cargo_autoridad.fecha_inicio = data.fecha_inicio
                    this.cargo_autoridad.fecha_fin = data.fecha_fin
                    this.tipoAccion = 'actualizar'
                    break
                }
            }
        },
        registrarCargoAutoridad() {
            let me = this

            var formData = this._toFormData(this.cargo_autoridad)

            this.axios.post(`${this.url}/CargoAutoridad/store`, formData)
              .then(function(response) {
                me.cerrarAddEditModal();
                me.dismissCountDown = me.dismissSecs //contador para el alert

                if (response.data.error) {
                  me.errorMsg = response.data.message
                }
                else {
                  me.successMsg = response.data.message
                  me.getAllCargoAutoridad()
                }
            })            
        },
        actualizarCargoAutoridad() {
            let me = this
            
            var formData = this._toFormData(this.cargo_autoridad)

            this.axios.post(`${this.url}/CargoAutoridad/update`, formData)
              .then(function(response) {
                me.cerrarAddEditModal();
                me.dismissCountDown = me.dismissSecs //contador para el alert

                if (response.data.error) {
                  me.errorMsg = response.data.message
                }
                else {
                  me.successMsg = response.data.message
                  me.getAllCargoAutoridad()
                }
            })            
        },
        cerrarAddEditModal() {
            this.showAddEditModal = false
            this.cargo_autoridad.id = ''
            this.cargo_autoridad.idcargo = ''
            this.cargo_autoridad.idautoridad = ''
            this.cargo_autoridad.fecha_inicio = ''
            this.cargo_autoridad.fecha_fin = ''
            this.errorMsg = ''
            this.successMsg = ''
        },
        abrirDeleteModal(accion, data = []) {
            this.showDeleteModal = true           

            switch(accion) {
                case 'activar':
                {
                    this.titleDeleteModal = 'Activar Cargo Autoridad'
                    this.messageDeleteModal = '¿Desea activar este Cargo Autoridad?'
                    this.cargo_autoridad.id = data.id
                    this.cargo_autoridad.idcargo = data.idcargo
                    this.cargo_autoridad.idautoridad = data.idautoridad
                    this.cargo_autoridad.fecha_inicio = data.fecha_inicio
                    this.cargo_autoridad.fecha_fin = data.fecha_fin
                    this.tipoAccion = 'activar'
                    break
                }
                case 'desactivar':
                {
                    this.titleDeleteModal = 'Desactivar Cargo Autoridad'
                    this.messageDeleteModal = '¿Desea desactivar este Cargo Autoridad?'
                    this.cargo_autoridad.id = data.id
                    this.cargo_autoridad.idcargo = data.idcargo
                    this.cargo_autoridad.idautoridad = data.idautoridad
                    this.cargo_autoridad.fecha_inicio = data.fecha_inicio
                    this.cargo_autoridad.fecha_fin = data.fecha_fin
                    this.tipoAccion = 'desactivar'
                    break
                }
            }
        },
        anularCargoAutoridad() {
            let me = this
            var formData = this._toFormData(this.cargo_autoridad)

            this.axios.post(`${this.url}/CargoAutoridad/${this.tipoAccion}`, formData)
            .then(function(response) {
              me.cerrarDeleteModal()
              me.dismissCountDown = me.dismissSecs //contador para el alert

              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else {
                me.successMsg = response.data.message
                me.getAllCargoAutoridad()
              }
            })
        },
        cerrarDeleteModal() {
            this.showDeleteModal = false
            this.cargo_autoridad.id = ''
            this.cargo_autoridad.idcargo = ''
            this.cargo_autoridad.idautoridad = ''
            this.cargo_autoridad.fecha_inicio = ''
            this.cargo_autoridad.fecha_fin = ''
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
          this.getAllCargoAutoridad()
      },
}
</script>
