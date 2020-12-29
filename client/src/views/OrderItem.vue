<template>
    <div class="text-center">
        <h4 class="text-center">Meus Pedidos</h4>
        <div v-for="item in order" :key="item.id">
            <h2>Pedido: #{{item.id}}</h2>
            <h3>Forma de Pagamento: {{item.payment_type.name}}</h3>
            <h3>Valor Total do Pedido: R$ {{item.total}}</h3>
            <h3>Status: {{item.status}}..</h3>
        </div>
        <div v-for="(items) in order_items" :key="items.id + 'A'">
            <h2>Produto(s): {{items.product.name}}</h2>
            <h2>Quantidade: {{items.quantity}}</h2>
            <h2>Subtotal: R$ {{items.value}}</h2>
        </div>

    </div>
</template>

<script>
import axios from 'axios'

export default {

    name: 'order-item',
        data(){
            return {
                    id:this.$route.params.id,
                    loading:false,
                    order:{},
                    order_items:{},
                    errors: [],

            }
        },
    mounted() {
    
    axios
        .get(`/order-items/${this.id}`
                        
        )
        .then(response => {
            this.order = response.data.order
            this.order_items = response.data.order_items
        })

        
    },
    
}
</script>