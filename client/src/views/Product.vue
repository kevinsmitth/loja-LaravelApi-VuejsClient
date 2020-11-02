<template>
    <div>
        <h1 class="text-center mb-5 text-capitalize primary--text">{{product.name}}</h1>
        <div class="container text-center" >
            
                    <template>
                        <v-carousel class="mx-auto text-center" style="max-width:800px">
                            <v-carousel-item 
                            v-for="image in productImages" :key="image.id"
                            reverse-transition="fade-transition" transition="fade-transition">
                            <v-img :src="baseURL+'storage/'+image.filename" alt=""
                            aspect-ratio="2" class="h-100" style="object-fit: cover;"></v-img>
                            </v-carousel-item>
                        </v-carousel>
                        <div class="mt-3">
                            <h3 class="primary--text">{{product.name}}</h3>
                            <p>{{product.description}}</p>
                            <h5 class="primary--text">R$ {{product.price}}</h5>
                        </div>
                    </template>
                    <form @submit.prevent="submit" method="post" class="mx-auto my-3">
                        <div class="my-5">
                            <label class="primary--text" for="quantity">Quantidade:</label>
                            <input class="mx-3 primary text-center" type="number" name="quantity" min="1" max="100" id="quantity"
                             v-model="form.quantity" value="1" required style="border-radius:3px;"
                             maxlength="3">
                        </div> 
                        <input class="btn primary" type="submit" value="Adicionar ao Carrinho">
                        
                    </form>
        </div>

    </div>
</template>

<script>
//import product from '../store/product'
import axios from 'axios'

export default {
    
    name: 'product',
        data(){
            return {
                    id:this.$route.params.id,
                    loading:false,
                    product:{},
                    productImages:[],
                    errors: [],
                    baseURL: 'http://127.0.0.1:8000/',
                    form:{
                        quantity: null,
                        product_id: this.$route.params.id
                    }

                    
            }
        },
    mounted() {
    
    axios
        .get(`/products/${this.id}`
                        
        )
        .then(response => {
            this.product = response.data.product
            this.productImages = response.data.productImages
            this.product.price = response.data.product.price.replace('.', ',');
        })

        
    },
  
  methods:{
 
        submit (e) {
            axios.post("cart-products",this.form).then(()=>{
            this.$router.replace({
                    name:'cart'
                })

            })
            e.preventDefault();
            /*

                axios
                    .post('cart-products',{
                        product_id: this.product_id,
                        quantity: this.quantity,

                    })
                    .then(response => {
                    this.onSuccess(response.data);
                    })
                    .catch(error => {
                    console.log("ERRRR:: ",error.data);
                    });*/
        },
    }
  

    
    
}
</script>