<template>
  <v-app id="app" >
      <TheNavigation/>
    <router-view></router-view>
  </v-app>

</template>

<script>
  import TheNavigation from '@/components/TheNavigation/TheNavigation'

  export default {
    name: "app",
    components: {
      TheNavigation
    },
    computed: {
      theme(){
      return (this.$vuetify.theme.dark) ? 'dark' : 'light'
    }
    },
    
  }
</script>

<style>
#app {
    background-color: var(--v-background-base);
}
</style>
