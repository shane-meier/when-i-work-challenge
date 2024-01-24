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
            alert('Successfully calculated timesheet, Your browser will now download the calculated data for you');
            this.downloadFile(response.data);
            console.log(response.data);
          })
          .catch(error => {
            alert('There was an error during Timesheet calculation');
            console.error(error);
          });
      }
    },

    downloadFile(responseData) {
      const jsonData = JSON.stringify(responseData);
      const blob = new Blob([jsonData], { type: 'application/json' });
      const url = URL.createObjectURL(blob);

      const link = document.createElement('a');
      link.href = url;
      link.download = 'data.json';

      link.click();

      URL.revokeObjectURL(url);
    }
  }
}
</script>

<style scoped>
/* move styling to a proper css file */
h3 {
  margin: 40px 0 20px;
}

.header-box {
  float: center;
}

.upload-button {
  margin-top: 20px;
}
</style>

<template>
  <div class="header-box">
    <div>
      <h3 class="header-text">Please upload a timesheet file in JSON format</h3>
      <input type="file" @change="handleJsonFile" />
    </div>
    <div class="upload-button" v-if="this.uploadedFile">
      <button @click="uploadFile">Upload</button>
    </div>
  </div>
</template>
