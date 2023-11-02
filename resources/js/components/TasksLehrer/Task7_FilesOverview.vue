<template>
    <div class="container">
        <div class="row bg-white pt-3" v-for="video in videos" :key="video.id">
            <div class="col-md-6">
                <div v-if="isSafari">
                    <video :id="'video_' + video.id" style="width: 100%; height: auto; border: 2px solid #49aedb; border-radius: 12px;" controls :playsinline="isSafari" preload="auto" poster="/images/poster.png">
                        <source :src="'/uploads/' + video.value" type="video/mp4">
                    </video>
                </div>
                <div v-if="!isSafari">
                    <video :id="'video_' + video.id" style="width: 100%; height: auto; border: 2px solid #49aedb; border-radius: 12px;" controls>
                        <source :src="'/uploads/' + video.value" type="video/mp4">
                    </video>
                </div>

            </div>
            <div class="col-md-6 text-center pt-3">
                <button @click="showModal(video.id)" class="btn btn-danger">Löschen</button>
            </div>
            <hr class="hr-spacing">
        </div>
        <Task7_DelteModal :videoId="currentVideoId" v-if="showModalFlag" @close-modal="showModalFlag = false" @delete-video="deleteVideo"/>
    </div>
</template>

<script>
import axios from 'axios';
import Task7_DelteModal from './Task7_DeleteModal.vue';

export default {
    name: "Task7_VideoOverview",
    components: {
        Task7_DelteModal
    },
    data() {
        return {
            videos: [],
            currentVideoId: null,
            showModalFlag: false,
            isSafari: false, // Initialize a flag for Safari detection
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
        },
    },
    mounted() {
        // Detect if the browser is Safari
        this.isSafari =
            /^((?!chrome|android|crios|fxios).)*safari/i.test(navigator.userAgent) ||
            /^((?!chrome|android|crios|fxios).)*applewebkit/i.test(navigator.userAgent);

        axios.get('/task/get-all-task', {
            params: {
                task: 70,  // Assuming task number 3 is for videos
            }
        })
            .then(response => {
                this.videos = response.data.tasks;
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
</style>
