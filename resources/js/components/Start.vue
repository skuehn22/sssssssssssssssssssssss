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
            <input v-model="newTopic.title" placeholder="List Title" class="form-control me-2">
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
                        <!-- Display the formatted date here -->
                        <div v-if="topic.date" class="topic-date pb-3">
                            <strong>Date: {{ formatDate(topic.date) }}</strong>
                        </div>


                        <div v-if="activeTopic.id === 21 && averageNote !== null">
                            <p><strong>Average Rate: {{ averageNote.toFixed(2) }}</strong></p>
                        </div>

                        <div v-for="note in topic.notes" :key="note.id" class="mb-2 note-and-icons">
                            <div v-if="editingNoteId === note.id" class="d-flex align-items-center w-100">
                                <input v-model="editingContent" class="form-control form-control-sm me-2" style="flex-grow: 1;">
                                <i class="fas fa-save text-success me-2" style="cursor:pointer;" @click="updateNote(note.id)"></i>
                                <i class="fas fa-times text-secondary" style="cursor:pointer;" @click="cancelEdit()"></i>
                            </div>
                            <div v-else class="d-flex align-items-center w-100">
                                <p class="mb-0 note-content flex-grow-1">{{ topic.id === 20 ? '- ' + note.content : note.content }}</p>
                                <!-- ...icons... -->
                                <span class="icon-container"> <!-- Updated class -->
            <i class="fas fa-edit text-primary me-2" style="cursor:pointer;" @click="editNote(note)"></i>
            <i class="fas fa-trash text-danger" style="cursor:pointer;" @click="deleteNote(note.id)"></i>
        </span>
                            </div>
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
            activeTopic: {
                id: null,
                name: '',
            },
            averageNote: null,
            notes: [],
            editingNoteId: null,
            editingContent: '',
            activeDropdownTopicId: null,

        }
    },
    created() {
        this.fetchTopics();
    },
    methods: {
        formatDate(dateString) {
            const event = new Date(dateString);
            const day = event.getDate().toString().padStart(2, '0');
            const month = (event.getMonth() + 1).toString().padStart(2, '0'); // +1 because months are 0-indexed
            const year = event.getFullYear();

            return `${day}.${month}.${year}`;
        },
        editNote(note) {
            this.editingNoteId = note.id;
            this.editingContent = note.content;
        },

        updateNote(noteId) {
            if (!this.editingContent.trim()) {
                alert("Please enter a note content.");
                return;
            }

            axios.put(`/notes/${noteId}`, { content: this.editingContent })
                .then(() => {
                    this.fetchTopics(); // Refresh topics after updating a note
                    this.editingNoteId = null; // Reset the editing note id
                    this.editingContent = ''; // Reset the editing note content
                })
                .catch(error => {
                    console.error("Error updating note:", error);
                    alert("Failed to update note. Please try again.");
                });
        },
        cancelEdit() {
            this.editingNoteId = null;
            this.editingContent = '';
        },
        calculateAverageNote() {
            if (this.activeTopic.id === 21) {
                let sum = 0;
                let count = 0;

                // Ensure that we are accessing notes from the active topic
                for (const note of this.activeTopic.notes) {
                    const noteValue = parseFloat(note.content); // Assuming 'content' holds the note text
                    if (!isNaN(noteValue) && note.content.toString().match(/^\d+\.\d+$/)) {
                        console.log(noteValue);
                        sum += noteValue;
                        count++;
                    }
                }

                console.log(sum);

                if (count > 0) {
                    this.averageNote = sum / count;
                } else {
                    this.averageNote = null; // Set to null if no notes match the criteria
                }
            }
        },

        fetchTopics() {
            axios.get('/api/topics')
                .then(response => {
                    this.topics = response.data;
                    // Initialize newNote object for each topic
                    this.topics.forEach(topic => {
                        this.newNote[topic.id] = { title: '', content: '' };
                    });
                    // Update activeTopic if it has been fetched again
                    if (this.activeTopic && this.activeTopic.id) {
                        const active = this.topics.find(t => t.id === this.activeTopic.id);
                        if (active) {
                            this.setActiveTopic(active);
                        }
                    }
                })
                .catch(error => {
                    console.error("Error fetching topics:", error);
                });
        },

        toggleAccordion(topicId) {
            this.openAccordionId = this.openAccordionId === topicId ? null : topicId;
            if (this.openAccordionId) {
                this.setActiveTopic(this.topics.find(topic => topic.id === topicId));
            } else {
                this.activeTopic = { id: null, name: '' }; // Reset activeTopic when accordion is closed
            }
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
            let noteContent = this.newNote[topicId].content.trim();

            // Format the note content for topic 21 to ensure one decimal place
            if (topicId === 21) {
                // Parse the note content as a float and check if it's an integer
                const noteValue = parseFloat(noteContent);
                if (!isNaN(noteValue) && parseInt(noteValue, 10) === noteValue) {
                    // If it's an integer, format to one decimal place
                    noteContent = `${noteValue.toFixed(1)}`;
                }
            }

            if (!noteContent) {
                alert("Please enter a note content.");
                return;
            }

            axios.post('/store/notes', { content: noteContent, topic_id: topicId })
                .then(() => {
                    this.fetchTopics(); // Refresh topics after adding a note
                    this.newNote[topicId].content = ''; // Reset the note content for this topic
                    if (topicId === 21) {
                        this.calculateAverageNote(); // Recalculate the average if the note was added to topic 21
                    }
                })
                .catch(error => {
                    console.error("Error adding note:", error);
                    alert("Failed to add note. Please try again.");
                });
        },


        deleteNote(id) {
            axios.delete(`/notes/${id}`)
                .then(() => {
                    this.fetchTopics(); // Refresh topics after deleting a note
                });
            this.calculateAverageNote();
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
            this.calculateAverageNote();
        },

    },
    watch: {
        // Watcher for the activeTopic.id or notes array if they can change
        'activeTopic.id': function (newVal, oldVal) {
            // Call calculateAverageNote whenever the active topic ID changes
            this.calculateAverageNote();
        },
        notes: {
            handler() {
                // Call calculateAverageNote whenever the notes array changes
                this.calculateAverageNote();
            },
            deep: true,
        },
    },
    mounted() {
        // Call calculateAverageNote on component mount
        this.calculateAverageNote();
    },
    computed: {
        isTopicActiveAndOpen() {
            // This should return true only if there is an active topic and the accordion for that topic is open.
            return this.activeTopic.id !== null && this.openAccordionId === this.activeTopic.id;
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

.note-content {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-right: auto; /* Push the icons to the right */
}

.icon-container {
    white-space: nowrap; /* Ensure icons do not wrap */
}

/* This will ensure the note text and icons are aligned in a single line */
.note-and-icons {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Additional scoped styling if necessary */


/* Additional scoped styling if necessary */
</style>
