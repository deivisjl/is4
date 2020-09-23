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
                                    <td><a href="" class="btn-success btn-sm float-right" @click.prevent="calificar(curso)"><i class="fas fa-edit"></i> Calificar</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </ul>
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
            cursos:[],
        };
    },
    props:{
        registro:{}
    },
    mounted(){
        this.cursos = this.registro
    },
    methods:{
        calificar(data)
        {
            Toastr.success(data.nombre,'Mensaje')
        }
    }
};
</script>