<template>
    <div class="container">
        <div class="row bg-white">
            <div class="col-12">
                <p>Hier könnt ihr zusätzliches Material hochladen.</p>
            </div>
        </div>
        <div class="row bg-white">
            <div class="col-md-12 d-flex align-items-center">
                <!-- Loop for green squares -->
                <div v-for="n in count" :key="n" class="custom-square-check" ></div>

                <!-- Loop for red squares -->
                <div v-for="n in (4 - count)" :key="n + 'red'" class="custom-square-red"></div>
                <router-link to="/task-extra-files" class="video-link ml-auto" v-if="count > 0">
                    <i class="fas fa-play-circle"></i>
                    Zu den Bildern / Videos
                </router-link>
            </div>

        </div>
        <div class="row p3-5 bg-white">
            <div class="col-12 text-center">

                <button type="button" class="btn btn-primary" style="margin-left: 5px; " @click="goToUpload" v-if="count < 4">Datei hochladen</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { GoogleMap, Marker, InfoWindow, Polygon  } from "vue3-google-map";
export default {
    name: "Task_Extra",
    components: { GoogleMap, Marker, InfoWindow,Polygon  },
    data() {
        return {
            count: 0,
            title: '',
            content: '',
            task: 8,
        }
    },
    methods: {
        goToRecord() {
            this.$router.push('/task6-recording');
        },
        goToUpload() {
            this.$router.push('/task-extra-upload');
        },
        goBack() {
            this.$router.go(-1);
        },

    },
    mounted() {


        axios.get('/task/content/6')
            .then(response => {
                this.title = response.data.title;
                this.content = response.data.intro;
            })
            .catch(error => {
                console.error(error);
            });

        axios.get('/task/get-all-task', {
            params: {
                task: 8,
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
.progress-container {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.progress-circle {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 6px solid gray;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.progress-circle.small {
    width: 10px;
    height: 10px;
    background: gray;
}

.progress-group {
    display: flex;
    align-items: center;
    flex-grow: 1;
    position: relative; /* Added this line */
}

.progress-text {
    text-align: center;
    width: 100%;
    position: absolute;
    top: -20px;
}

.progress-line {
    flex-grow: 1;
    height: 5px;
    background: gray;
    margin: 0 10px;
}

.progress-circle-green {
    background: green;
    border: 6px solid green;

}

.progress-line-green {
    background: green;
}

.checkmark::after {
    content: "✔";
    color: white;
    position: absolute;
    top: 50%;
    left: 90%;
    transform: translate(-50%, -50%);
}

.progress-text-green{
    color: green;
}


.video-link {
    color: gray;
    font-weight: 600;  /* increase font weight */
    text-decoration: none;  /* remove underline */
}
.video-link i {
    margin-right: 5px;
}
</style>
