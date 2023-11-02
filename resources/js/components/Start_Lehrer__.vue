<template>
    <div>
        <div class="container">
            <div class="row justify-content-center bg-white">
                <div class="col-md-8 text-center">
                    <span style="font-weight: 700; font-size: 26px;">Moin, Servus und Hallo 2</span> <br>{{ teamName }}
                </div>
            </div>
            <div class="row pt-1">
                <div class="col-12 text-center pt-3"  @click="goToEinleitung">
                    <div class="card mb-3" style="box-shadow: none!important;  background-color: #fff; border: 1px solid #fff;border-radius: 20px;">
                        <div class="card-body task1" @click="" style="padding-left: 0; padding-right: 0;">
                            <div class="card-header d-flex flex-column justify-content-center align-items-center text-center" style="background-color: transparent; font-weight: 700; padding:0;">
                                <p>Einleitung</p>
                                <img src="/images/WebApp-Wegweiser-Icon.png" style="width: 65px">
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row" @click="goToOverview">
                <div class="col-12 text-center pt-1">
                    <div class="card mb-3" style="box-shadow: none!important; background-color: #009bd5; color: #fff;border-radius: 20px;">
                        <div class="card-body task1" @click="">
                            <div class="card-header d-flex flex-column justify-content-center align-items-center" style="background-color: transparent; font-weight: 700;">
                                <p style="font-size: 36px;">Aufgaben</p>
                                <p><button style="color: #fff; background-color: #009bd5; border-radius: 6px; border: 1px solid #fff; padding:5px;">Bearbeiten</button></p>
                                <img src="/images/Uebersichtsbild-Smartphone-Aufgaben.png" style="width: 165px">
                            </div>
                        </div>
                    </div> </div>
            </div>
        </div>

    </div>
</template>

<script>
import axios from "axios";

export default {
    name: 'Start_Lehrer',
    data() {
        return {
            user: null, // You can get your user data here from an API or other source
            teamName: null // Initialize teamName as null
        }
    },
    created() {
        axios.get('/task/get-one-task', {
            params: {
                task: 1
            }
        })
            .then(response => {
                this.teamName = response.data.teamname; // Update the variable name to teamName
            })
            .catch(error => {
                console.error(error);
            });
    },
    methods: {
        goToOverview() {
            this.$router.push('app/overview');
        },
        goToDrehorte() {
            this.$router.push('app/drehorte');
        },
        goToEinleitung() {
            this.$router.push('app/einleitung');
        }


    },

}
</script>
