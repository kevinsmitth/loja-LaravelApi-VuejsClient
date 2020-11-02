<template>
    <div class="container">
        <h1 class="text-center primary--text">Produtos</h1>
        <div class="row">
            <v-card
                :loading="loading"
                class="mx-auto my-12"
                col
                sm="12" md="6" lg="4"
                max-width="374"
                v-for="product in products"
                :key="product.id"
            >
                <router-link :to="{name:'product', params: {id: product.id, name: product.name}}" style="text-decoration:none;">

                    <template slot="progress">
                    <v-progress-linear
                        color="deep-purple"
                        height="10"
                        indeterminate
                    ></v-progress-linear>
                    </template>
                        <div v-for="img in product.image" :key="img.id">
                            <div class="text-center" v-if="img.status == 'destaque'">
                                <img
                                class="w-100"
                                style="max-height:1080px;"
                                :src="baseURL+'storage/'+ img.filename"
                                >
                            </div>
                        </div>
                    <v-card-title>{{product.name}}</v-card-title>

                    <v-card-text>
                    <v-row
                        align="center"
                        class="mx-0"
                    >
                        <v-rating
                        :value="4.5"
                        color="amber"
                        dense
                        half-increments
                        readonly
                        size="14"
                        ></v-rating>

                        <div class="grey--text ml-4">
                        4.5 (413)
                        </div>
                    </v-row>

                    <div class="my-4 subtitle-1">
                        R$ • {{product.price}}
                    </div>

                    <div>{{product.description}}.</div>
                    </v-card-text>
                    </router-link>
            </v-card>
        </div>
    </div>
</template> 

<script>
//import axios from 'axios'
import products from '../store/products'


export default {
  name: 'Shop',
  data(){
      return {
            products:null,
            loading: false,
            baseURL: 'http://127.0.0.1:8000/',
          
      }
  },
  mounted() {
      products.listar().then(response => {
          this.products = response.data.products;
         
      })

    
  },
  methods:{
        
        

    },


}
</script>