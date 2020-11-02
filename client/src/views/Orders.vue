<template>
    <div class="text-center">
        <h4 class="text-center">Meus Pedidos</h4>
        <div class="my-5" v-for="order in order_user_id" :key="order.id">
            <h2>Pedido: #{{order.id}}</h2>
            <router-link :to="{name: 'order-item',params: {id: order.id}}">Ver Detalhes</router-link>
        </div>

    </div>
</template>

<script>
import axios from 'axios'

export default {

    name: 'orders',
        data(){
            return{
                order_items: {},
                order_user_id: {},
            }
        },
    mounted() {
        axios.get('/order-items').then(response => {
            this.order_user_id = response.data.order_user_id
            this.order_items = response.data.order_items
        })
    },
    
}
</script>