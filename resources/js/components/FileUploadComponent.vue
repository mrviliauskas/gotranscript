<template>
    <div class="container">
        <button id="show-modal" @click="showModal = true">Upload image</button>

        <div class="modal-mask" v-if="showModal">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <div class="modal-body">
                        <slot name="body">
                            <div class="form-group">
                                <label for="image">Choose an image:</label>
                                <input type="file"
                                       class="form-control"
                                       name="image" id="image"
                                       accept="image/png, image/jpeg"
                                       @change="selectFile">
                            </div>
                            <div v-if="this.errors.hasOwnProperty('image')" class="has-error">
                                <ul>
                                    <li v-for="(error, index) in this.errors.image" :key="index">{{error}}</li>
                                </ul>
                            </div>

                            <div class="form-group">
                                <label for="date">Select valid from date:</label>
                                <input type="date"
                                       id="date"
                                       class="form-control"
                                       v-model="valid_from">
                            </div>
                            <div v-if="this.errors.hasOwnProperty('valid_from')" class="has-error">
                                <ul>
                                    <li v-for="(error, index) in this.errors.valid_from" :key="index">{{error}}</li>
                                </ul>
                            </div>
                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="btn-primary" @click="uploadFile">
                                Upload
                            </button>
                            <button class="btn-warning" @click="showModal = false">
                                Cancel
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
          return {
              photo: null,
              valid_from: null,
              showModal: false,
              errors: {}
          }
        },
        methods: {
            selectFile(event) {
                this.image = event.target.files[0];
            },
            uploadFile() {
                this.errors = {};

                const data = new FormData();
                data.append('image', this.image);
                data.append('valid_from', this.valid_from);

                axios.post("/upload-image", data).then(response => {
                    this.showModal = false;
                    this.image = null;
                    this.valid_from = null;
                }, (error) => {
                    this.errors = error.response.data.errors;
                });
            }
        }
    }
</script>

<style scoped>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: table;
        transition: opacity 0.3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 800px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
        transition: all 0.3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }

    .has-error li {
        color: red;
    }
</style>
