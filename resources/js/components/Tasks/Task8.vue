<template>
    <div class="container">
        <div class="row bg-white">
            <div class="col-12 text-center pb-3">
                <span class="message-text">{{ message }}</span> <!-- Display the message here -->
            </div>
        </div>

        <div v-if="message || successMessage" class="row bg-white">
            <div class="col-12 text-center pb-3 pt-3">
                <span style="color: red; " class="message-text">{{ message }}</span> <!-- Display the general message here -->
                <span style="color: green; font-weight: 700;" class="success-message">{{ successMessage }}</span> <!-- Display the success message here -->
            </div>
        </div>

        <div class="row bg-white">
            <div class="col-12">


                <!-- Add radio etc -->
                <div class="question-section">
                    <p>Bewertet das Videoprojekt gemeinsam und anonym:</p>



                    <!-- Radios for Kiez -->
                    <label><strong>Welchen Kiez habt ihr gewählt? (Stadtteilerkundung)</strong></label><br><br>

                    <div class="radio-container">
                        <input type="radio" id="prenzlauerBerg" value="Prenzlauer Berg" v-model="kiez">
                        <label class="radio-label" for="prenzlauerBerg">Prenzlauer Berg</label>
                    </div><br>

                    <div class="radio-container">
                        <input type="radio" id="berlinMitte" value="Berlin Mitte" v-model="kiez">
                        <label class="radio-label" for="berlinMitte">Berlin Mitte</label>
                    </div><br>

                    <div class="radio-container">
                        <input type="radio" id="kreuzberg" value="Kreuzberg" v-model="kiez">
                        <label class="radio-label" for="kreuzberg">Kreuzberg</label>
                    </div><br>

                    <div class="radio-container">
                        <input type="radio" id="otherPlace" value="Other" v-model="kiez">
                        <label class="radio-label" for="otherPlace">Einen anderen Ort</label>
                    </div><br><br>

                    <!-- Radios for Feedback -->
                    <label><strong>Wie hat es Euch gefallen?</strong></label><br><br>

                    <div class="radio-container">
                        <input type="radio" id="top" value="Top" v-model="feedback">
                        <label class="radio-label" for="top">Top!</label>
                    </div><br>

                    <div class="radio-container">
                        <input type="radio" id="fun" value="Hat Spaß gemacht" v-model="feedback">
                        <label class="radio-label" for="fun">Hat Spaß gemacht</label>
                    </div><br>

                    <div class="radio-container">
                        <input type="radio" id="okay" value="Okay" v-model="feedback">
                        <label class="radio-label" for="okay">Okay</label>
                    </div><br>

                    <div class="radio-container">
                        <input type="radio" id="notFun" value="Hat kein Spaß gemacht" v-model="feedback">
                        <label class="radio-label" for="notFun">Hat kein Spaß gemacht</label>
                    </div><br><br>


                    <!-- Feedback Field -->
                    <label><strong>Anmerkung</strong><br>Was hat Euch gefallen und was nicht? Gab es irgendwelche Probleme?</label><br><br>
                    <textarea v-model="feedbackText" rows="4" cols="50" style="width: 100%; border: 2px solid #009bd5; border-radius: 8px;"></textarea><br><br>

                    <!-- Submit Button -->
                    <button class="btn btn-primary same-height-btn" style="width: 100%;" @click="submitFeedback">
                        {{ (feedback || feedbackText) ? 'Feedback überschreiben' : 'Feedback abgeben' }}
                    </button>

                </div>

            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "Task8",
    data() {
        return {
            title: '',
            content: '',
            message: '',
            kiez: '',
            feedback: '',
            feedbackText: '',
            successMessage: ''
        }
    },
    methods: {
        async submitFeedback() {
            try {
                const response = await axios.get('/task/save-task8', {
                    params: {
                        kiez: this.kiez,
                        feedback: this.feedback,
                        feedbackText: this.feedbackText
                    }
                });

                // Check the response status and set the successMessage
                if (response.data.status === 'success') {
                    this.$router.push('/overview');
                    //this.successMessage = 'Das Feedback wurde gespeichert.';
                } else {
                    this.successMessage = 'Es gab ein Problem dein Feedback zu speichern.';
                }
                console.log('Saved response:', response.data);
            } catch (error) {
                console.error('An error occurred while saving data:', error);
            }
        },

        async fetchUserData() {
            try {
                const response = await axios.get('/task/get-user-data');
                if (response.data.status === 'success') {
                    this.kiez = response.data.kiez;
                    this.feedback = response.data.feedback;
                    this.feedbackText = response.data.feedbackText;
                }
            } catch (error) {
                console.error('An error occurred while fetching user data:', error);
            }
        }
    },
    mounted() {
        this.fetchUserData();
    }
}
</script>


<style scoped>
.radio-label {
    display: flex;
    align-items: center;
    gap: 10px;  /* Adjust as needed */
}

.radio-container {
    display: inline-flex;
    align-items: center;
    gap: 10px;
}
</style>
