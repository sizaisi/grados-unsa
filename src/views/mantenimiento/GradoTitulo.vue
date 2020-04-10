<template>
  <div>
    <div class="container pt-2 pb-3" style="background-color: #fff;">
        <div class="row mt-3">
          <div class="col-lg-6">
              <h3 class="text-info">Grados / Títulos</h3>
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
                  id="tbl-grado-titulo"
                  :items="array_grado_titulo"
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
                    <div class="form-group">
                        <label for="grado_titulo">Grado o Título:</label>
                        <input type="text" v-model="grado_titulo.nombre" name="grado_titulo" class="form-control" id="grado_titulo"/>
                        
                    </div>
                    <div class="form-group">
                        <label for="gt_codigo">Código:</label>
                        <b-form-select v-model="grado_titulo.codigo" :options="['W', 'X', 'Y', 'Z']" id="gt_codigo"></b-form-select>       
                    </div>  
                    <div class="form-group">
                        <label for="gt_prereq">Pre-requisito:</label>
                        <b-form-select v-model="grado_titulo.idprereq" :options="select_grado_titulo" id="gt_prereq"></b-form-select>
                    </div>
                    <div class="form-group">
                        <label for="gt_desc">Descripción:</label>
                        <input type="text" v-model="grado_titulo.descripcion" class="form-control" id="gt_desc"/>                        
                    </div>
                  </div>
              </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="cerrarAddEditModal">Cancelar</button>
                <button v-if="tipoAccion=='registrar'" type="button" @click="registrarGradoTitulo" class="btn btn-success">Guardar</button>
                <button v-if="tipoAccion=='actualizar'" type="button" @click="actualizarGradoTitulo" class="btn btn-success">Actualizar</button>
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
              <p class="font-weight-bold text-center" v-text="grado_titulo.nombre"></p>
            </div>
            <div class="modal-footer">
              <b-button variant="secondary" @click="cerrarDeleteModal">Cancelar</b-button>
              <b-button variant="success" @click="anularGradoTitulo">Aceptar</b-button>
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
    name: 'grado-titulo',  
    data() {
        return { 
            url: '//localhost/grados-unsa/backend2',
            array_grado_titulo : [],
            select_grado_titulo: [],
            grado_titulo : {
              id: '',
              nombre: '',
              codigo: '',
              idprereq: 0,
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
              { key: 'nombre', label: 'Nombre', sortable: true },
              { key: 'codigo', label: 'Código', sortable: true, class:'text-center'},
              { key: 'descripcion', label: 'Descripción'},
              { key: 'prerequisito', label: 'Pre-requisito', sortable: true},
              { key: 'condicion', label: 'Condición', class: 'text-center' },
              { key: 'acciones', label: 'Acciones', class: 'text-center' }
            ]                                        
        }
    },
    methods: {
        getAllGradoTitulos() {
          let me = this

          this.axios.get(`${this.url}/GradoTitulo/index`)
            .then(function(response) {
              if (response.data.error) {
                me.errorMsg = response.data.message;
              }
              else {
                me.array_grado_titulo = response.data.array_grado_titulo;

                if (me.select_grado_titulo.length == 0) {
                  me.select_grado_titulo.push({value: 0, text: 'Sin Pre-requisito'});
                  for(var gt of me.array_grado_titulo){
                    me.select_grado_titulo.push({value: gt.id, text: gt.nombre});
                  }
                }         
              }
          })
        },
        abrirAddEditModal(accion, data = []) {
          this.showAddEditModal = true

          switch(accion) {
              case 'registrar':
              {
                  this.titleAddEditModal = 'Registrar Grado o Título'
                  this.grado_titulo.id = ''
                  this.grado_titulo.nombre = ''
                  this.tipoAccion = 'registrar'
                  break
              }
              case 'actualizar':
              {
                  this.titleAddEditModal = 'Actualizar Grado o Título'
                  this.grado_titulo.id = data.id
                  this.grado_titulo.nombre = data.nombre
                  this.grado_titulo.codigo = data.codigo
                  this.grado_titulo.idprereq = data.idprereq
                  this.grado_titulo.descripcion = data.descripcion
                  this.tipoAccion = 'actualizar'
                  break
              }
          }
        },
        registrarGradoTitulo() {
            let me = this

            var formData = this._toFormData(this.grado_titulo)

            this.axios.post(`${this.url}/GradoTitulo/store`, formData)
              .then(function(response) {
                me.cerrarAddEditModal()
                me.dismissCountDown = me.dismissSecs //contador para el alert

                if (response.data.error) {
                  me.errorMsg = response.data.message
                }
                else {
                  me.successMsg = response.data.message
                  me.getAllGradoTitulos()
                }
            })
          
        },
        actualizarGradoTitulo() {
            let me = this     

            var formData = this._toFormData(this.grado_titulo)

            this.axios.post(`${this.url}/GradoTitulo/update`, formData)
              .then(function(response) {
                me.cerrarAddEditModal();
                me.dismissCountDown = me.dismissSecs //contador para el alert

                if (response.data.error) {
                  me.errorMsg = response.data.message
                }
                else {
                  me.successMsg = response.data.message
                  me.getAllGradoTitulos()
                }
            })
          
        },
        cerrarAddEditModal() {
          this.showAddEditModal = false
          this.grado_titulo.id = ''
          this.grado_titulo.nombre = ''
          this.grado_titulo.codigo = ''
          this.grado_titulo.idprereq = 0
          this.grado_titulo.descripcion = ''
          this.errorMsg = ''
          this.successMsg = ''
        },
        abrirDeleteModal(accion, data = []) {
          this.showDeleteModal = true

          switch(accion) {
              case 'activar':
              {
                  this.titleDeleteModal = 'Activar Grado o Título'
                  this.messageDeleteModal = '¿Desea activar este grado o título?'
                  this.grado_titulo.id = data.id
                  this.grado_titulo.nombre = data.nombre
                  this.tipoAccion = 'activar'
                  break
              }
              case 'desactivar':
              {
                  this.titleDeleteModal = 'Desactivar Grado o Título'
                  this.messageDeleteModal = '¿Desea desactivar este grado o título?'
                  this.grado_titulo.id = data.id
                  this.grado_titulo.nombre = data.nombre
                  this.tipoAccion = 'desactivar'
                  break
              }
          }
        },
        anularGradoTitulo() {
          let me = this
          var formData = this._toFormData(this.grado_titulo)

          this.axios.post(`${this.url}/GradoTitulo/${this.tipoAccion}`, formData)
          .then(function(response) {
            me.cerrarDeleteModal()
            me.dismissCountDown = me.dismissSecs //contador para el alert

            if (response.data.error) {
              me.errorMsg = response.data.message
            }
            else {
              me.successMsg = response.data.message
              me.getAllGradoTitulos()
            }
          })
        },
        cerrarDeleteModal() {
          this.showDeleteModal = false
          this.grado_titulo.id = ''
          this.grado_titulo.nombre = ''
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
          this.getAllGradoTitulos()
      },
}
</script>