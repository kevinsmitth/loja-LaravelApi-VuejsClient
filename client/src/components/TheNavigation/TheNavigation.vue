<template>
        <ul class="text-center mx-3" id="navigation-ul">
            <li>
                <router-link tag="li" to="/" name="home"><a href="#">Home</a></router-link> 
            </li>
            <li>
                <router-link tag="li" to="/shop" name="shop"><a href="#">Loja</a></router-link> 
            </li>
            
                <input type="checkbox" id="switch"/><label id="switch-label" class="ml-auto" for="switch" @click="$vuetify.theme.dark = ! $vuetify.theme.dark"
            >Toggle</label> 
            <template v-if="authenticated">
                <li>
                    <i class="text-capitalize">Olá, {{user.name}}</i>
                </li>
                <li>
                    <router-link tag="li" to="/cart" name="cart"><a href="">Carrinho</a></router-link> 
                </li>
                <li>
                    <router-link tag="li" :to="{name: 'orders'}" name="orders"><a href="">Pedidos</a></router-link> 
                </li>
                <li>
                    <router-link tag="li" to="/dashboard" name="dashboard"><a href="">Dashboard</a></router-link> 
                </li>
                <li>
                    <a href="#" @click.prevent="signOut">Sair</a>
                </li>
            </template>
            <template v-else-if="!authenticated">
                <li>
                    <router-link tag ="li" to="/signin" name="signin"><a href="">Entrar</a></router-link> 
                </li>
            </template>
        </ul>
</template>

<script>
    import './style.css'
    import {mapGetters, mapActions} from 'vuex'
    export default {
        computed: {
            ...mapGetters({
                authenticated: 'auth/authenticated',
                user: 'auth/user',
            })
        },

        methods: {
            ...mapActions({
                signOutAction:'auth/signOut'
            }),

            signOut(){
                this.signOutAction().then(() => {
                    this.$router.replace({
                        name:'home'
                    })
                })
            }
        },
    }
</script>


