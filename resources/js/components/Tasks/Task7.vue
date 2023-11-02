<template>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center pb-3">
                <span class="message-text">{{ message }}</span> <!-- Display the message here -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h1>{{ title }}</h1> <!-- Display the title here -->
                <p v-html="content"></p>
            </div>

        </div>

    </div>
</template>

<script>
import axios from 'axios';
import RecordRTC from 'recordrtc';

export default {
    name: "Task1",
    data() {
        return {
            title: '',
            content: ''
        }
    },
    methods: {
        goBack() {
            this.$router.go(-1);
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
        startRecording() {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    this.recorder = RecordRTC(stream, { type: 'video' });
                    this.recorder.startRecording();
                })
                .catch(err => console.error('Could not start video: ', err));
        },
        stopRecording() {
            this.recorder.stopRecording(() => {
                let blob = this.recorder.getBlob();
                // You can download the file or send it to a server here
            });
        }

    },

    mounted() {

        axios.get('/task/content/377')
            .then(response => {
                this.title = response.data.title; // Assign title from the response
                this.content = response.data.intro; // Assign content from the response
            })
            .catch(error => {
                console.error(error);
            });

        axios.get('/task/get-all-task', {
            params: {
                task: 3,
            }
        })
            .then(response => {
                this.count = response.data.count;
                console.log(this.count);
            })
            .catch(error => {
                console.error(error);
            });
    },

}
</script>

<style scoped>
.message-text {
    color: green;
}
</style>
