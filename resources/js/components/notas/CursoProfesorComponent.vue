<template>
	<div>
		<loading v-if="loading"></loading>
		<div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-valign-middle table-hover">
                    <ul class="nav flex-column">
                        <table class="table table-hover">
                            <tbody>
                                <tr v-for="curso in cursos">
                                    <td>{{ curso.nombre }}</td>
                                    <td style="text-align:right; width:20%"><a href="" class="btn-success btn-sm float-right" @click.prevent="calificar(curso)"><i class="fas fa-edit"></i> Calificar</a></td>
                                    <td style="width:20%"><a href="" class="btn-primary btn-sm float-right" @click.prevent="reporte(curso)"><i class="fas fa-address-book"></i> Reporte</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </ul>
                </table>
            </div>
        </div>
         <!-- <div class="modal fade" id="modal-lg" style="display: none;" aria-hidden="true"> -->
        <nota-component :registro="curso_cargar" v-if="calificar_curso"></nota-component>
	</div>
</template>
<script>
import NotaComponent from './NotaComponent';

export default {
	data() {
		return {
            loading: false,
            cursos:[],
            curso_cargar:{},
            calificar_curso:false,
        };
    },
    components:{
        NotaComponent
    },
    props:{
        registro:{}
    },
    mounted(){
        this.cursos = this.registro
        events.$on('ocultar_modal', this.event_ocultar_modal)
    },
    beforeDestroy() {
        events.$off('ocultar_modal', this.event_ocultar_modal)
    },
    methods:{
        reporte(data)
        {
            this.loading = true

            axios({
                url:'/alumnos-curso-reporte/' + data.id,
                method:'GET',
                responseType:'blob'
            })
            .then((r) =>{
                 const blob = new Blob([r.data], {type: r.data.type});
                  const url = window.URL.createObjectURL(blob);
                  const link = document.createElement('a');
                  link.href = url;
                  let fileName = 'calificaciones.pdf';
                  link.setAttribute('download', fileName);
                  document.body.appendChild(link);
                  link.click();
                  link.remove();
                  window.URL.revokeObjectURL(url);
            })
            .catch((error) => {
                Toast.error(error,'Mensaje');
            })
            .finally(()=>{
                this.loading = false
            })
        },
        calificar(data)
        {
            this.curso_cargar = data
            this.calificar_curso = true
        },
        event_ocultar_modal(data)
        {
            if(this.calificar_curso)
            {
                this.calificar_curso = false
                this.curso_cargar = {}
            }
        }
    }
};
</script>