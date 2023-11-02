<template>
    <div class="container">
        <div class="row bg-white">
            <div class="col-12 text-center pb-3">
                <span class="message-text">{{ message }}</span> <!-- Display the message here -->
            </div>
        </div>
        <div class="row bg-white">
            <div class="col-12">
                <p v-html="content"></p>
            </div>

        </div>
        <div class="row"  v-if="uploadSuccess">
            <div class="col-md-12 text-center">

                <video width="320" height="240" controls>
                    <source :src="video" type="video/mp4">
                </video>

            </div>
        </div>
        <div class="row pb-3" v-if="uploadSuccess">
            <div class="col-md-12 text-center pt-3">
                <button @click="showModal(id)" class="btn btn-danger">Löschen</button>
            </div>
        </div>
        <div v-if="!loading" class="row pb-5 pt-3 bg-white ">
            <div class="col-12 text-center">
                <button type="button" class="btn btn-primary" style="font-size: 13px;" @click="goToUpload(taskNumber)" v-if="count < 1">Video hochladen</button>
            </div>
        </div>
        <Task3_DeleteModal v-if="showModalFlag" @close-modal="showModalFlag = false" @delete-file="deleteFile"/>
    </div>
    <div v-if="loading" class="overlay">
        <div class="spinner"></div>
    </div>
</template>

<script>
import axios from 'axios';
import Task3_DeleteModal from "./Task3_DeleteModal.vue";

export default {
    name: "Task1",
    components: {
        Task3_DeleteModal
    },
    data() {
        return {
            title: '',
            content: '',
            count: 0,
            video: '',
            id: '',
            uploadSuccess: false,
            showModalFlag: false,
            loading: true,
            taskNumber: 30
        }
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        goToRecord() {
            this.$router.push('/lehrer-task3-recording');
        },
        goToUpload(taskNumber) {
            this.$router.push({
                path: `/task-upload/${taskNumber}`,
                query: { maxVideoDuration: 62, format: 'quer', types: 'video/*', wording: 'Video', amount: 1 }
            });
        },
        showModal(id) {
            this.showModalFlag = true;
        },
        deleteFile() {
            console.log("here");

            axios.delete(`/task/delete-video/`+this.id)
                .then(() => {
                    this.showModalFlag = false;
                    window.location.reload();
                    //this.$router.push({ name: 'task2' });
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
    mounted() {

        axios.get('/task/content/30')
            .then(response => {
                this.loading = false;
                this.title = response.data.title; // Assign title from the response
                this.content = response.data.intro; // Assign content from the response
            })
            .catch(error => {
                console.error(error);
            });

        axios.get('/task/get-one-task', {
            params: {
                task: 30,
            }
        })
            .then(response => {
                this.video = response.data.teamname;
                this.id = response.data.id;
                if (this.video) {
                    this.count = 1;
                    this.uploadSuccess = true;
                }
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
