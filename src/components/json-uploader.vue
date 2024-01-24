<script>
import axios from 'axios';
export default {
  name: 'json-uploader',
  props: {
    msg: String
  },

  data() {
    return {
      validJsonFile: false,
      uploadedFile: null,
    }
  },

  methods: {
    handleJsonFile(event) {
      // reset the uploadedFile incase of incorrect format 
      this.uploadedFile = event.target.files[0];

      // Need to check if the file uploaded is valid before continuing
      if (this.uploadedFile) {
        const reader = new FileReader();

        reader.onload = function (e) {
          try {
            const jsonData = JSON.parse(e.target.result);
            alert('Successfully uploaded JSON file');
            console.log('JSON is valid:', jsonData);
          } catch (error) {
            alert('Invalid JSON file. Please upload a valid JSON file.');
            this.uploadFile = null;
            // document.getElementById("json-uploader-input").reset();
          }
        };

        reader.readAsText(this.uploadedFile);
      }
    },

    uploadFile() {
      if (this.uploadedFile) {

        const fileData = new FormData();
        fileData.append("file", this.uploadedFile);

        // Using Axios in place of a proper and secure connection for quick purposes
        axios.post("http://localhost:3000/API/index.php", fileData)
          .then(response => {
            console.log(response.data);
          })
          .catch(error => {
            console.error(error);
          });
      }
    }
  }
}
</script>

<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>

<template>
  <div>

      <p>Please upload a shift file in JSON format</p>
      <input type="file" @change="handleJsonFile" placeholder="123-45-678"/>
      <button :disabled="!this.uploadedFile" @click="uploadFile">Upload</button>

  </div>
</template>
