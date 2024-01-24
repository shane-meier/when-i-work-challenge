<template>
  <div id="app">
    <img alt="Vue logo" src="./assets/logo.png">
    <JsonUploader/>
  </div>
</template>

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
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
