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
                            <td><a href="" class="btn-primary btn-sm" @click.prevent="imprimir(item)"><i class="fas fa-print"></i> Imprimir</a></td>
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
        imprimir(data)
        {
            this.loading = true

            axios({
                url:'/reporte-notas-imprimir/' + data.id,
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