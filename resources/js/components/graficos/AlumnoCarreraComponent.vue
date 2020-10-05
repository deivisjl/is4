<template>
  <div>
      <loading v-if="loading"></loading>
      <pie-chart :data="datos" :colors="getRandomColor"></pie-chart>
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
    computed:{
        getRandomColor: function()
        {
            var letters = '0123456789ABCDEF'.split('');

            var arreglo = []

            for(var j = 0; j < 12; j++)
            {
                var color = '#';
                for (var i = 0; i < 6; i++ ) {                
                    color += letters[Math.floor(Math.random() * 16)];
                }

                arreglo.push(color)
            }
            
            return arreglo;
        }
    },
    methods: {
      obtener_datos()
      {
          this.loading = true
            
         axios.get('/alumnos-carrera')
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