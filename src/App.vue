<script>
import JsonUploader from './components/json-uploader.vue'

export default {
  name: 'App',
  components: {
    JsonUploader
  }
}
</script>

<style>
/* basic styling from initial app creation */
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>

<template>
  <div id="app">
    <img alt="When I Work Logo" src="./assets/when_i_work_logo_icon_144741.png">
    <JsonUploader/>
  </div>
</template>
