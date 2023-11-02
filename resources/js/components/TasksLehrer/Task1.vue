<template>
    <div class="container">

        <div class="row bg-white">
            <div class="col-12">
                <div class="row ">
                    <div class="col-12 text-center pb-3">
                        <span class="message-text">{{ message }}</span> <!-- Display the message here -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <!--<h1>{{ title }}</h1>-->
                        <p v-html="content" style="margin-bottom: 0;"></p>
                    </div>

                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">

                        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent; font-weight: 700;">
                            <span>Tragen Sie hier den Namen ein:</span>
                        </div>

                        <!-- Added form for teamname -->
                        <form @submit.prevent="submitForm">
                            <div class="form-group pt-1 pb-2">
                                <input id="teamname" v-model="teamname" type="text" class="form-control" placeholder="Ihr Teamname" maxlength="25">

                            </div>
                            <div class="d-flex justify-content-center pt-3 pb-3">
                                <br>
                                <button type="submit" class="btn btn-primary" style="width: 100%">Speichern</button>
                            </div>
                            <a v-if="showLateTeamname" @click="goToEinleitung" style="color: #49aedb; font-weight: 600; text-decoration: none" class="pt-3">Teamname später angeben</a>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "Task1",
    data() {
        return {
            teamname: '',
            message: '',
            task: 10,
            title: '',
            content: '',
            showLateTeamname: false,
        }
    },
    methods: {
        goToEinleitung() {
            this.$router.push('/einleitung');
        },
        goBack() {
            this.$router.go(-1);
        },
        submitForm() {
            axios.post('/task/save', {
                teamname: this.teamname,
                value: this.task
            })
                .then(response => {
                    this.message = 'Erfolgreich gespeichert';
                    console.log(response);
                    if (this.$route.params.param === 'new') {
                        this.$router.push('/einleitung');
                    } else {
                        // Go back to the previous page
                        this.$router.go(-1);
                    }
                })
                .catch(error => {
                    // Handle errors here
                    console.error(error);
                });
        },

        goToOverview() {
            this.$router.push('/overview');
        },
        goToTask2() {
            this.$router.push('/task20');
        },
    },
    mounted() { // This hook is called when the Vue instance is created

        axios.get('/task/content/' + this.task)
            .then(response => {
                this.title = response.data.title; // Assign title from the response
                this.content = response.data.intro; // Assign content from the response
            })
            .catch(error => {
                console.error(error);
            });

        axios.get('/task/get-one-task', { // Assuming you have a /task/get endpoint to fetch the data
            params: {
                task: this.task,
                trigger: 'task1'
            }
        })
            .then(response => {
                this.teamname = response.data.teamname; // Assuming the response has a 'value' field with the teamname
            })
            .catch(error => {
                console.error(error);
            });
    },
    created() {
        const param = this.$route.params.param;
        if (param === 'new') {
            this.showLateTeamname = true;
        }
    }

}
</script>

<style scoped>
.message-text {
    color: green;
}

.fa-arrow-right {
    font-size: 14px;
}
</style>
