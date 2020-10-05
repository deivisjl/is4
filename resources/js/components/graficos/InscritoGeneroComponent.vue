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
            
         axios.get('/alumnos-genero')
            .then((r)=>{
                this.datos = r.data.data
                console.log(this.datos)
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