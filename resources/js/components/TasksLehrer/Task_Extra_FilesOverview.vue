<template>
    <div class="bg-white">
        <div class="row" v-for="video in videos" :key="video.id">
            <div class="col-md-6">
                <video v-if="video.type == 'video-recorded'" width="100%" height="auto" controls>
                    <source :src="'/storage/' + video.value" type="video/mp4">
                </video>
                <img v-if="video.type == 'image-uploaded'" :src="'/storage/' + video.value" width="100%" height="auto" alt="Image">
            </div>
            <div class="col-md-6 text-center pt-3">
                <button @click="showModal(video.id)" class="btn btn-danger">Löschen</button>
            </div>
            <hr class="hr-spacing">
        </div>
        <Task_Extra_DelteModal :videoId="currentVideoId" v-if="showModalFlag" @close-modal="showModalFlag = false" @delete-video="deleteVideo"/>
    </div>
</template>

<script>
import axios from 'axios';
import Task_Extra_DelteModal from './Task_Extra_DeleteModal.vue';

export default {
    name: "Task_extra_FilesOverview",
    components: {
        Task_Extra_DelteModal
    },
    data() {
        return {
            videos: [],
            currentVideoId: null,
            showModalFlag: false,
        }
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        showModal(id) {
            this.currentVideoId = id;
            this.showModalFlag = true;
        },
        deleteVideo() {
            axios.delete(`/task/delete-video/${this.currentVideoId}`)
                .then(() => {
                    this.videos = this.videos.filter(video => video.id !== this.currentVideoId);
                    this.showModalFlag = false;

                    // If there are no videos left, go back
                    if (this.videos.length === 0) {
                        this.goBack();
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }
    },
    mounted() {
        axios.get('/task/get-all-task', {
            params: {
                task: 8,  // Assuming task number 2 is for videos
            }
        })
            .then(response => {
                this.videos = response.data.tasks;
                console.log(this.videos);
            })
            .catch(error => {
                console.error(error);
            });
    }
}
</script>

<style scoped>
/* Add your styles here */
.hr-spacing {
    margin-top: 15px;
}

video, img {
    width: 100%;
    height: auto;
}
</style>
