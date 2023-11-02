<template>
    <div>
        <div class="row">
            <div class="col-md-12 text-center">
                <img :src="image" style="max-width: 90%;">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center pt-3">
                <button @click="showModal(image.id)" class="btn btn-danger">Löschen</button>
            </div>
        </div>
        <Task2_DelteModal v-if="showModalFlag" @close-modal="showModalFlag = false" @delete-file="deleteFile"/>

    </div>
</template>

<script>
import axios from "axios";
import Task2_DelteModal from "./Task2_DeleteModal.vue";

export default {
    name: "Task2_ViewImage",
    components: {
        Task2_DelteModal
    },
    data() {
        return {
            image: '',
            showModalFlag: false,
        }
    },
    methods: {
        showModal(id) {
            this.showModalFlag = true;
        },
        deleteFile() {
            console.log("here");
            const fileName = this.image.split('/').pop();
            axios.delete(`/task/delete-image/${encodeURIComponent(fileName)}`)
                .then(() => {
                    this.showModalFlag = false;
                    this.$router.push({ name: 'task2' });
                })
                .catch(error => {
                    console.error(error);
                });
        }
    },
    mounted() {
        axios.get('/task/get-one-task', {
            params: {
                task: 2,
            }
        })
            .then(response => {
                this.image = response.data.teamname;
            })
            .catch(error => {
                console.error(error);
            });
    }
}
</script>

<style scoped>

</style>
