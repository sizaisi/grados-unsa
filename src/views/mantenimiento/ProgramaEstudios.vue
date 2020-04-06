<template>
  <div>
    <div class="container pt-2 pb-3" style="background-color: #fff;">
        <div class="row mt-3">
          <div class="col-lg-6">
              <h3 class="text-info text-left">Programa de Estudios Académicos</h3>
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
                  id="tbl-programa-estudios"
                  :items="array_programa_estudios"
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
                    <b-button variant="warning" size="sm" data-toggle="tooltip" data-placement="left" title="Editar" @click="abrirAddEditModal('actualizar', data.item)"><i class="fa fa-edit"></i></b-button>
                    <b-button variant="danger" size="sm" data-toggle="tooltip" data-placement="left" title="Desactivar" @click="abrirDeleteModal('desactivar', data.item)" v-if="data.item.condicion == 'Activo'"><i class="fa fa-times"></i></b-button>
                    <b-button variant="success" size="sm" data-toggle="tooltip" data-placement="left" title="Activar" @click="abrirDeleteModal('activar', data.item)" v-else><i class="fa fa-check"></i></b-button>
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
                        <label for="programa_estudios">Programa de estudios</label>
                        <input type="text" v-model="programa_estudios.nombre" name="programa_estudios" class="form-control" id="programa_estudios"/>                        
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="cerrarAddEditModal">Cancelar</button>
                  <button v-if="tipoAccion=='registrar'" type="button" @click="registrarProgramaEstudios" class="btn btn-success">Guardar</button>
                  <button v-if="tipoAccion=='actualizar'" type="button" @click="actualizarProgramaEstudios" class="btn btn-success">Actualizar</button>
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
              <p class="font-weight-bold text-center" v-text="programa_estudios.nombre"></p>
            </div>
            <div class="modal-footer">
              <b-button variant="secondary" @click="cerrarDeleteModal">Cancelar</b-button>
              <b-button variant="success" @click="eliminarProgramaEstudios">Aceptar</b-button>
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
            url: 'http://10.50.1.33/sisacad_pruebas/graduacion/controlador/',
            array_programa_estudios : [],
            programa_estudios : {
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
        getAllProgramaEstudios() {
            let me = this
            this.axios.get(this.url+"ProgramaEstudiosController.php?action=read")
                .then(function(response) {
                if (response.data.error) {
                    me.errorMsg = response.data.message
                }
                else {
                    me.array_programa_estudios = response.data.array_programa_estudios
                }
                })
        },
        abrirAddEditModal(accion, data = []) {            
            this.showAddEditModal = true            

            switch(accion) {
                case 'registrar':
                {
                    this.titleAddEditModal = 'Registrar Programa de Estudios'
                    this.programa_estudios.id = ''
                    this.programa_estudios.nombre = ''
                    this.tipoAccion = 'registrar'
                    break
                }
                case 'actualizar':
                {
                    this.titleAddEditModal = 'Actualizar Programa de Estudios'
                    this.programa_estudios.id = data.id
                    this.programa_estudios.nombre = data.nombre
                    this.tipoAccion = 'actualizar'
                    break
                }
            }
        },
        registrarProgramaEstudios() {            
            let me = this            
            var formData = this._toFormData(this.programa_estudios);

            this.axios.post(this.url+"ProgramaEstudiosController.php?action=store", formData)
            .then(function(response) {
                me.cerrarAddEditModal()
                me.dismissCountDown = me.dismissSecs //contador para el alert

                if (response.data.error) {
                    me.errorMsg = response.data.message
                }
                else {
                    me.successMsg = response.data.message
                    me.getAllProgramaEstudios()
                }
            })
            
        },
        actualizarProgramaEstudios() {            
            let me = this            
            var formData = this._toFormData(this.programa_estudios)

            this.axios.post(this.url+"ProgramaEstudiosController.php?action=update", formData)
            .then(function(response) {
                me.cerrarAddEditModal();
                me.dismissCountDown = me.dismissSecs //contador para el alert

                if (response.data.error) {
                    me.errorMsg = response.data.message
                }
                else {
                    me.successMsg = response.data.message
                    me.getAllProgramaEstudios()
                }
            })            
        },
        cerrarAddEditModal() {
            this.showAddEditModal = false
            this.programa_estudios.id = ''
            this.programa_estudios.nombre = ''
            this.errorMsg = ''
            this.successMsg = ''
        },
        abrirDeleteModal(accion, data = []) {
            this.showDeleteModal = true            

            switch(accion) {
                case 'activar':
                {
                    this.titleDeleteModal = 'Activar Programa de Estudios';
                    this.messageDeleteModal = '¿Desea activar este programa de estudios?'
                    this.programa_estudios.id = data.id
                    this.programa_estudios.nombre = data.nombre
                    this.tipoAccion = 'activar'
                    break
                }
                case 'desactivar':
                {
                    this.titleDeleteModal = 'Desactivar Programa de Estudios'
                    this.messageDeleteModal = '¿Desea desactivar este programa de estudios?'
                    this.programa_estudios.id = data.id
                    this.programa_estudios.nombre = data.nombre
                    this.tipoAccion = 'desactivar'
                    break
                }
            }
        },
        eliminarProgramaEstudios() {
            let me = this
            var formData = this._toFormData(this.programa_estudios)

            this.axios.post(this.url+"ProgramaEstudiosController.php?action="+this.tipoAccion, formData)
            .then(function(response) {
                me.cerrarDeleteModal()
                me.dismissCountDown = me.dismissSecs //contador para el alert

                if (response.data.error) {
                    me.errorMsg = response.data.message
                }
                else {
                    me.successMsg = response.data.message
                    me.getAllProgramaEstudios()
                }
            })
        },
        cerrarDeleteModal() {
            this.showDeleteModal = false
            this.programa_estudios.id = ''
            this.programa_estudios.nombre = ''
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
        _countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
    },
    mounted: function() {
        //this.getAllProgramaEstudios()
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
    
    table#tbl-programa-estudios .flip-list-move {
        transition: transform 1s;
    }    
</style>
