<template>
	<div>
		<loading v-if="loading"></loading>
		<div class="form-row align-items-center">
            <div class="col-auto my-1">
				<label>Plan</label>
			</div>
			<div class="col-auto my-1">				
				<select name="plan" id="plan" v-model="plan" class="custom-select" @change="activar_opcion()" :disabled="asignado">
                        <template v-for="item in planes">
                            <option :value="item.id">{{ item.nombre }}</option>
                        </template>
                </select>
			</div>
            <div class="col-auto my-1" v-if="activar">
				<label>Carrera</label>
			</div>
			<div class="col-auto my-1" v-if="activar">				
				<select name="aula" id="aula" v-model="carrera" class="custom-select" @change="obtener_aulas()" :disabled="asignado">
                        <template v-for="item in carreras">
                            <option :value="item.id">{{ item.nombre }}</option>
                        </template>
                </select>
			</div>
			<div class="col-auto my-1" v-if="activar">
				<label>Grado y sección</label>
			</div>
            <div class="col-auto my-1" v-if="activar">
                <select name="aula" id="aula" v-model="aula" class="custom-select" :disabled="asignado">
                    <template v-for="item in aulas">
                            <option :value="item.id">{{ item.aula }}, Sección {{ item.seccion }}</option>
                    </template>
                </select>
            </div>
			<div class="col-auto my-1" v-if="aula && activar">
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
            activar:false,
            planes:[],
            plan:'',
        };
    },
    props:{
        registro:{},
        plans:{},
    },
    mounted(){
        this.carreras = this.registro
        this.planes = this.plans
    },
    methods:{
        activar_opcion()
        {
            this.activar = true
            this.carrera = ''
            this.aulas = []
            this.aula = ''
        },
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
            if(this.plan > 0)
            {
                this.aulas = []
                this.aula = ''
                this.loading = true

                axios.get('/curso-docente-aulas?carrera='+this.carrera+'&plan='+this.plan)
                    .then(r=>{
                        this.aulas = r.data.data
                    })
                    .catch(error =>{

                    })
                    .finally(() =>{
                        this.loading = false
                    })
            }
            else
            {
                Toastr.warning('Hay campos sin seleccionar','Mensaje')
            }
        },
        asignar()
        {
            if(this.plan > 0 && this.aula > 0){
                
                if(this.asignado)
                {
                    this.asignado = false
                    this.texto_boton = "Inscribir"
                    this.aulas = []
                    this.aula = ""
                    this.carrera = ""
                    this.alumnos = []
                    this.plan = ''
                    this.activar = false
                }
                else
                {
                    this.asignado = true
                    this.texto_boton = "Cambiar"
                    this.obtener_datos()
                }
            }
            else{
                Toastr.warning('Existen opciones sin seleccionar','Mensaje')
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