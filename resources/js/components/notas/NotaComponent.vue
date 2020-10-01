<template>
    <div>
        <div class="modal fade show" id="modal-lg" style="display:block; padding-right:19px; background-color: #00000080; overflow-x: hidden;
    overflow-y: auto;" data-backdrop="static">
            <loading v-if="loading_modal"></loading>
           <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Curso de {{ curso_actual.nombre }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="ocultar_modal()">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label">Seleccione bimestre</label>
                    <select name="bimestre" id="bimestre" class="form-control" @change="validar_bimestre()" v-model="bimestre">
                        <template v-for="item in bimestres">
                            <option :value="item.id">{{ item.nombre }}</option>
                        </template>
                    </select>
                </div>
                <div class="card card-default" v-if="alumnos.length > 0">
                    <div class="card-body">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Código SIRE</th>
                                    <th>Alumno</th>
                                    <th>Puntuación</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(alumno,key) in alumnos">
                                    <td>{{ key + 1 }}</td>
                                    <td>{{ alumno.sire_id }}</td>
                                    <td>{{ alumno.nombre }}</td>
                                    <td width="15%">
                                        <input type="text" class="form-control form-control-sm" v-model="alumno.nota">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" @click.prevent="ocultar_modal()">Cancelar</button>
              <button type="button" class="btn btn-primary" @click.prevent="validar_notas()">Guardar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog --> 
        </div>
    </div>
</template>
<script>
export default {
	data() {
		return {
            alumnos:[],
            curso_actual:'',
            loading_modal:false,
            bimestres:[],
            bimestre:'',
        };
    },
    props:{
        registro:{}
    },
    mounted(){
        this.curso_actual = this.registro
        this.obtener_bimestres()
    },
    created(){
    },
    methods:{
        guardar()
        {
            let datos = {
                'pensum_id':this.curso_actual.pensum_id,
                'bimestre_id':this.bimestre,
                'notas':this.alumnos
            }
            this.loading_modal = true

            axios.post("/alumnos-curso-nota",datos)			
				.then((r) => {
                    Toastr.success(r.data.data,'Mensaje');
                    this.alumnos = []
                    this.ocultar_modal()
				})
				.catch((error) => {
                    Toastr.error(error.response.data.error, "Mensaje");
                })
                .finally(()=>{
                    this.loading_modal = false
                });
        },
        validar_notas()
        {
            var completado = true

            this.alumnos.forEach(registro =>{

                if(registro.nota == '' || registro.nota < 1)
                {
                    completado = false
                }
            })

            if(!completado)
            {
                Toastr.warning('Hay alumnos sin asignar nota','Mensaje');
            }
            else
            {
                this.guardar()
            }
        },
        obtener_alumnos()
        {
            this.loading_modal = true

            let datos = this.curso_actual.id

            axios.get("/alumnos-curso/" + datos)			
				.then((r) => {
                    this.alumnos = r.data.data
                    this.asignar_lista()
				})
				.catch((error) => {
                    Toastr.error(error.response.data.error, "Mensaje");
                    this.alumnos = []
                })
                .finally(()=>{
                    this.loading_modal = false
                });
        },
        asignar_lista()
        {
            this.alumnos.forEach(data => {                
                data.nota=""
            });
        },
        obtener_bimestres()
        {
            this.loading_modal = true

            axios.get("/bimestres")			
				.then((r) => {
                    this.bimestres = r.data.data
				})
				.catch((error) => {
					Toastr.error(error.response.data.error, "Mensaje");
                })
                .finally(()=>{
                    this.loading_modal = false
                });
        },
        validar_bimestre()
        {
            this.loading_modal = true

            let datos ={
                'pensum_id':this.curso_actual.pensum_id,
                'bimestre_id':this.bimestre,
                'aula_id':this.curso_actual.aula_id
            }
            
            axios.post("/bimestre-validar",datos)			
				.then((r) => {
                    Toastr.info(r.data.data, "Mensaje");
                    this.obtener_alumnos()
				})
				.catch((error) => {
                    Toastr.error(error.response.data.error, "Mensaje");
                    this.alumnos = []
                })
                .finally(()=>{
                    this.loading_modal = false
                });
        },
        ocultar_modal()
        {
            events.$emit("ocultar_modal",true)
        }
    }
};
</script>