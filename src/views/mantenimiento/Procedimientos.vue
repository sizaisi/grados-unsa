<template>
  <div>
    <div class="container pt-2 pb-3" style="background-color: #fff;">
        <div class="row mt-3">
          <div class="col-lg-6">
              <h3 class="text-info">Procedimientos</h3>
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
                  id="tbl-procedimientos"
                  :items="array_procedimiento"
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
                    <b-button variant="warning" size="sm" data-toggle="tooltip" data-placement="left" title="Editar" @click="abrirAddEditModal('actualizar', data.item)"><b-icon icon="pencil-square"></b-icon></b-button>&nbsp;
                    <b-button variant="danger" size="sm" data-toggle="tooltip" data-placement="left" title="Desactivar" @click="abrirDeleteModal('desactivar', data.item)" v-if="data.item.condicion == 1"><b-icon icon="x"></b-icon></b-button>
                    <b-button variant="success" size="sm" data-toggle="tooltip" data-placement="left" title="Activar" @click="abrirDeleteModal('activar', data.item)" v-else><b-icon icon="check"></b-icon></b-button>
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
                        <label for="procedimiento">Procedimiento:</label>
                        <input type="text" v-model="procedimiento.nombre" name="procedimiento" class="form-control" id="procedimiento"/>                        
                    </div>
                    <div class="form-group">
                        <label for="proc_desc">Descripción:</label>
                        <input type="text" v-model="procedimiento.descripcion" class="form-control" id="proc_desc"/>                        
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="cerrarAddEditModal">Cancelar</button>
                  <button v-if="tipoAccion=='registrar'" type="button" @click="registrarProcedimiento" class="btn btn-success">Guardar</button>
                  <button v-if="tipoAccion=='actualizar'" type="button" @click="actualizarProcedimiento" class="btn btn-success">Actualizar</button>
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
              <p class="font-weight-bold text-center" v-text="procedimiento.nombre"></p>
            </div>
            <div class="modal-footer">
              <b-button variant="secondary" @click="cerrarDeleteModal">Cancelar</b-button>
              <b-button variant="success" @click="eliminarProcedimiento">Aceptar</b-button>
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
    name: 'procedimientos',  
    data() {
        return { 
          url: this.$root.API_URL,
          array_procedimiento : [],
          procedimiento : {
            id: '',
            nombre: '',
            descripcion: '',
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
            { key: 'descripcion', label: 'Descripción', sortable: true, class: 'text-left' },
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
        getAllProcedimientos() {
          let me = this

            this.axios.get(`${this.url}/Procedimiento/index`)
              .then(function(response) {
                if (response.data.error) {
                  me.errorMsg = response.data.message
                }
                else {
                  me.array_procedimiento = response.data.array_procedimiento
                  me.totalRows = me.array_procedimiento.length;                  
                }
              })
        },
        abrirAddEditModal(accion, data = []) {
            this.showAddEditModal = true            

            switch(accion) {
                case 'registrar':
                {
                    this.titleAddEditModal = 'Registrar Procedimiento'
                    this.procedimiento.id = ''
                    this.procedimiento.nombre = ''
                    this.tipoAccion = 'registrar'
                    break
                }
                case 'actualizar':
                {
                    this.titleAddEditModal = 'Actualizar Procedimiento'
                    this.procedimiento.id = data.id
                    this.procedimiento.nombre = data.nombre
                    this.procedimiento.descripcion = data.descripcion
                    this.tipoAccion = 'actualizar'
                    break
                }
            }
        },
        registrarProcedimiento() {
            let me = this            
            var formData = this._toFormData(this.procedimiento)

            this.axios.post(`${this.url}/Procedimiento/store`, formData)
              .then(function(response) {                
                me.cerrarAddEditModal();
                me.dismissCountDown = me.dismissSecs //contador para el alert

                if (response.data.error) {
                  me.errorMsg = response.data.message
                }
                else {
                  me.successMsg = response.data.message
                  me.getAllProcedimientos()
                }
              })            
        },
        actualizarProcedimiento() {
            let me = this            
            var formData = this._toFormData(this.procedimiento)

            this.axios.post(`${this.url}/Procedimiento/update`, formData)
              .then(function(response) {
                me.cerrarAddEditModal();
                me.dismissCountDown = me.dismissSecs //contador para el alert

                if (response.data.error) {
                  me.errorMsg = response.data.message
                }
                else {
                  me.successMsg = response.data.message
                  me.getAllProcedimientos()
                }
              })                    
        },
        cerrarAddEditModal() {
            this.showAddEditModal = false
            this.procedimiento.id = ''
            this.procedimiento.nombre = ''
            this.procedimiento.descripcion = ''
            this.errorMsg = ''
            this.successMsg = ''
        },
        abrirDeleteModal(accion, data = []) {
            this.showDeleteModal = true           

            switch(accion) {
                case 'activar':
                {
                    this.titleDeleteModal = 'Activar Procedimiento'
                    this.messageDeleteModal = '¿Desea activar este procedimiento?'
                    this.procedimiento.id = data.id
                    this.procedimiento.nombre = data.nombre
                    this.tipoAccion = 'activar'
                    break
                }
                case 'desactivar':
                {
                    this.titleDeleteModal = 'Desactivar Procedimiento'
                    this.messageDeleteModal = '¿Desea desactivar este procedimiento?'
                    this.procedimiento.id = data.id
                    this.procedimiento.nombre = data.nombre
                    this.tipoAccion = 'desactivar'
                    break
                }
            }
        },
        eliminarProcedimiento() {
            let me = this
            var formData = this._toFormData(this.procedimiento)

            this.axios.post(`${this.url}/Procedimiento/${this.tipoAccion}`, formData)
            .then(function(response) {
              me.cerrarDeleteModal()
              me.dismissCountDown = me.dismissSecs //contador para el alert

              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else {
                me.successMsg = response.data.message
                me.getAllProcedimientos()
              }
            })
        },
        cerrarDeleteModal() {
            this.showDeleteModal = false
            this.procedimiento.id = ''
            this.procedimiento.nombre = ''
            this.procedimiento.descripcion = ''
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
          this.getAllProcedimientos()
      },
}
</script>
