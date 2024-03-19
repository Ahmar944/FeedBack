<template>
  <div class="container mt-2">
    <form @submit.prevent="submitForm">
      <div class="form-group">
        <label for="user_name">Your Name</label>
        <input type="text" class="form-control" id="user_name" v-model="form.user_name">
      </div>

      <div class="form-group">
        <label for="user_email">Your Email</label>
        <input type="email" class="form-control" id="user_email" v-model="form.user_email">
      </div>

      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" v-model="form.title" required>
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" rows="3" v-model="form.description" required></textarea>
      </div>

      <div class="form-group">
        <label for="category">Category</label>
        <select class="form-control" id="category" v-model="form.category" required>
          <option value="" disabled>Select Category</option>
          <option value="1">Bug Report</option>
          <option value="2">Feature Request</option>
          <option value="3">Improvement</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary" :disabled="!isFormValid">Submit</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      form: {
        user_name: '',
        user_email: '',
        title: '',
        description: '',
        category: ''
      }
    };
  },
  computed: {
    isFormValid() {
      return this.form.title.trim() && this.form.description.trim() && this.form.category;
    }
  },
  methods: {
    submitForm() {
      if (!this.isFormValid) {
        return;
      }
      axios.post(`${process.env.VUE_APP_API_URL}/feedbacks`, this.form)
        .then(response => {
          console.log('Form submitted successfully:', response.data);
          this.resetForm();
          this.$swal({
                icon: 'success',
                title: 'Success',
                text: 'Feedback successfully submitted.'
            });

        })
        .catch(error => {
          console.error('Error submitting form:', error);
          this.$swal({
                icon: 'error',
                title: 'Error',
                text: 'Failed to submit feedback. Please try again later.'
            });
        });
    },
    resetForm() {
      this.form.user_name = '';
      this.form.user_email = '';
      this.form.title = '';
      this.form.description = '';
      this.form.category = '';
    }
  }
};
</script>
