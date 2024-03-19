<!-- BugCommentsModal.vue -->
<template>
 <div class="modal" v-show="isVisible" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Bug Details & Comments</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div>
              <h6>{{ bug.title }}</h6>
              <!-- Display other bug details here -->
            </div>
            <hr>
            <h6>Previous Comments</h6>
            <ul>
              <li v-for="comment in comments" :key="comment.id">
                <strong>{{ comment.user }}</strong> - {{ comment.date }}<br>
                {{ comment.content }}
              </li>
            </ul>
            <hr>
            <h6>Add New Comment</h6>
            <!-- Implement form for adding new comments here -->
          </div>
        </div>
      </div>
      
    </div>
  </template>
  
  <script>
  export default {
   
    props: {
        bug:{
            typeof: Object
        },
        comments:{
            typeof: Array
        },
        isVisible: {
            type: Boolean,
            default: false
        },

    },
    methods: {
      addComment() {
        // Implement logic to add a new comment for the selected bug
        // Example: You may need to send a POST request to your server
        // Once the comment is added successfully, emit an event or update the comments array
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add custom styles for the modal if needed */
  </style>
  