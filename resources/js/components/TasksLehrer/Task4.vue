<template>
    <div class="container bg-white">
        <div class="row bg-white">
            <div class="col-12">

                <p v-html="content"></p>
            </div>

        </div>
        <div v-if="!loading" class="row bg-white pb-3">
            <div class="col-6" v-if="!uploadSuccess && !isUploading">
                <input id="cameraInput" type="file" accept="image/*" capture="environment" @change="onFileChange" style="display: none;" />
                <button class="btn btn-primary" @click="triggerCamera" style="width: 100%; font-size: 13px;">Foto aufnehmen</button>
            </div>
            <div class="col-6" v-if="!uploadSuccess && !isUploading">
                <input id="fileInput" type="file" accept="image/*" @change="onFileChange" style="display: none;" />
                <button class="btn btn-primary" @click="triggerFileSelect" style="width: 100%;  font-size: 13px;">Foto hochladen</button>
            </div>

        </div>
        <div v-if="!loading && uploadSuccess && !isUploading" class="row bg-white">
            <div class="col-md-12 text-center">
                <div v-if="image" style="border-radius: 12px; border: 5px solid #009bd5; overflow: hidden;">
                    <img :src="'/uploads/' +image" style="max-width: 100%;">
                </div>
                <div v-else>
                </div>
            </div>
        </div>

        <div class="row bg-white" v-if="isPortrait && !isUploading">
            <div class="col-md-12 text-center" ref="portraitMessage">
                <p style="color: red; font-weight: 700">Bitte ein Bild im Querformat hochladen.</p>
            </div>
        </div>



        <div class="row bg-white pb-3" v-if="uploadSuccess">
            <div class="col-md-12 text-center pt-3">
                <button @click="showModal(image.id)" class="btn btn-danger">Löschen</button>
            </div>
        </div>


        <Task4DeleteModal v-if="showModalFlag" @close-modal="showModalFlag = false" @delete-file="deleteFile"/>
        <div class="overlay" v-if="isUploading">
            <div class="spinner"></div>
            Bild wird hochgeladen...
        </div>
    </div>
    <div v-if="loading" class="overlay">
        <div class="spinner"></div>
    </div>
</template>
<script>
import axios from 'axios';
import Task4DeleteModal from "./Task4_DeleteModal.vue";
export default {
    name: "Task4",
    components: {
        Task4DeleteModal
    },
    data() {
        return {
            selectedImage: null,
            message: '',
            title: '',
            content: '',
            uploadSuccess: false,
            image: '',
            showModalFlag: false,
            isUploading: false,
            isPortrait: false,
            loading: true
        }
    },
    methods: {
        goBack() {
            this.$router.go(-1);
        },
        onFileChange(e) {
            const file = e.target.files[0];
            this.selectedImage = file;
            this.uploadImage();
        },
        async uploadImage() {
            this.isPortrait = false;
            const formData = new FormData();
            formData.append('image', this.selectedImage);
            formData.append('task_number', 40); // Change the task number to 40
            this.isUploading = true;

            // Check the aspect ratio of the uploaded image
            const image = new Image();
            image.src = URL.createObjectURL(this.selectedImage);

            image.onload = async () => {
                const aspectRatio = image.width / image.height;
                if (aspectRatio > 1) { // Landscape orientation
                    try {
                        const response = await axios.post('/task/save-image', formData);
                        if (response.data.status === 'success') {
                            this.message = 'Image uploaded successfully';
                            this.uploadSuccess = true;
                            window.location.reload();
                        } else {
                            this.message = 'Error uploading image';
                        }
                    } catch (error) {
                        console.log(error);
                        this.message = 'Error uploading image';
                    } finally {
                        this.isUploading = false;
                    }
                } else { // Portrait orientation
                    this.message = 'Please upload a landscape-oriented image.';
                    this.isCameraActive = false;
                    this.isPortrait = true;
                    this.$nextTick(() => {
                        this.$refs.portraitMessage.scrollIntoView({ behavior: 'smooth' });
                    });
                    this.isUploading = false;
                }
            };
        },

        showModal(id) {
            this.showModalFlag = true;
        },
        deleteFile(taskId) {
            console.log("here");
            const fileName = this.image.split('/').pop();
            axios.delete(`/task/delete-image/${encodeURIComponent(fileName)}`, {
                params: {
                    task: 40
                }
            })
                .then(() => {
                    this.showModalFlag = false;
                    window.location.reload();
                })
                .catch(error => {
                    console.error(error);
                });
        },

        triggerCamera() {
            document.getElementById('cameraInput').click();
        },
        triggerFileSelect() {
            document.getElementById('fileInput').click();
        },
        goToTask2View() {
            this.$router.push('/task2-view');
        },
    },
    mounted() {

        axios.get('/task/content/40') // Change the task number to 40
            .then(response => {
                this.title = response.data.title;
                this.content = response.data.intro;
                this.loading = false;
            })
            .catch(error => {
                console.error(error);
            });

        axios.get('/task/get-one-task', {
            params: {
                task: 40, // Change the task number to 40
            }
        })
            .then(response => {
                this.image = response.data.teamname;
                if (this.image) {
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

.custom-square-check {
    width: 25px;
    height: 25px;
    background-color: #32CD32;
    cursor: pointer;
    display: inline-block;
    border-radius: 6px;
}

</style>

