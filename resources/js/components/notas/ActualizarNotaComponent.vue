<template>
    <div>
        <loading v-if="loading"></loading>
        <template v-for="(item, key) in notas_disponibles">
            <div class="form-group">
                <label for="" class="control-label">{{ item.nombre }}</label>
                <div class="input-group input-group-md">
                    <input type="text" class="form-control" :name="'nota_'+key" v-model="item.nota">
                    <span class="input-group-append">
                        <button type="button" class="btn btn-success btn-flat" @click.prevent="editar(item)">Editar</button>
                    </span>
                </div>
            </div>
        </template>
    </div>
</template>
<script>
export default {
    data() {
		return {
            loading: false,
            notas_disponibles:[],
        };
    },
    props:{
        registro:{}
    },
    mounted(){
        this.notas_disponibles = this.registro
    },
    created(){

    },
    methods:{
        editar(data)
        {
            if(!data.nota || data.nota < 1 || data.nota > 25)
            {
                Toastr.error('Debe ingresar una nota entre 1 y 25','Mensaje');
            }
            else
            {
                console.log(data)
                let datos = {
                    'id':data.id,
                    'nota':data.nota
                }

                this.loading = true

                axios.post('/alumno-nota-actualizar',datos)
                    .then((r) =>{
                        console.log(r.data)
                        Toastr.success(r.data.data,'Mensaje')
                    })
                    .catch((error) =>{
                        if(error.response && error.response.status === 423)
                        {
                            Toastr.error(error.response.data.error,'Mensaje')
                        }
                        else
                        {
                            Toastr.error(error,'Mensaje')
                        }
                    })
                    .finally(()=>{
                        this.loading = false
                    })
            }
        }
    }
}
</script>