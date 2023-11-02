<template>
    <div class="container bg-white">

        <div class="row" >
            <div class="col-md-12">
                <video id="myVideo" playsinline class="video-js vjs-default-skin">
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, or consider upgrading to a
                        web browser that
                        <a href="https://videojs.com/html5-video-support/" target="_blank">
                            supports HTML5 video.
                        </a>
                    </p>
                </video>
            </div>
        </div>
        <div class="row pt-3" v-if="showStartStopSwitch">
            <div class="col-6 text-center">
                <button @click.prevent="startRecording()" class="btn btn-primary" :disabled="isStartRecording"  style="font-size: 13px;">
                    Aufnahme starten
                </button>
            </div>
            <div class="col-6 text-center">
                <button @click.prevent="stopRecording()" class="btn btn-secondary" :disabled="!isSaveDisabled" style="font-size: 13px;">
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
        <br>
    </div>
</template>

<script>
import 'video.js/dist/video-js.css'
import 'videojs-record/dist/css/videojs.record.css'
import videojs from 'video.js'
import 'webrtc-adapter'
import RecordRTC from 'recordrtc'
import Record from 'videojs-record/dist/videojs.record.js'
import FFmpegjsEngine from 'videojs-record/dist/plugins/videojs.record.ffmpegjs.js';
import axios from "axios";
export default {
    props: ['uploadUrl'],
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
            blob: null,
            errorMessage: '',
            savingVideo: false,
            maxVideosReached: false,
            savingVideoInProgress: false,
            cameraReady: false,
            loading: false,
            showStartStopSwitch: true,
            player: '',
            retake: 0,
            isSaveDisabled: true,
            isStartRecording: false,
            isRetakeDisabled: true,
            submitText: 'Submit',
            options: {
                controls: true,
                bigPlayButton: false,
                controlBar: {
                    deviceButton: false,
                    recordToggle: false,
                    pipToggle: false
                },
                width: 500,
                height: 300,
                fluid: true,
                plugins: {
                    record: {
                        pip: false,
                        audio: true,
                        video: true,
                        maxLength: 10,
                        debug: true
                    }
                }
            }
        }
    },
    mounted() {

        this.player = videojs('myVideo', this.options, () => {
            var msg = 'Using video.js ' + videojs.VERSION +
                ' with videojs-record ' + videojs.getPluginVersion('record') +
                ' and recordrtc ' + RecordRTC.version;
            videojs.log(msg);
        });

        // Initialize the camera to get live feed but don't start recording
        this.player.record().getDevice();
        // error handling
        this.player.on('deviceReady', () => {
            //this.player.record().start();
            console.log('device ready:');
        });
        this.player.on('deviceError', () => {
            console.log('device error:', this.player.deviceErrorCode);
        });
        this.player.on('error', (element, error) => {
            console.error(error);
        });
        // user clicked the record button and started recording
        this.player.on('startRecord', () => {
            console.log('started recording!');
        });
        // user completed recording and stream is available
        this.player.on('finishRecord', () => {
            this.blob = new Blob([this.player.recordedData], { type: 'video/webm' });
            const url = URL.createObjectURL(this.blob);
            this.player.src({ type: 'video/webm', src: url });
            this.player.load();
        });

    },
    methods: {
        resetRecording() {
            // Dispose the current player
            if (this.player) {
                this.player.dispose();
            }

            // Reinitialize the player
           // this.initPlayer();

            // Update the component state to initial settings
            this.isSaveDisabled = true;
            this.showSaveAndReplay = false;
            this.showStartStopSwitch = true;
            this.isStartRecording = false;
        },

        playVideo() {
            // Play the recorded video
            this.player.play();
        },
        stopRecording() {
            this.player.record().stop();
            this.showStartStopSwitch = false;
            this.showSaveAndReplay = true;
        },
        startRecording() {
            this.isStartRecording = true;
            this.player.record().start();
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
            formData.append('task_number', 5);
            formData.append('type', 'video-recorded');

            axios.post('task/save-video', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    if (response.data.status === 'success') {
                        this.videoSaved = true;
                        this.message = 'Video erfolgreich gespeichert!';
                        this.loading = false;
                        // Fetch the tasks
                        axios.get('/task/get-all-task', {
                            params: {
                                task: 5,
                            }
                        })
                            .then(response => {
                                let count = response.data.count;
                                if(count === 3){
                                    this.message += ' Du hast 3 von 3 Videos abgegeben';
                                    this.maxVideosReached = true;
                                }
                                console.log(count);
                            })
                            .catch(error => {
                                console.error(error);
                            });

                        console.log(this.videoUrl);
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

        submitVideo() {
            this.isSaveDisabled = true;
            this.isRetakeDisabled = true;
            var data = this.player.recordedData;
            var formData = new FormData();
            formData.append('video', data, data.name);
            this.submitText = "Uploading "+data.name;
            console.log('uploading recording:', data.name);
            this.player.record().stopDevice();
            fetch(this.uploadUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).then(
                success => {
                    console.log('recording upload complete.');
                    this.submitText = "Upload Complete";
                }
            ).catch(
                error =>{
                    console.error('an upload error occurred!');
                    this.submitText = "Upload Failed";
                }
            );

        },
        retakeVideo() {
            this.isSaveDisabled = true;
            this.isRetakeDisabled = true;
            this.retake += 1;
            this.player.record().start();
        },
    },
    beforeDestroy() {
        if (this.player) {
            this.player.dispose();
        }
    }
}
</script>
