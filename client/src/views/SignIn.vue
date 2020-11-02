<template>
    <div class="container" >
        <form @submit.prevent="submit" id="form" class="mx-auto text-center my-auto py-3 flex-xs-middle primary">
            <h1 class="text-center mb-5">Entrar</h1>
            <div>
                <label for="email" class="mr-1">Email</label>
                <input type="text" name="email" id="email" v-model="form.email" required>
            </div>
            <div>
                <label for="password">Senha</label>
                <input type="password" name="password" id="password" v-model="form.password" required>
            </div>
            <button type="submit" class="btn btn-success mx-auto mt-5">Entrar</button>
            
        </form>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    name: 'signin',
    components:{

    },

    data() {
        return {
            form: {
                email: '',
                password: '',
            }
        }
    },

    methods:{
        ...mapActions({
            signIn: 'auth/signIn'
        }),
        submit () {
            this.signIn(this.form).then(() => {
                this.$router.replace({
                    name:'dashboard'
                })
            })
        },
    },
}
</script>

<style>
    #form{
        width: 80%;
    }

    input#email, input#password {
        background:#fff;
        margin: 10px;
    }


</style>