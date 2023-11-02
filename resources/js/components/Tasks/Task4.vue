<template>
    <div class="container">
        <div class="row bg-white">
            <div class="col-12 text-center pb-3">
                <span class="message-text">{{ message }}</span> <!-- Display the message here -->
            </div>
        </div>
        <div   v-if="!loading" class="row bg-white">
            <div class="col-12">
                <p v-html="content"></p>
            </div>

        </div>
        <div v-if="!audioURL && !loading" class="row bg-white">
            <div class="col-6 text-center pb-3">
                <button @click="startRecording" :disabled="isRecording" class="btn btn-primary" style="font-size: 14px;">Aufnahme starten</button>
            </div>
            <div class="col-6 text-center pb-3">
                <button @click="stopRecording" :disabled="!isRecording" class="btn btn-primary"  style="font-size: 14px;">Aufnahme stoppen</button>
            </div>
        </div>
        <div class="row bg-white">
            <div class="col-12 text-center pb-3">
                <div v-if="isRecording" class="recording-indicator">
                    <span class="dot"></span> Aufnahme läuft...
                </div>
                <div  v-if="isRecording" style="font-size: 25px!important;">
                    <br>{{ recordingDuration }} Sekunden
                </div>
            </div>
        </div>


        <div class="row bg-white pt-3 pb-3">
            <div class="col-12 text-center pb-3">
                <audio ref="audioRef" v-if="audioURL" controls preload="metadata" :src="'/uploads' + audioURL"></audio>



            </div>
        </div>

        <div class="row bg-white pt-3 pb-3">
            <div class="col-12 text-center pb-3">
                <button v-if="audioURL && showSaveButton && justRecorded" class="btn btn-primary mr-10px" @click="hideSaveButton">Speichern</button>
                <button v-if="audioURL" class="btn btn-danger" @click="showModal">Löschen</button>
            </div>
        </div>



    </div>
    <Task4_DelteModal v-if="showModalFlag" @close-modal="showModalFlag = false" @delete-file="deleteFile"/>
    <div v-if="loading" class="overlay">
        <div class="spinner"></div>
    </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import Task4_DelteModal from "./Task4_DeleteModal.vue";
import { useRouter } from 'vue-router';

export default {
    name: 'AudioRecorder',
    components: {
        Task4_DelteModal
    },

    setup() {
        const router = useRouter();

        // Refs
        const title = ref('');
        const content = ref('');
        const loading = ref(true);
        const showModalFlag = ref(false);
        const recordingDuration = ref(60);
        const recordingInterval = ref(null);
        const isRecording = ref(false);
        const taskNumber = ref(4);
        const audioPath = ref(null);
        const showSaveButton = ref(true);
        const justRecorded = ref(false);
        const audioDuration = ref(null); // New ref for audio duration

        let mediaRecorder;
        let audioChunks = [];

        const audioURL = computed(() => {
            return audioPath.value ? `/${audioPath.value}` : null;
        });

        const hideSaveButton = () => {
            showSaveButton.value = false;
            justRecorded.value = false;
        };

        const goBack = () => {
            router.go(-1);
        };

        const showModal = () => {
            showModalFlag.value = true;
        };

        const handleMetadataLoaded = function() {
            audioDuration.value = this.duration;
        };

        const startRecording = async () => {
            audioChunks = [];

            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);

                mediaRecorder.ondataavailable = event => {
                    audioChunks.push(event.data);
                };

                mediaRecorder.onstop = async () => {
                    showSaveButton.value = true;
                    justRecorded.value = true;
                    const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                    const formData = new FormData();
                    formData.append('file', audioBlob);
                    formData.append("task_number", taskNumber.value);

                    try {
                        const response = await axios.post('task/save-file', formData);
                        audioPath.value = response.data.path;
                    } catch (error) {
                        console.error("Failed to send audio:", error);
                    }

                    clearInterval(recordingInterval.value);
                };

                mediaRecorder.onerror = (error) => {
                    console.error("Error during recording:", error);
                };

                mediaRecorder.start();
                isRecording.value = true;

                recordingInterval.value = setInterval(() => {
                    recordingDuration.value--;
                    if (recordingDuration.value <= 0) {
                        stopRecording();
                    }
                }, 1000);

            } catch (error) {
                console.error("Error initializing recording:", error);
            }
        };

        const stopRecording = () => {
            if (mediaRecorder && mediaRecorder.state === 'recording') {
                mediaRecorder.stop();
                mediaRecorder.stream.getTracks().forEach(track => track.stop());
            }
            isRecording.value = false;
            clearInterval(recordingInterval.value);
            recordingDuration.value = 60;
        };

        const deleteFile = () => {
            if (!audioURL.value) {
                console.warn("No audio URL available");
                return;
            }

            const fileName = audioURL.value.split('/').pop();

            axios.delete(`/task/delete-audio/${encodeURIComponent(fileName)}`)
                .then(() => {
                    showModalFlag.value = false;
                    recordingDuration.value = 0;
                    audioPath.value = null;
                    window.location.reload();
                })
                .catch(error => {
                    console.error(error);
                });
        };

        onMounted(async () => {
            try {
                const contentResponse = await axios.get('/task/content/4');
                title.value = contentResponse.data.title;
                content.value = contentResponse.data.intro;

                const taskResponse = await axios.get('/task/get-one-task', {
                    params: {
                        task: 4,
                    }
                });
                audioPath.value = taskResponse.data.teamname;
                loading.value = false;

                if (audioPath.value) {
                    // Add event listener for the 'loadedmetadata' event
                    this.$refs.audioRef.addEventListener('loadedmetadata', handleMetadataLoaded);
                    this.$refs.audioRef.load();
                }

            } catch (error) {
                console.error(error);
            }
        });

        return {
            title,
            content,
            loading,
            showModalFlag,
            recordingDuration,
            recordingInterval,
            isRecording,
            audioURL,
            audioPath,
            startRecording,
            stopRecording,
            goBack,
            showModal,
            deleteFile,
            showSaveButton,
            hideSaveButton,
            justRecorded,
            audioDuration  // expose the audioDuration ref
        };
    }
};
</script>

