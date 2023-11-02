<template>
    <div>
        <div class="container">
            <div class="row justify-content-center bg-white pb-5">
                <div class="col-12">
                    <p dir="ltr" style="text-align: left;"><br><strong>Bitte laut in der Gruppe vorlesen:</strong></p>

                    <p>
                        Liebe Schüler*innen,<br>
                        herzlich willkommen zum Videoprojekt!
                    </p>

                    <p dir="ltr" style="text-align: left;"><br><strong>Was ist das Videoprojekt?</strong></p>

                    <p>Ihr werdet zum Filmteam und sendet Videos und Fotos der Klassenfahrt über diese App an uns, damit wir gemeinsam Eure Erlebnisse festhalten und einen einzigartigen Erinnerungsfilm Eurer Klassenfahrt erstellen können. </p>

                    <p><strong>Eure Team-Aufgabe während der Klassenfahrt:</strong> Uns täglich mindestens ein Erinnerungsvideo schicken, welches besondere Momente einfängt.</p>

                    <p><strong>Einen Stadtteil erkunden:</strong> Außerdem werden Eure Lehrkräfte mit Euch einen Stadtteil auswählen. Eure Mission:  Diesen in Eurem Team zu erkunden, dabei in die Rolle von Vlogger*innen zu schlüpfen und einen eigenen Video-Beitrag über den Stadtteil zu erstellen.</p>

                    <p><strong>Eure Belohnung:</strong> Wir produzieren aus den Ergebnissen aller Gruppen einen einmaligen Film. Umso mehr ihr mitmacht, umso lustiger wird das Ergebnis. Ihr und die anderen Film-Teams Eurer Klasse leisten also jeweils einen eigenen und sehr wichtigen Beitrag für das Videoprojekt und den Erinnerungsfilm. Viel Spaß dabei!</p>

                    <p><strong>Hinweis:</strong> Zeigt Euch gern auf den Fotos und Videos. Natürlich nur, wer darf und wer will. Fremde dürfen nicht ungefragt eine Hauptrolle im Film bekommen.</p>

                    <button type="button" @click="goToOverview" class="btn btn-primary  same-height-btn" style="width: 100%">Weiter</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Einleitung",
    data() {
        return {
            user: null,
        }
    },
    methods: {

        goToOverview() {

            axios.post('/user/status/save', {
                value: 1
            })
            .then(response => {
                this.$router.push('app/overview');
            })
            .catch(error => {
                // Handle errors here
                console.error(error);
            });

        }
    },
    created() {
        // Fetch the user data first
        axios.post('/user/get')
            .then(response => {
                this.user = response.data;
            })
            .catch(error => {
                console.error(error);
            })
    },


}
</script>

<style scoped>

</style>
