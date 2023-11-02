<template>
    <div class="container">
        <input v-model="newNote.title" placeholder="Note Title">
        <textarea v-model="newNote.content" placeholder="Note Content"></textarea>
        <button @click="addNote">Add Note</button>

        <div id="notesAccordion" class="accordion">
            <!-- Loop over topics -->
            <div v-for="topic in topics" :key="topic.id" class="accordion-item">
                <h2 class="accordion-header" :id="'heading' + topic.id">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapse' + topic.id" aria-expanded="false" :aria-controls="'collapse' + topic.id">
                        <!-- Display the topic name -->
                        {{ topic.name }}
                    </button>
                </h2>
                <div :id="'collapse' + topic.id" class="accordion-collapse collapse" :aria-labelledby="'heading' + topic.id" data-bs-parent="#notesAccordion">
                    <div class="accordion-body">
                        <!-- Loop over notes in this topic -->
                        <div v-for="note in topic.notes" :key="note.id">
                            <p>{{ note.title }}: {{ note.content }}</p>
                            <button @click="editNote(note)">Edit</button>
                            <button @click="deleteNote(note.id)">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from "axios";

export default {
    name: 'Start',
    data() {
        return {
            topics: [],
            newNote: {
                title: '',
                content: ''
            }
        }
    },
    created() {
        this.fetchTopics();
    },
    methods: {
        fetchTopics() {
            axios.get('/api/topics') // Adjust this to your API endpoint
                .then(response => {
                    this.topics = response.data;
                })
                .catch(error => {
                    console.error("Error fetching topics:", error);
                });
        },
        addNote() {
            axios.post('/notes', this.newNote)
                .then(() => {
                    this.fetchTopics(); // Refresh topics after adding a note
                    this.newNote.title = '';
                    this.newNote.content = '';
                });
        },
        editNote(note) {
            // Implementation for editing a note
        },
        deleteNote(id) {
            axios.delete(`/notes/${id}`)
                .then(() => {
                    this.fetchTopics(); // Refresh topics after deleting a note
                });
        }
    }
}
</script>
