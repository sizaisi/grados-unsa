<template>
  <div>
   <div class="container-fluid pt-2 pb-3" style="background-color: #fff;">
      <h4 class="text-center mt-3 text-info" 
          v-text="grado_modalidad.nomb_grado_titulo+ ' - '+grado_modalidad.nomb_mod_obtencion">
      </h4>    
      <b-tabs active-nav-item-class="font-weight-bold text-uppercase text-danger" content-class="mt-3" fill>
         <b-tab 
            v-for="(grado_proc, index) in array_grado_procedimiento" 
            :key="index" :title="grado_proc.proc_nombre"
            @click="getExpedientes(grado_proc.id, grado_proc.tipo_rol)" 
            v-bind="activarTabGradoProcedimiento(grado_proc.id)"
         >  
            <b-tabs pills card vertical>
                <b-tab title="Recibidos" @click="getExpedientes(grado_proc.id, grado_proc.tipo_rol)" active>                
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
                            >                         
                                <template v-slot:cell(estado)="data">
                                    <b-badge :variant="color_estados[data.item.estado]">{{data.item.estado}}</b-badge>
                                </template> 
                                <template v-slot:cell(acciones)="data">                                 
                                    <b-button variant="success" size="sm" data-toggle="tooltip" data-placement="left" title="Evaluar" 
                                    :to="{ name: 'info-expediente'+idgrado_modalidad, 
                                            params: { nombre_componente: grado_proc.url_formulario, 
                                                        idgrado_proc: grado_proc.id,  
                                                        idexpediente: data.item.id,  
                                                        idusuario: idusuario, 
                                                        codi_usuario: codi_usuario,  
                                                        idrol_area: idrol_area, 
                                                        tipo_rol: grado_proc.tipo_rol,
                                                        tipo_usuario: tipo_usuario, 
                                                    } 
                                            }"
                                    >
                                    <i class="fa fa-edit"></i> Evaluar
                                    </b-button>                        
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
                <b-tab title="Enviados" @click="getExpedientesEnviados(grado_proc.id)"> 
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
         </b-tab>         
      </b-tabs>
   </div>  
</div>   
</template>

<script>
export default {
  name: 'menu-procedimientos', 
  props: ['idgrado_modalidad', 'idgrado_proc', 'idusuario', 'codi_usuario', 'idrol_area', 'tipo_rol', 'tipo_usuario'],  
  data() {
    return {                               
        url: this.$root.API_URL,
        color_estados : this.$root.color_estados,
        estados : this.$root.estados,              
        grado_modalidad : {},
        array_grado_procedimiento : [],       
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
    }
  },  
  methods: {        
    activarTabGradoProcedimiento(idgrado_proc) {          
      //si el idgrado_proc de uno los tabs es igual al idgrado_proc devuelto activarlo
      if (idgrado_proc == this.idgrado_proc) {
        return { [`active`]: '' }         
      }
      else {
        return null
      }        
    },    
    getGradoModalidad() {      
        let me = this          
        
        var formData = this._toFormData({
            idgrado_modalidad: me.idgrado_modalidad,                  
        })

        this.axios.post(`${this.url}/GradoModalidad/get`, formData)
        .then(function(response) {
            if (response.data.error) {
                me.errorMsg = response.data.message
            }
            else {
                me.grado_modalidad = response.data.grado_modalidad                            
            }
        })
    },       
    getGradoProcedimientos() {
        let me = this
        let formData = this._toFormData({
            idgrado_modalidad: this.idgrado_modalidad,
            idrol_area: this.idrol_area,
            idusuario: this.idusuario                         
        })

        this.axios.post(`${this.url}/GradoProcedimiento/menu_dinamico`, formData)
        .then(function(response) {            
            if (!response.data.error) {
                me.array_grado_procedimiento = response.data.array_grado_procedimiento
                
                if (me.idgrado_proc == null) {
                    //obtener los expedientes del primer grado-procedimiento (por defecto)
                    let grado_proc_inicio = me.array_grado_procedimiento[0]
                    me.getExpedientes(grado_proc_inicio.id, grado_proc_inicio.tipo_rol)
                }                   
                else {                                                            
                    //obtener los expedientes del grado-procedimiento devuelto
                    me.getExpedientes(me.idgrado_proc, me.tipo_rol)
                }                                
            }
            else {                
                //console.log(response.data.message)
            }
        })
    },   
    getExpedientes(idgrado_procedimiento, tipo_rol) {     
        let me = this                           

        var formData = this._toFormData({
            idgrado_procedimiento: idgrado_procedimiento,                         
            codi_usuario: this.codi_usuario,
            tipo_usuario: this.tipo_usuario,
            tipo_rol: tipo_rol
        })

        this.axios.post(`${this.url}/Expediente/getList`, formData)
        .then(function(response) {
            if (response.data.error) {
                me.errorMsg = response.data.message
            }
            else {
                me.array_expediente = response.data.array_expediente
                me.totalRows = me.array_expediente.length;     
            }
        })            
    },
    getExpedientesEnviados(idgrado_procedimiento) {     
        let me = this                                   
        let formData = this._toFormData({
            idusuario: this.idusuario,
            idgradproc_origen: idgrado_procedimiento            
        })

        this.axios.post(`${this.url}/Movimiento/expedientes_enviados`, formData)
        .then(function(response) {            
            if (!response.data.error) {
                me.array_exp_enviados = response.data.array_exp_enviados
                me.totalRows = me.array_exp_enviados.length;                     
            }
            else {
                console.log(response.data.message)
            }
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
    _countDownChanged(dismissCountDown) {
        this.dismissCountDown = dismissCountDown
    },               
  },
  mounted: function() {         
    if (this.idgrado_modalidad != null) { //si se ha establecido id grado modalidad
      this.getGradoModalidad()
      this.getGradoProcedimientos()    
    }
    else {
      this.$router.push({ name: 'home' }); 
    }      
  },
}
</script>

