<template>
	<div>
		<loading v-if="loading"></loading>
		<div class="form-row align-items-center">
            <div class="col-auto my-1">
				<label>Carrera</label>
			</div>
			<div class="col-auto my-1">				
				<select name="aula" id="aula" v-model="carrera" class="custom-select" @change="obtener_aulas()" :disabled="asignado">
                        <template v-for="item in carreras">
                            <option :value="item.id">{{ item.nombre }}</option>
                        </template>
                </select>
			</div>
			<div class="col-auto my-1">
				<label>Grado y sección</label>
			</div>
            <div class="col-auto my-1">
                <select name="aula" id="aula" v-model="aula" class="custom-select" :disabled="asignado">
                    <template v-for="item in aulas">
                            <option :value="item.id">{{ item.aula }}, Sección {{ item.seccion }}</option>
                    </template>
                </select>
            </div>
			<div class="col-auto my-1" v-if="aula">
				<button type="button" class="btn btn-primary" @click.prevent="asignar()">{{ texto_boton }}</button>
			</div>
		</div>
        <div class="row">
            <div class="col-md-6 offset-md-3" v-if="asignado && alumnos.length < 1">
                <div class="callout callout-info">
                    <h5>No hay alumnos disponibles</h5>
                </div>
            </div>
        </div>

        <div class="dropdown-divider" v-if="alumnos.length > 0"></div>
        <div class="row" v-if="alumnos.length > 0">
            <div class="col-md-12">
                <table class="table table-sm table-bordered table-hover">
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
                            <td><button class="btn btn-success btn-sm" @click.prevent="inscribir(item)"><i class="fas fa-edit"></i>Inscribir</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
	</div>
</template>
<script>
export default {
	data() {
		return {
            loading: false,
            texto_boton:"Inscribir",
            carreras:[],
            carrera:'',
            aulas:[],
            aula:'',
            alumnos:[],
            asignado:false,
        };
    },
    props:{
        registro:{}
    },
    mounted(){
        this.carreras = this.registro
    },
    methods:{
        inscribir(data)
        {
            this.loading = true

            let datos = {
                'aula_id':this.aula,
                'alumno_id':data.id
            }

            axios.post('inscripciones',datos)
                .then(r=>{
                    Toastr.success(r.data.data,'Mensaje')
                    this.alumnos.splice(this.alumnos.indexOf(data),1)
                })
                .catch(error =>{
                    Toastr.error(error.response.data.error,'Mensaje');
                })
                .finally(()=>{
                    this.loading = false
                })
        },
         obtener_aulas(){
            this.aulas = []
            this.aula = ''
            this.loading = true

            axios.get('/curso-docente-aulas/'+this.carrera)
                .then(r=>{
                    this.aulas = r.data.data
                })
                .catch(error =>{

                })
                .finally(() =>{
                    this.loading = false
                })
        },
        asignar()
        {
            if(this.asignado)
            {
                this.asignado = false
                this.texto_boton = "Inscribir"
                this.aulas = []
                this.aula = ""
                this.carrera = ""
                this.alumnos = []
            }
            else
            {
                this.asignado = true
                this.texto_boton = "Cambiar"
                this.obtener_datos()
            }
        },
        obtener_datos()
        {
            this.loading = true

            axios.get('/inscripciones-alumnos')
                .then(r=>{
                    this.alumnos = r.data.data
                })
                .catch(error =>{

                })
                .finally(()=>{
                    this.loading = false
                })
        },
    }
};
</script>