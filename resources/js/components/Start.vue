<template>
    <div class="container">
        <select v-model="selectedTopicId">
            <option value="">Select Topic</option>
            <option v-for="topic in topics" :value="topic.id">{{ topic.name }}</option>
        </select>
        <input v-model="newNote.title" placeholder="Note Title">
        <textarea v-model="newNote.content" placeholder="Note Content"></textarea>
        <button @click="addNote">Add Note</button>

        <div id="notesAccordion">
            <div v-for="(note, index) in notes" :key="note.id">
                <div class="card">
                    <div class="card-header" :id="'heading' + note.id">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapse' + note.id" aria-expanded="true" :aria-controls="'collapse' + note.id">
                                <!-- Display the topic name -->
                                {{ note.topic.name }}: {{ note.title }}
                            </button>
                        </h2>
                    </div>
                    <div :id="'collapse' + note.id" class="collapse" :aria-labelledby="'heading' + note.id" data-parent="#notesAccordion">
                        <div class="card-body">
                            <p>{{ note.content }}</p>
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
            notes: [],
            topics: [], // Add this to store topics
            selectedTopicId: null, // Add this to store the selected topic ID
            newNote: {
                title: '',
                content: ''
            }
        }
    },
    created() {
        this.fetchNotes();
        this.fetchTopics();
    },
    methods: {
        fetchNotes() {
            axios.get('/notes')
                .then(response => {
                    this.notes = response.data;
                });
        },
        addNote() {
            const payload = {
                title: this.newNote.title,
                content: this.newNote.content,
                topic_id: this.selectedTopicId // This should be the ID of the selected topic
            };
            axios.post('/notes', payload)
                .then(() => {
                    this.fetchNotes();
                    this.newNote.title = '';
                    this.newNote.content = '';
                });
        },

        editNote(note) {
            // You can add a modal or another way to edit notes
        },
        deleteNote(id) {
            axios.delete(`/notes/${id}`)
                .then(() => {
                    this.fetchNotes();
                });
        },
        fetchTopics() {
            axios.get('/topics') // Assuming you have a route to get topics
                .then(response => {
                    this.topics = response.data;
                });
        }

    },

}
</script>
