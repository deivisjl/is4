<template>
	<div>
		<loading v-if="loading"></loading>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="" class="control-label">Mes de pago</label>
                    <select name="mes" id="mes" class="form-control" v-model="model.mes" v-validate="'required'">
                        <template v-for="mes in meses">
                            <option :value="mes.id">{{ mes.nombre }}</option>
                        </template>
                    </select>
                    <error-form :attribute_name="'mes'" :errors_form="errors"></error-form>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Monto Q.</label>
                    <input type="text" class="form-control" name="monto" v-model="model.monto" v-validate="'required|decimal'">
                    <error-form :attribute_name="'monto'" :errors_form="errors"></error-form>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" style="float:right;" @click.prevent="validar()">Pagar</button>
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
            inscrito:'',
            meses:[],

            model:{
                mes:'',
                monto:'',
            },
        };
    },
    props:{
        registro:{}
    },
    mounted(){
        this.inscrito = this.registro
        this.obtener_meses()
    },
    methods:{
        validar()
        {
            this.$validator.validateAll().then((result) =>{
                        if(result){
                           this.pagar()
                        }             
                  });
        },
        pagar()
        {
            this.loading = true

            let datos = {
                'mes':this.model.mes,
                'monto':this.model.monto,
                'inscrito':this.inscrito.id
            }

            axios({
                    url:'/pagos-registrar',
                    data: datos,
                    method:'POST',
                    responseType:'blob'
                })
                .then((r) =>{
                    const blob = new Blob([r.data], {type: r.data.type});
                    const url = window.URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    let fileName = 'pago.pdf';
                    link.setAttribute('download', fileName);
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    window.URL.revokeObjectURL(url);

                    window.location.href = '/pagos'
                })
                .catch()
                .finally(()=>{
                    this.loading = false
                })
        },
        obtener_meses()
        {
            this.loading = true

            let id = this.inscrito.id

            axios('/pagos-historial-meses/'+id)
                .then((r)=>{
                    this.meses = r.data.data
                })
                .catch((error) =>{
                    Toastr.error(error, 'Mensaje')
                })
                .finally(() =>{
                    this.loading = false        
                })
        },
    }
};
</script>