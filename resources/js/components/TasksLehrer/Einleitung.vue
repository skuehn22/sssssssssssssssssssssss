<template>
    <div>
        <div class="container">
            <div class="row justify-content-center bg-white pb-5">
                <div class="col-12">
                                       <p>
                        Liebe Lehrkräfte, <br>
                        herzlich willkommen zum Videoprojekt!
                    </p>

                    <p dir="ltr" style="text-align: left;"><strong>Was ist das Videoprojekt?</strong></p>

                    <p>Ihre Klasse gestaltet – von Ihnen in 3 bis 5 Filmteams aufgeteilt – einen einzigartigen Erinnerungsfilm der Klassenfahrt. Dabei hat <strong>jedes Filmteam</strong> folgende Aufgaben: </p>

                    <ol>
                        <li>Jeden Tag mindestens einen Videoclip hochladen, der einen besonderen Moment des Tages festhält.</li>
                        <li>Ergänzende einmalige Beiträge erstellen, die den Film abrunden (Teamname, Gruppenfoto, Resümee der Klassenfahrt als Audio u.ä.)</li>
                        <li>Unter Ihrer Leitung einen von 3 Stadtteilen auszuwählen und über den Stadtteil einen Videobeitrag zu verfassen. Ihre Schüler*innen erkunden den Stadtteil mit Hilfe unserer App eigenständig.</li>
                    </ol>

                    <p><strong>Sie sind die Filmleitung!</strong></p>
                    <p>Im Prinzip ist das Videoprojekt für Ihre Schüler*innen dank unserer App selbsterklärend.
                        Wichtig ist aber, dass Sie regelmäßig in die Auswertungen schauen, ob Ihre Schüler*innen in den Filmteams auch an den Aufgaben arbeiten. Das Ziel ist, dass alle Filmteams möglichst alle Aufgaben erfüllen.
                    </p>

                    <p>Bei der Aufgabe <strong>Erinnerungsvideos</strong> ist Ihre Mitarbeit besonders gefragt. Bei dieser sollen die Filmteams jeden Tag ein konkretes Ereignis der Klassenfahrt hochladen. </p>

                    <p><strong>Ihr Beitrag als Lehrkraft zum Erinnerungsfilm</strong></p>

                    <p>Es wäre toll, wenn auch Sie (idealer Weise gemeinsam mit den anderen Begleitpersonen Ihrer Klasse) die Aufgaben lösen und selbst Teil des Films werden. Ihre Aufgaben unterscheiden sich von den Aufgaben Ihrer Schüler*innen.</p>


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
                    this.$router.push('app/overview-lehrer');
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
