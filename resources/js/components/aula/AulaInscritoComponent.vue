<template>
	<div>
		<loading v-if="loading"></loading>
        <div class="dropdown-divider" v-if="alumnos.length > 0"></div>
        <div class="row" v-if="alumnos.length > 0">
            <div class="col-md-12">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Código SIRE</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,key) in alumnos">
                            <td>{{ key + 1 }}</td>
                            <td>{{ item.nombres }}</td>
                            <td>{{ item.apellidos }}</td>
                            <td>{{ item.sire_id }}</td>
                            <td><a href="" class="btn-danger btn-sm" @click.prevent="eliminar(item)"><i class="fas fa-trash"></i> Eliminar</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" v-else>
            <div class="col-md-6 offset-md-3">
                <div class="callout callout-info">
                  <h5>No hay alumnos inscritos en esta aula</h5>
                </div>
            </div>
        </div>
	</div>
</template>
<script>
export default {
	data() {
		return {
            loading: false,
            alumnos:[],
            aula:'',
        };
    },
    props:{
        registro:{}
    },
    mounted(){
        this.aula = this.registro
        this.obtener_alumnos()
    },
    methods:{
        eliminar(data)
        {

            Swal.fire({
                  title: '¿Está seguro de eliminar este alumno?',
                  //text: 'Confirmar',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar'
                }).then((result) => {
                   if (result.value) {
                      this.loading = true

                      axios.delete('/eliminar-inscrito/' + data.id)
                          .then(response => {
                              Toastr.success(response.data.data,'Mensaje')
                              this.obtener_alumnos()
                          })
                          .catch(error => {
                              this.loading = false

                              if (error.response.status === 423) {
                                  Toastr.error(error.response.data.error,'Error'); 
                              }else{
                                  Toastr.error('Ocurrió un error: ' + error,'Error');
                              }
                          });
                   }
                    
                });
        },
         obtener_alumnos(){
            
            this.loading = true

            axios.get('/listar-alumnos-aula/'+this.aula)
                .then(r=>{
                    this.alumnos = r.data.data
                })
                .catch(error =>{
                    Toastr.error(error.response.data.error, 'Mensaje')
                })
                .finally(() =>{
                    this.loading = false
                })
        },
    }
};
</script>