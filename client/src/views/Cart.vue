<template>
    <div class="text-center">
        <h1 class="mb-5">Carrinho</h1>
        <div v-if="cart == null">
            <h3>Vazio..</h3>
        </div>
        <div v-else>
            <div v-for="itens in cart" :key="itens.id">
                <h3>{{itens.produto.name}}</h3>
                <h3>R$ {{itens.produto.price}}</h3>
                <h3>Quantidade: {{itens.quantity}}</h3>
                <h3>{{itens.produto.description}}</h3>
                <h3>SubTotal: R$ {{itens.value}}</h3>
            </div>
            <h2>Total: R$ {{total}}</h2>
            <div>
                <form @submit.prevent="order">
                    <div class="form-group mx-auto">
                        <label class="mx-auto" for="formaPagamento">Forma de Pagamento:</label>
                        <select name="payment_type_id" v-model="form.payment_type_id" class="form-control-md col-1 mx-auto text-center text-capitalize" id="formaPagamento">
                        <option class="" v-for="paymentType in paymentTypes" :key="paymentType.id" :value="paymentType.id">{{paymentType.name}}</option>
                        </select>
                        <h3>Seu Endereço: {{userAddress.street}}</h3>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Confirmar Pedido</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name:"cart",
    data(){
            return {
                    cart:null,
                    total: '0,00',
                    paymentTypes: [],
                    userAddress: [],
                    form:{
                        payment_type_id: null,
                    },
            }
        },
    mounted() {
    axios
        .get('cart-products'
                        
        )
        .then(response => {
            this.total = response.data.total.replace('.', ',');
            this.cart = response.data.cart
            this.userAddress = response.data.userAddress
        
        }),
    axios.get('payment-types').then(response => {
        this.paymentTypes = response.data
    })

    /*axios
        .post('cart'
                        
        )
        .then(response => {
            this.cart = response.data.items
            this.total = response.data.total
        }),*/

        
    },

    methods: {
        order () {
            axios.post("orders",this.form).then(()=>{
            this.$router.replace({
                    name:'orders'
                })

            });
            
        }
    }


}
</script>