<template>
    <div class="container">
        <div class="row  bg-white">
            <div class="col-12">

                <form v-if="!videoSaved && !savingVideo" @submit.prevent="submitForm" class="upload-form">
                    <div class="form-group">
                        <input type="file" id="file" @change="onFileChange" hidden accept="image/*, video/*">
                        <label class="btn btn-secondary d-block w-100" for="file" @click="clearError">Bild / Video auswählen</label>
                        <p v-if="video" class="mt-2"><b>Ausgewähltes Bild / Video:</b></p>
                        <p v-if="video" class="mt-2">{{ video.name }}</p>
                        <p v-if="video" class="mt-2">Dateigröße: {{ fileSize }} MB</p>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 d-block w-100" v-bind:disabled="!video">Hochladen</button>
                </form>
                <div v-if="savingVideo" class="loading-container">
                    <loading
                        :active.sync="savingVideo"
                        :is-full-page="false"
                        :can-cancel="true"
                        @cancel="cancelUpload"
                        class="loading-overlay"
                    ></loading>

                    <div class="loading-message">
                        Bild / Video wird hochgeladen...
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center pb-3">
                        <div v-if="errorMessage" class="video-error-message">
                            {{ errorMessage }}
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center pt-5" v-if="videoSaved">
                    <div class="col-md-8 text-center">
                        <i class="fas fa-check-circle fa-5x my-4" style="color: green;"></i>
                        <h4 class="message-text">{{ message }}</h4>
                        <div class="row mt-4 justify-content-center">
                            <div class="col-md-8 pb-2" v-if="!maxVideosReached">
                                <button @click="resetRecording" class="btn btn-primary btn-block">
                                    Noch ein Bild / Video aufnehmen
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2 justify-content-center">
                            <div class="col-md-8 pb-2">
                                <button @click="goBack" class="btn btn-secondary btn-block">
                                    Zurück zur Aufgabe
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </div>
        </div>
</template>



<script>
import axios from 'axios';
import Loading from 'vue-loading-overlay';
import '../../../css/vue-loading-overlay.css';  // Adjusted path to your CSS file

export default {
    name: "Task6_VideoUpload",
    components: {
        Loading
    },
    data() {
        return {
            video: null,
            videoSaved: false,
            errorMessage: null,
            message: null,
            maxVideosReached: false,
            videoSize: null,
            savingVideo: false,
            uploadCancellation: null,
            cancelButtonText: 'Zurück',
            loadingMessage: 'Video wird hochgeladen',
        }
    },
    methods: {
        clearError() {
            this.errorMessage = null;
        },
        onFileChange(event) {
            this.video = event.target.files[0];
            this.videoSize = 'Calculating...';

            setTimeout(() => {
                // Calculate the size in MB
                let sizeInMB = (this.video.size / (1024 * 1024)).toFixed(2);

                // Check if file is larger than 100MB
                if (sizeInMB > 100) {
                    this.video = null;  // Reset the selected file
                    this.errorMessage = 'Die Datei darf maximal 100 MB groß sein.';
                } else {
                    this.videoSize = sizeInMB;
                }
            }, 200);
        },
        submitForm() {
            this.savingVideo = true;  // Start the spinner
            this.cancelButtonText = 'Abbrechen';

            // Cancel previous upload if any
            if (this.uploadCancellation) {
                this.uploadCancellation.cancel('Upload cancelled by user');
            }

            let formData = new FormData();
            formData.append('video', this.video);
            formData.append('task_number', 8);
            formData.append('type', 'unknown');

            let cancellationSource = axios.CancelToken.source();
            this.uploadCancellation = cancellationSource;

            axios.post('task/save-file', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                cancelToken: cancellationSource.token,
            }).then(response => {
                if (response.data.status === 'success') {
                    this.videoSaved = true;
                    this.message = "Datei hochgeladen.";

                    // Fetch the tasks
                    axios.get('/task/get-all-task', {
                        params: {
                            task: 8,
                        }
                    })
                        .then(response => {
                            let count = response.data.count;
                            if(count === 4){
                                this.message += 'Du hast 4 von 4 Dateien hochgeladen';
                                this.maxVideosReached = true;
                            }
                        })
                        .catch(error => {
                            console.error(error);
                        });

                } else {
                    this.errorMessage = response.data.message;
                }
            }).catch(error => {
                if (axios.isCancel(error)) {
                    console.log('Request canceled', error.message);
                } else {
                    if (error.response && error.response.status === 400) {
                        this.errorMessage = "Maximale Anzahl Dateien für diese Aufgabe erreicht";
                    } else {
                        this.errorMessage = error.message;
                    }
                }
            }).finally(() => {
                this.savingVideo = false;  // Stop the spinner
            });
        },

        goBack() {
            this.$router.go(-1);
        },
        resetRecording() {
            this.video = null;
            this.videoSaved = false;
            this.errorMessage = null;
            this.message = null;
        },
        cancelUpload() {
            if (this.uploadCancellation) {
                this.uploadCancellation.cancel('Upload cancelled by user');
            }
            this.video = null;
            this.errorMessage = null;
            this.videoSaved = false;
            this.savingVideo = false;
            this.cancelButtonText = 'Zurück';
        }
    }
}
</script>

<style scoped>
.upload-form {
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    background: #f7f7f7;
    border-radius: 8px;
}
.video-error-message {
    color: red;
    font-size: 1.2em;
}
.form-group span {
    margin-left: 10px;
    font-weight: bold;
}
.vld-overlay {
    align-items: center;
    justify-content: center;
}
.vld-icon {
    font-size: 2rem;
}
.vld-background {
    opacity: 0.8;
}


.overlay-message {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, 50%);
    z-index: 9999;
    color: #000;
}

.loading-container {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.loading-overlay {
    /* Adjust the size if necessary */
    width: 100px;
    height: 100px;
}

.loading-message {
    /* Adjust the margins if necessary */
    margin-top: 20px;
}

</style>
