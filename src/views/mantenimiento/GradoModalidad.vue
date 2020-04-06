<template>
  <div>
    <div class="container pt-2 pb-3" style="background-color: #fff;">
        <div class="row mt-3">
          <div class="col-lg-6">
              <h3 class="text-info">Grados - Modalidades</h3>
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
                  id="tbl-grado-modalidad"
                  :items="array_grado_modalidad"
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
                    <b-button variant="warning" size="sm" data-toggle="tooltip" data-placement="left" title="Editar" @click="abrirAddEditModal('actualizar', data.item)"><i class="fa fa-edit"></i></b-button>
                    <b-button variant="danger" size="sm" data-toggle="tooltip" data-placement="left" title="Desactivar" @click="abrirDeleteModal('desactivar', data.item)" v-if="data.item.condicion == 1"><i class="fa fa-times"></i></b-button>
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
                        <label for="grado_select">Grado/Título:</label>
                        <b-form-select id="grado_select" :options="array_grados" v-model="grado_modalidad.idgrado_titulo"></b-form-select>
                    </div>
                    <div class="form-group">
                        <label for="modalidad_select">Modalidad:</label>
                        <b-form-select id="modalidad_select" :options="array_modalidades" v-model="grado_modalidad.idmodalidad_obtencion"></b-form-select>
                        <span class="text-danger" v-if="errors.has('grado_modalidad')">{{errors.first('grado_modalidad')}}</span>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" @click="cerrarAddEditModal">Cancelar</button>
                  <button v-if="tipoAccion=='registrar'" type="button" @click="registrarGradoModalidad" class="btn btn-success">Guardar</button>
                  <button v-if="tipoAccion=='actualizar'" type="button" @click="actualizarGradoModalidad" class="btn btn-success">Actualizar</button>
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
            url: 'http://localhost/backend/controlador/',
            array_grado_modalidad : [],
            array_grados: [],
            array_modalidades: [],
            grado_modalidad : {
              id: '',
              idgrado_titulo: '',
              idmodalidad_obtencion: '',
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
              { key: 'condicion', label: 'Condición', class: 'text-center' },
              { key: 'acciones', label: 'Acciones', class: 'text-center' }
            ]                                           
        }
    },
    methods: {
        getAllGradoModalidad() {
          let me=this
          this.axios.get(this.url+"GradoModalidadController.php?action=read")
            .then(function(response) {
              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else {
                me.array_grado_modalidad = response.data.array_grado_modalidad
              }
          })
        },
        getGradoTitulos() {
          let me=this
          this.axios.post(this.url + "GradoModalidadController.php?action=readGradoTitulo")
            .then(function (response){
              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else { 
                for(var grado of response.data.array_grado_titulo){
                  me.array_grados.push({value: grado.id, text: grado.nombre})
                }
              }
          })
        },
        getModalidadesObtencion() {
          let me=this
          this.axios.post(this.url + "GradoModalidadController.php?action=readModObtencion")
            .then(function (response){
              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else {
                for(var mod of response.data.array_modalidad_obtencion){
                  me.array_modalidades.push({value: mod.id, text: mod.nombre})
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
                  this.titleAddEditModal = 'Registrar Título x Modalidad'
                  this.grado_modalidad.id = ''
                  this.tipoAccion = 'registrar'
                  break
              }
              case 'actualizar':
              {
                  this.titleAddEditModal = 'Actualizar Título x Modalidad'
                  this.grado_modalidad.id = data.id
                  this.grado_modalidad.idgrado_titulo = data.idgrado_titulo
                  this.grado_modalidad.idmodalidad_obtencion = data.idmodalidad_obtencion
                  this.tipoAccion = 'actualizar'
                  break
              }
          }
        },
        registrarGradoModalidad() {
            let me=this

            if (!this.errors.any()) {
              var formData = this._toFormData(this.grado_modalidad)

              this.axios.post(this.url+"GradoModalidadController.php?action=store", formData)
                .then(function(response) {
                  me.cerrarAddEditModal()
                  me.dismissCountDown = me.dismissSecs; //contador para el alert

                  if (response.data.error) {
                    me.errorMsg = response.data.message
                  }
                  else {
                    me.successMsg = response.data.message
                    me.getAllGradoModalidad()
                  }
              })
            }
        },
        actualizarGradoModalidad() {
            let me=this

            if (!this.errors.any()) {
              var formData = this._toFormData(this.grado_modalidad)
              

              this.axios.post(this.url+"GradoModalidadController.php?action=update", formData)
                .then(function(response) {
                  me.cerrarAddEditModal()
                  me.dismissCountDown = me.dismissSecs; //contador para el alert

                  if (response.data.error) {
                    me.errorMsg = response.data.message
                  }
                  else {
                    me.successMsg = response.data.message
                    me.getAllGradoModalidad()
                  }
              })
            }
        },
        cerrarAddEditModal() {
            this.showAddEditModal = false
            this.grado_modalidad.id = ''
            this.grado_modalidad.idgrado_titulo = ''
            this.grado_modalidad.idmodalidad_obtencion = ''
            this.errorMsg = ''
            this.successMsg = ''
        },
        abrirDeleteModal(accion, data = []) {
            this.showDeleteModal = true
            this.errors.clear()

            switch(accion) {
                case 'activar':
                {
                    this.titleDeleteModal = 'Activar Título x Modalidad'
                    this.messageDeleteModal = '¿Desea activar este Título x Modalidad?'
                    this.grado_modalidad.id = data.id
                    this.tipoAccion = 'activar'
                    break
                }
                case 'desactivar':
                {
                    this.titleDeleteModal = 'Desactivar Título x Modalidad'
                    this.messageDeleteModal = '¿Desea desactivar este Título x Modalidad?'
                    this.grado_modalidad.id = data.id
                    this.tipoAccion = 'desactivar'
                    break
                }
            }
        },
        eliminarProgramaEstudios() {
            let me=this
            var formData = this._toFormData(this.grado_modalidad)

            this.axios.post(this.url+"GradoModalidadController.php?action="+this.tipoAccion, formData)
            .then(function(response) {
              me.cerrarDeleteModal()
              me.dismissCountDown = me.dismissSecs //contador para el alert

              if (response.data.error) {
                me.errorMsg = response.data.message
              }
              else {
                me.successMsg = response.data.message
                me.getAllGradoModalidad()
              }
            })
        },
        cerrarDeleteModal() {
            this.showDeleteModal = false
            this.grado_modalidad.id = ''
            this.grado_modalidad.idgrado_titulo = ''
            this.grado_modalidad.idmodalidad_obtencion = ''
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
          this.getAllGradoModalidad() 
          this.getGradoTitulos()
          this.getModalidadesObtencion()          
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
    
    table#tbl-grado-modalidad .flip-list-move {
        transition: transform 1s;
    }    
</style>
