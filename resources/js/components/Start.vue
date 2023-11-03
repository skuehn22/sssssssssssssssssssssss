<template>
    <div class="container my-4" style="margin-top: 0;">
        <div class="row">
            <div class="col-12 text-end" v-if="isTopicActiveAndOpen"> <!-- This will align the content to the right -->
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top: -27px;
    font-size: 8px;
}">
                        <i class="fas fa-bars"></i> <!-- Burger icon -->
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item" href="#" @click="deleteTopic(activeTopic.id); $event.preventDefault();">
                                Delete "{{ activeTopic.name }}"
                            </a>
                        </li>
                        <!-- ... other menu items ... -->
                    </ul>
                </div>
            </div>
        </div>


        <div class="d-flex justify-content-between mb-3">
            <input v-model="newTopic.title" placeholder="Topic Title" class="form-control me-2">
            <button @click="addTopic" class="btn btn-primary">Add</button>
        </div>

        <div id="notesAccordion" class="accordion">
            <!-- Loop over topics -->
            <div v-for="topic in topics" :key="topic.id" class="accordion-item">
                <h2 class="accordion-header d-flex justify-content-between align-items-center" :id="'heading' + topic.id">
                    <button class="accordion-button" type="button"
                            @click="toggleAccordion(topic.id); setActiveTopic(topic)"
                            :class="{ 'collapsed': openAccordionId !== topic.id }"
                            :aria-expanded="openAccordionId === topic.id ? 'true' : 'false'"
                            :aria-controls="'collapse' + topic.id">
                        {{ topic.name }}
                    </button>
                </h2>
                <div :id="'collapse' + topic.id" class="accordion-collapse"
                     :class="{ 'collapse': openAccordionId !== topic.id, 'show': openAccordionId === topic.id }"
                     :aria-labelledby="'heading' + topic.id">
                    <div class="accordion-body">
                        <!-- Add Note Input Field -->
                        <div class="input-group mb-3">
                            <input v-model="newNote[topic.id].content" placeholder="New note" class="form-control">
                            <button class="btn btn-outline-secondary" type="button" @click="addNote(topic.id)">Add</button>
                        </div>
                        <!-- Loop over notes in this topic -->
                        <div v-for="note in topic.notes" :key="note.id" class="mb-2 d-flex align-items-center justify-content-between">
                            <p class="mb-0">{{ note.content }}</p>
                            <i class="fas fa-trash text-danger" style="cursor:pointer;" @click="deleteNote(note.id)"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>




<script>
import axios from "axios";
import 'bootstrap/dist/js/bootstrap.bundle';

export default {
    name: 'Start',
    data() {
        return {
            topics: [],
            newTopic: {
                title: '',
                content: ''
            },
            newNote: {},
            currentTopicId: null, // Keep track of the current topic for adding a note
            newNoteContent: '', // New note content
            showModal: false,
            openAccordionId: null,
            activeTopic: null,
        }
    },
    created() {
        this.fetchTopics();
    },
    methods: {
        fetchTopics() {
            axios.get('/api/topics')
                .then(response => {
                    this.topics = response.data;
                    // Initialize newNote object for each topic
                    this.topics.forEach(topic => {
                        this.newNote[topic.id] = { title: '', content: '' };
                    });
                })
                .catch(error => {
                    console.error("Error fetching topics:", error);
                });
        },
        toggleAccordion(topicId) {
            // If the current topicId is the same as the openAccordionId, set it to null to close the accordion
            // Otherwise, set the openAccordionId to the current topicId to open the accordion
            this.openAccordionId = this.openAccordionId === topicId ? null : topicId;
        },
        addTopic() {
            // Check if the newTopic has a title
            if (!this.newTopic.title.trim()) {
                alert("Please enter a topic title.");
                return;
            }

            axios.post('/api/store/topics', { name: this.newTopic.title })
                .then(() => {
                    this.fetchTopics(); // Refresh topics after adding a new topic
                    this.newTopic.title = ''; // Reset the newTopic title
                })
                .catch(error => {
                    console.error("Error adding topic:", error);
                    alert("Failed to add topic. Please try again.");
                });
        },

        openAddNoteModal(topicId) {
            this.currentTopicId = topicId; // Set the current topic ID
            this.newNoteContent = ''; // Reset the note content
            this.showModal = true; // Show the modal
        },

        closeModal() {
            this.showModal = false; // Hide the modal
        },

        addNote(topicId) {
            const noteContent = this.newNote[topicId].content.trim();
            if (!noteContent) {
                alert("Please enter a note content.");
                return;
            }
            axios.post('/store/notes', { content: noteContent, topic_id: topicId })
                .then(() => {
                    this.fetchTopics(); // Refresh topics after adding a note
                    this.newNote[topicId].content = ''; // Reset the note content for this topic
                })
                .catch(error => {
                    console.error("Error adding note:", error);
                    alert("Failed to add note. Please try again.");
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
        },
        deleteTopic(id) {
            if (confirm("Are you sure you want to delete this topic?")) {
                axios.delete(`/api/topics/${id}`)
                    .then(() => {
                        this.fetchTopics(); // Refresh topics after deleting
                    })
                    .catch(error => {
                        console.error("Error deleting topic:", error);
                    });
            }
        },
        setActiveTopic(topic) {
            this.activeTopic = topic;
        },
    },
    watch: {
        showModal(value) {
            if (value) {
                this.$nextTick(() => {
                    document.body.classList.add('modal-open');
                    document.getElementById('addNoteModal').style.display = 'block';
                    document.getElementById('addNoteModal').classList.add('show');
                });
            } else {
                document.body.classList.remove('modal-open');
                if (document.getElementById('addNoteModal')) {
                    document.getElementById('addNoteModal').style.display = 'none';
                    document.getElementById('addNoteModal').classList.remove('show');
                }
            }
        }
    },
    computed: {
        isTopicActiveAndOpen() {
            return this.activeTopic && this.openAccordionId === this.activeTopic.id;
        }
    },

}
</script>
<style scoped>
.icon-container i {
    font-size: 1rem; /* Adjust the size as needed */
    margin-right: 8px; /* Spacing between icons */
    cursor: pointer;
}
.dropdown-menu {
    right: 0; /* Align to the right */
    left: auto; /* Remove the default left alignment */
}

/* Additional scoped styling if necessary */
</style>
