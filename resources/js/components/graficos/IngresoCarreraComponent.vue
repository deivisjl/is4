<template>
  <div>
      <loading v-if="loading"></loading>
      <pie-chart :data="datos"></pie-chart>
  </div>
</template>


<script>
  export default {
    
    data () {
      return {
        loading : false,
        datos:[],
      }
    },
    mounted () {
      
    },
    created()
    {
        this.obtener_datos()
    },
    methods: {
      obtener_datos()
      {
          this.loading = true
            
         axios.get('/grafico-ingreso-carrera')
            .then((r)=>{
                this.datos = r.data.data
            })
            .catch((error) =>{
                Toastr.error(error, 'Mensaje');
            })
            .finally(()=>{
                this.loading = false
            })
      }
    }
  }
</script>