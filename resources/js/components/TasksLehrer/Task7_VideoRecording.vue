<template>
    <div class="container">
        <!--
         <div class="row">
             <div class="col-12 text-center pb-3">
                 <span class="message-text">{{ message }}</span>
             </div>
         </div>
         -->
        <div class="row bg-white">
            <div class="col-12 text-center">
                <div v-if="errorMessage" class="video-error-message">
                    {{ errorMessage }}
                </div>
            </div>
        </div>
        <div class="row justify-content-center pt-5  bg-white" v-if="videoSaved">
            <div class="col-md-8 text-center">
                <i class="fas fa-check-circle fa-5x my-4" style="color: green;"></i>
                <h4 class="message-text">{{ message }}</h4>
                <div class="row mt-4 justify-content-center">
                    <div class="col-md-8 pb-2" v-if="!maxVideosReached">
                        <button @click="resetRecording" class="btn btn-primary btn-block"  style="width: 100%;">
                            Noch ein Video aufnehmen
                        </button>
                    </div>
                </div>
                <div class="row mt-2 justify-content-center">
                    <div class="col-md-8 pb-2">
                        <button @click="goBack" class="btn btn-secondary btn-block"  style="width: 100%;">
                            Zurück zur Aufgabe
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div v-else class="row justify-content-center bg-white">

            <div class="col-md-8">

                <div class="row pb-2" v-if="showStartStopSwitch">
                    <div class="col-12 pb-3" style="text-align: right;">
                        <button @click="switchCamera" class="btn btn-secondary" :disabled="recording" style="font-size: 13px;">
                            <i class="fas fa-sync-alt"></i>
                            Kamera wechseln
                        </button>
                    </div>
                </div>

                <div class="video-wrapper" style="position:relative; background-color: #fff;">

                    <div class="counter" style="position: absolute; top: 27px; left: 1px; font-size: 2px; color: white; min-width: 200px;">
                        <span v-if="recording" style="font-size: 25px!important; top: 0; left: 23%;">{{ countdown }} Sek</span>
                    </div>

                    <span v-if="!recording && startDelay > 0" style="font-size: 14px">Mach dich bereit. <br> Videoaufnahme startet in</span>
                    <span v-if="!recording && startDelay > 0" style="font-size: 25px; font-weight: bold"><br><br><br>{{ startDelay }}</span>

                    <!-- Show the live video feed when recording or preparing to record -->
                    <video ref="video" v-show="cameraReady || recording || startDelay > 0" width="320" height="240" autoplay playsinline style="border-radius: 15px;"></video>

                    <!-- Show the recorded video when not recording -->
                    <video ref="playbackVideo" v-show="showSaveAndReplay" width="320" height="240" controls playsinline :src="videoUrl" style="border-radius: 15px;"></video>
                    <i class="fas fa-video placeholder-icon" v-show="!showSaveAndReplay && !(cameraReady || recording || startDelay > 0)"></i>
                </div>

                <div class="row pt-3" v-if="showStartStopSwitch">
                    <div class="col-6 text-center">
                        <button @click="startRecording" class="btn btn-primary" :disabled="recording"  style="font-size: 13px;">
                            Aufnahme starten
                        </button>
                    </div>
                    <div class="col-6 text-center">
                        <button @click="stopRecording" class="btn btn-secondary" :disabled="!recording"  style="font-size: 13px;">
                            Aufname stoppen
                        </button>
                    </div>
                </div>

                <div class="row pb-3 pt-3" >

                    <div v-if="showSaveAndReplay && !savingVideoInProgress" class="col-6 text-center">
                        <button @click="playVideo" class="btn btn-success" style="width: 100%;">
                            Abspielen
                        </button>
                    </div>

                    <div v-if="showSaveAndReplay" class="col-6 text-center">
                        <button @click="saveVideo" class="btn btn-primary" style="width: 100%;">
                            <span v-if="!savingVideo"> Speichern</span>
                            <div class="spinner-border spinner-border-sm text-light spinner-spacing" role="status" v-if="savingVideo">
                                <span class="sr-only">Speichere...</span>
                            </div>
                        </button>
                    </div>

                </div>

                <div class="row pb-3" v-if="showSaveAndReplay && !savingVideoInProgress">
                    <div class="col-6 text-center">
                        <button @click="resetRecording" class="btn btn-secondary"  style="width: 100%;">
                            Nochmal
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="overlay" v-if="loading">
        <div class="spinner"></div>
        Datei wird hochgeladen...
    </div>
</template>

<script>
import axios from 'axios';
import RecordRTC from 'recordrtc';

export default {
    name: "Task2_VideoRecording",
    data() {
        return {
            teamname: '',
            message: '',
            recorder: null,
            stream: null,
            useFrontCamera: false,
            recording: false,
            countdown: 15,
            startDelay: 0,
            videoUrl: '',
            videoSaved: false,
            showSaveAndReplay: false,
            showStartStopSwitch: true,
            blob: null,
            errorMessage: '',
            savingVideo: false,
            maxVideosReached: false,
            savingVideoInProgress: false,
            cameraReady: false,
            loading: false,
        }
    },
    methods: {
        toggleRecording() {
            if (this.recording) {
                this.stopRecording();
            } else {
                this.startRecording();
            }
        },
        goBack() {
            // Check if the video was recorded but not saved yet
            if (this.blob && !this.videoSaved) {
                if (window.confirm('Du hast dein Video noch nicht gespeichert. Bist du sicher, dass du zurückkehren möchtest?')) {
                    this.$router.go(-1);
                }
            } else {
                this.$router.go(-1);
            }
        },
        submitForm() {
            axios.post('/task/save', {
                teamname: this.teamname,
                value: 1
            })
                .then(response => {
                    this.message = 'Erfolgreich gespeichert';
                    console.log(response);
                })
                .catch(error => {
                    // Handle errors here
                    console.error(error);
                });
        },
        switchCamera() {
            // Toggle the camera
            this.useFrontCamera = !this.useFrontCamera;

            // Stop the current stream tracks
            if (this.stream) {
                this.stream.getTracks().forEach(track => track.stop());
            }

            // Restart the camera but don't start recording
            this.initCamera();
        },

        initCamera() {
            let constraints = {
                video: {
                    facingMode: this.useFrontCamera ? "user" : "environment",
                    width: { min: 1280 },
                    height: { min: 720 },
                }
            };

            navigator.mediaDevices.getUserMedia(constraints)
                .then(stream => {
                    this.stream = stream;

                    // Get the video element directly from the DOM
                    let video = document.querySelector('video');

                    // Set the stream as the source of the video element
                    video.srcObject = stream;

                    this.cameraReady = true;
                })
                .catch(err => {
                    console.error('Could not start video: ', err);
                    this.recording = false;
                });
        },

        startRecording() {
            clearInterval(this.timer);
            this.startDelay = 5;
            this.countdown = 15;
            let delayTimer = setInterval(() => {
                this.startDelay--;
                if (this.startDelay <= 0) {
                    clearInterval(delayTimer);
                    this.startDelay = 0;

                    // Start the actual recording
                    this.recording = true;
                    let constraints = {
                        video: {
                            facingMode: this.useFrontCamera ? "user" : "environment",
                            width: { min: 1280 },
                            height: { min: 720 },
                        }
                    };

                    navigator.mediaDevices.getUserMedia(constraints)
                        .then(stream => {
                            this.stream = stream; // store the stream in Vue instance

                            // Set the stream as the source of the video element
                            this.$refs.video.srcObject = stream;

                            this.recorder = RecordRTC(stream, { type: 'video' });
                            this.recorder.startRecording();
                            this.startCountdown();
                        })
                        .catch(err => {
                            console.error('Could not start video: ', err);

                            // If there was an error starting the video,
                            // set recording to false to enable the button
                            this.recording = false;
                        });
                }
            }, 1000);
        },
        stopRecording() {
            this.recorder.stopRecording(() => {
                // Stop the tracks in the stream
                this.stream.getAudioTracks().forEach(track => track.stop());
                this.stream.getVideoTracks().forEach(track => track.stop());

                // Revoke the video source
                this.$refs.video.srcObject = null;

                // Set the blob and create local URL for the video
                this.blob = this.recorder.getBlob();
                this.videoUrl = URL.createObjectURL(this.blob);

                this.recording = false;
                this.showStartStopSwitch = false;
                this.showSaveAndReplay = true;

            });
            clearInterval(this.timer);
            this.countdown = 15;
        },
        playVideo() {
            if (this.$refs.playbackVideo) {
                this.$refs.playbackVideo.play();
            }
        },
        saveVideo() {
            // Save the video here
            this.loading = true;
            this.savingVideo = true;
            this.savingVideoInProgress = true;
            this.message = '';

            let file = new File([this.blob], 'recordedVideo.webm', {
                type: 'video/webm'
            });

            let formData = new FormData();
            formData.append('video', file);
            formData.append('task_number', 70);
            formData.append('type', 'video-recorded');

            axios.post('task/save-video', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    if (response.data.status === 'success') {
                        this.$router.go(-1);
                    } else {
                        this.errorMessage = 'Error saving video: ' + response.data.message;
                    }
                })
                .catch(err => {
                    this.errorMessage = 'Could not save video: ' + err;
                })
                .finally(() => {
                    this.savingVideo = false;
                    this.savingVideoInProgress = false;
                });
        },


        resetRecording() {
            // Clear the blob and videoUrl
            this.blob = null;
            this.videoUrl = '';

            // Show the original set of buttons
            this.showStartStopSwitch = true;
            this.showSaveAndReplay = false;
            this.videoSaved = false;
        },
        startCountdown() {
            this.timer = setInterval(() => {
                this.countdown--;
                if (this.countdown <= 0) {
                    clearInterval(this.timer);
                    this.stopRecording();
                }
            }, 1000);
        },
    },
    mounted() {
        this.initCamera();
    },
}
</script>
<style scoped>
.message-text {
    color: green;
}
button:disabled {
    opacity: 0.4;
}

.video-wrapper {
    position: relative;
    width: 100%;
    padding-top: 75%; /* For 4:3 aspect ratio, adjust as needed */
    background-color: #333e43;
    display: flex; /* new */
    justify-content: center; /* new */
    align-items: center; /* new */
    flex-direction: column; /* new */
}

.video-wrapper video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 1; /* new */
}

.placeholder-icon, .video-wrapper span {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff; /* adjust as needed */
    font-size: 2rem; /* adjust as needed */
    text-align: center; /* new */
    z-index: 2; /* new */
}

.video-error-message {
    font-weight: 700;
    color: red;
}

.spinner-spacing {
    margin-left: 5px;
}
</style>
