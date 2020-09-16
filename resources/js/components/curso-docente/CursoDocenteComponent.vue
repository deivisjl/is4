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
        <div class="dropdown-divider" v-if="cursos.length > 0"></div>
        <div class="row">
            <template v-for="(item, key) in cursos">
                <div class="col-md-3">
                    <div class="card card-default">
                        <div class="card-header-custom text-center">
                            <h5>{{ item.nombre }}</h5>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="control-label">Curso impartido por:</label>
                                        <select name="profesor" id="profesor" class="custom-select" v-model="item.profesor_id">
                                            <template v-for="profesor in profesores">
                                                <option :value="profesor.id">{{ profesor.nombre }}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <div class="row" v-if="cursos.length > 0">
            <div class="col-md-12">
                <button class="btn btn-primary btn-block btn-lg" @click.prevent="validar()">Guardar</button>
            </div>
        </div>
	</div>
</template>
<script>
export default {
	data() {
		return {
            loading: false,
            texto_boton:"Asignar",
            nombre: "",
            carrera:"",
			carreras: [],
            aula: "",
            aulas:[],
            asignado:false,
            cursos:[],
            profesores:[],
		};
	},
	props: {
		registro: {},
	},
	mounted() {
		this.carreras = this.registro;
	},
	created() {},
	methods: {
        asignar()
        {
            if(this.asignado)
            {
                this.asignado = false
                this.texto_boton = "Asignar"
                this.aulas = []
                this.aula = ""
                this.carrera = ""
                this.cursos = []
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

            Promise.all([this.obtener_cursos(), this.obtener_profesores()])
                .then(resolve=>{
                    this.loading = false
                })
                .catch(error =>{
                    this.loading = false
                })
        },
        obtener_cursos(){
            return new Promise((resolve, reject)=>{
                axios.get('/curso-docente-pensum/' + this.aula)
                    .then(r=>{
                        this.cursos = r.data.data
                        this.asignar_lista()
                        resolve()
                    })
                    .catch(error =>{
                        reject(error)
                    })  
            })
        },
        asignar_lista()
        {
            this.cursos.forEach(data => {                
                data.profesor_id=""
            });
        },
        obtener_profesores(){
            return new Promise((resolve, reject)=>{
                axios.get('/curso-docente-profesores')
                    .then(r=>{
                        this.profesores = r.data.data
                        resolve()
                    })
                    .catch(error =>{
                        reject(error)
                    })
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
        validar()
        {
            var completado = true

            this.cursos.forEach(registro =>{
                if(registro.profesor_id < 1)
                {
                    completado = false
                }
            })

            if(!completado)
            {
                Toastr.warning('Hay cursos sin asignar','Mensaje');
            }
            else
            {
                this.guardar()
            }
        },
		guardar() {
			let data = {
                aula_id: this.aula,
                asignacion: this.cursos
			};
            this.loading = true;

            axios.post("/curso-docente",data)			
				.then((r) => {
					Toastr.success(r.data.data, "Mensaje");
					window.location.href = "/docentes";
				})
				.catch((error) => {
					Toastr.error(error.response.data.error, "Mensaje");
                })
                .finally(()=>{
                    this.loading = false
                });
		},
		cancelar() {
			window.history.back();
		},
	}
};
</script>