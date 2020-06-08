<template>
  <div>
   <div class="container-fluid p-4" style="background-color: #fff;">
        <h5 class="text-center font-weight-bold text-uppercase text-danger" v-text="grado_procedimiento.proc_nombre + ': Expedientes'"></h5>      
        <div class="text-center m-3">                           
            <b-button 
            :to="{ name: 'procedimientos', 
                        params: {                             
                            usuario: usuario,
                            grado_modalidad: grado_modalidad                                
                        } 
                 }"
                variant="outline-info"
            > 
                <b-icon icon="arrow-left-short"></b-icon>
                Atras
            </b-button>
        </div> 
        <b-card no-body>
            <b-tabs pills card vertical>
                <b-tab title="Recibidos" @click="getExpedientes(grado_procedimiento.id, grado_procedimiento.tipo_rol)" active>                
                    <div class="row">
                        <div class="col-lg-12">
                            <b-row>
                                <b-col md="4" class="my-1">
                                    <b-form-group label-cols-sm="6" label="Expedientes por página: " class="mb-0">
                                        <b-form-select v-model="perPage" :options="pageOptions"></b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col offset-md="4" md="4" class="my-1">
                                    <b-form-group label-cols-sm="3" label="Buscar: " class="mb-0">
                                        <b-input-group>
                                            <b-form-input v-model="filter" placeholder="Escriba el texto a buscar..."></b-form-input>
                                            <b-input-group-append>
                                                <b-button :disabled="!filter" @click="filter = ''">Limpiar</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>                        
                            </b-row>      
                            <b-table
                                bordered
                                striped
                                :items="array_expediente"
                                :fields="columnas"               
                                show-empty
                                empty-text="No hay expedientes recibidos que mostrar."
                                :current-page="currentPage"
                                :per-page="perPage"
                                :filter="filter"
                                @filtered="onFiltered" 
                                empty-filtered-text="No hay expedientes que coincidan con su búsqueda."
                                :busy="isBusy"                                
                            >                         
                                <template v-slot:cell(estado)="data">
                                    <b-badge :variant="color_estados[data.item.estado]">{{data.item.estado}}</b-badge>
                                </template> 
                                <template v-slot:cell(acciones)="data">                                 
                                    <b-button variant="success" size="sm" data-toggle="tooltip" data-placement="left" title="Evaluar" 
                                    :to="{ name: 'info-expediente' + grado_modalidad.id, 
                                            params: {   nombre_componente: grado_procedimiento.url_formulario, 
                                                        usuario: usuario,                                                        
                                                        grado_modalidad: grado_modalidad,                                                          
                                                        grado_procedimiento: grado_procedimiento,  
                                                        idexpediente: data.item.id,                                                                                                                  
                                                    } 
                                            }"
                                    >
                                    <i class="fa fa-edit"></i> Evaluar
                                    </b-button>                        
                                </template>
                                <template v-slot:table-busy>
                                    <div class="text-center text-danger my-2">
                                        <b-spinner class="align-middle"></b-spinner>
                                        <strong>Cargando...</strong>
                                    </div>
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
                </b-tab>
                <b-tab title="Enviados" @click="getExpedientesEnviados(grado_procedimiento.id)"> 
                    <div class="row">
                        <div class="col-lg-12">
                            <b-row>
                                <b-col md="4" class="my-1">
                                    <b-form-group label-cols-sm="6" label="Expedientes por página: " class="mb-0">
                                        <b-form-select v-model="perPage" :options="pageOptions"></b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col offset-md="4" md="4" class="my-1">
                                    <b-form-group label-cols-sm="3" label="Buscar: " class="mb-0">
                                        <b-input-group>
                                            <b-form-input v-model="filter" placeholder="Escriba el texto a buscar..."></b-form-input>
                                            <b-input-group-append>
                                                <b-button :disabled="!filter" @click="filter = ''">Limpiar</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>                        
                            </b-row>      
                            <b-table
                                bordered
                                striped
                                :items="array_exp_enviados"
                                :fields="columnas_enviados"               
                                show-empty
                                empty-text="No hay expedientes enviados que mostrar."
                                :current-page="currentPage"
                                :per-page="perPage"
                                :filter="filter"
                                @filtered="onFiltered" 
                                empty-filtered-text="No hay expedientes que coincidan con su búsqueda."
                                :busy="isBusy"
                            >                         
                                <template v-slot:cell(estado)="data">
                                    <b-badge :variant="color_estados[data.item.estado]">{{data.item.estado}}</b-badge>
                                </template> 
                                <template v-slot:cell(acciones)="data">                                 
                                    <b-button variant="warning" size="sm" title="Deshacer" 
                                        @click="deshacer(data.item.id, data.item.idexpediente, data.item.idgradproc_origen, data.item.fecha_ant, data.item.etiqueta)">
                                        <i class="fa fa-edit"></i> Deshacer
                                    </b-button>                        
                                </template>    
                                <template v-slot:table-busy>
                                    <div class="text-center text-danger my-2">
                                        <b-spinner class="align-middle"></b-spinner>
                                        <strong>Cargando...</strong>
                                    </div>
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
                </b-tab>
            </b-tabs>                                        
        </b-card>
   </div>  
</div>   
</template>

<script>
export default {
  name: 'menu-procedimientos',   
  props: {        
    usuario: Object,
    grado_modalidad: Object,
    grado_procedimiento: Object        
  },    
  data() {
    return {                               
        url: this.$root.API_URL,
        color_estados : this.$root.color_estados,
        estados : this.$root.estados,                                
        array_expediente : [],  
        array_exp_enviados: [],              
        columnas: [
            { key: 'codigo', label: 'Código', class: 'text-center' },
            { key: 'graduando', label: 'Graduando (s)' },            
            { key: 'escuela', label: 'Escuela' },                    
            { key: 'fecha_recepcion', label: 'Fecha Recepción', class: 'text-center' },
            { key: 'estado', label: 'Estado', class: 'text-center' },
            { key: 'acciones', label: 'Acciones', class: 'text-center' }
        ],
        columnas_enviados: [
            { key: 'codigo', label: 'Código', class: 'text-center' },
            { key: 'graduando', label: 'Graduando (s)' },            
            { key: 'escuela', label: 'Escuela' },                    
            { key: 'fecha_envio', label: 'Fecha Envio', class: 'text-center' },
            { key: 'estado', label: 'Estado', class: 'text-center' },
            { key: 'acciones', label: 'Acciones', class: 'text-center' }
        ],    
        totalRows: 1,
        currentPage: 1,
        perPage: 5,
        pageOptions: [5, 10, 15],
        filter: null,  
        isBusy: false,
    }
  },  
  methods: {            
    getExpedientes(idgrado_procedimiento, tipo_rol) {     
        let me = this                           
        let formData = this._toFormData({
            idgrado_procedimiento: idgrado_procedimiento,                         
            codi_usuario: this.usuario.codi_usuario,
            tipo_usuario: this.usuario.tipo,
            tipo_rol: tipo_rol
        })
        this.toggleBusy()

        this.axios.post(`${this.url}/Expediente/getList`, formData)
        .then(function(response) {            
            if (!response.data.error) {
                me.array_expediente = response.data.array_expediente
                me.totalRows = me.array_expediente.length;                     
            }
            else {
                //console.log(response.data.message)
            }
            me.toggleBusy()
        })            
    },
    getExpedientesEnviados(idgrado_procedimiento) {     
        let me = this                                   
        let formData = this._toFormData({
            idusuario: this.usuario.id,
            idgradproc_origen: idgrado_procedimiento            
        })
        this.toggleBusy()

        this.axios.post(`${this.url}/Movimiento/expedientes_enviados`, formData)
        .then(function(response) {            
            if (!response.data.error) {
                me.array_exp_enviados = response.data.array_exp_enviados
                me.totalRows = me.array_exp_enviados.length;                     
            }
            else {
               //console.log(response.data.message)
            }
            me.toggleBusy()
        })
    },    
    deshacer(idmovimiento, idexpediente, idgradproc_origen, fecha_ant, etiqueta) { // movimiento para derivar el expediente al siguiente procedimiento
        this.$bvModal.msgBoxConfirm(
            '¿Seguro que quiere deshacer el movimiento realizado sobre este expediente?', {
            title: 'Deshacer Movimiento',                    
            okVariant: 'success',
            okTitle: 'Deshacer',
            cancelTitle: 'Cancelar',          
            centered: true
        }).then(value => {
            if (value) {
                let me = this                               
                let formData = this._toFormData({
                    id: idmovimiento,
                    idexpediente: idexpediente,
                    idgradproc_origen: idgradproc_origen,
                    fecha_ant: fecha_ant, //fecha de recepcion del expediente en movimiento anterior
                    estado_expediente_ant: this.estados[etiqueta]
                })                                    

                this.axios.post(`${this.url}/Movimiento/deshacer`, formData)
                .then(function(response) {                                                                             
                    if (!response.data.error) {
                        me.$root.mostrarNotificacion('Éxito!', 'success', 5000, 'done', response.data.message, 'bottom-right')
                        me.getExpedientesEnviados(idgradproc_origen)
                    }
                    else {                           
                        me.$root.mostrarNotificacion('Error!', 'danger', 5000, 'error_outline', response.data.message, 'bottom-right')
                    }
                }) 
            }                   
        })              
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
    toggleBusy() {
        this.isBusy = !this.isBusy
    },
    _countDownChanged(dismissCountDown) {
        this.dismissCountDown = dismissCountDown
    },               
  },
  mounted: function() {         
    if (this.grado_procedimiento != null) { //si se ha establecido id grado modalidad      
      this.getExpedientes(this.grado_procedimiento.id, this.grado_procedimiento.tipo_rol)    
    }
    else {
      this.$router.push({ name: 'home' }); 
    }      
  },
}
</script>

