<template>
    <div class="text-center">
        <form @submit="uploadimages" enctype="multipart/form-data" method="post">
            <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
            <button class="btn btn-primary" type="submit">Enviar</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios'

export default {

    name: 'product-images',
        data(){
            return{
                form:{
                    file:''
                }
            }
        },
    mounted() {
       
    },
    methods: {
        handleFileUpload(){
    this.file = this.$refs.file.files[0];
  },

        uploadimages(e){

            
        
         
            axios.post("product-images",this.form).then((result)=>{
            console.warn(result)

            });e.preventDefault();
        }
    }
}
</script>