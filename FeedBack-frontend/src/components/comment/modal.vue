<template>
    <div>
      <input
        class="d-none"
        data-target="#BoxViewScoresModal"
        data-toggle="modal"
        ref="openBoxViewScoresModal"
      />
      <div
        class="modal fade"
        id="BoxViewScoresModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Feedback Details </h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
                ref="closeKeepScoresModal"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body pb-0">
              <!-- Start -->
              <div class="row border-bottom pb-3">
                <div class="col-6 d-flex align-items-center">
                  <h6>User Name: </h6>
                  <p class="ml-2">{{ feedback.user_name }}</p>
                </div>
                <div class="col-6 d-flex align-items-center">
                  <h6>User Email: </h6>
                  <p class="ml-2">{{ feedback.user_email }}</p>
                </div>
                <div class="col-6 d-flex align-items-center">
                  <h6>Tilte: </h6>
                  <p class="ml-2">{{ feedback.title }}</p>
                </div>
                <div class="col-6 d-flex align-items-center">
                  <h6>Description: </h6>
                  <p class="ml-2">{{ feedback.description }}</p>
                </div>
                <div class="col-6 d-flex align-items-center">
                  <h6>Created at: </h6>
                  <p class="ml-2">{{ feedback.created_at | moment("MMM D, YYYY") }}</p>
                </div>
                <div class="col-6 d-flex align-items-center">
                  <h6>Category: </h6>
                  <button v-if="feedback.category == 1" class="ml-2 active">Feature</button>
                  <button v-else-if="feedback.category == 2" class="ml-2 terminated">Error</button>
                  <button v-else-if="feedback.category == 3" class="ml-2 notSigned">Improvement</button>
                </div>
              </div>
  
              <div v-if="showLoader == 0">
                <div class="row height d-flex justify-content-center align-items-center">
                  <div class="w-100">
                    <div class="card">
                      <div class="p-3">
                        <h6>Comments</h6>
                        <small>Total Comments {{ count }}</small>

                      </div>
                      <div class="mt-3 d-flex flex-row align-items-center p-3 form-color">
                        <img src="https://i.imgur.com/zQZSWrt.jpg" width="50" class="rounded-circle mr-2">
                        <input type="text" class="form-control" placeholder="Enter your comment..." v-model="commentInput">
                        <button class="btn btn-primary ml-2" @click="postComments(feedback)" :disabled="commentInput.trim() === ''">Submit</button>                      </div>
                      <div v-for="(comment, index) in comments" :key="index" class="mt-2">
                        <div class="d-flex flex-row p-3">
                          <img src="https://i.imgur.com/zQZSWrt.jpg" width="40" height="40" class="rounded-circle mr-3">
                          <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                              <div class="d-flex flex-row align-items-center">
                                <span class="mr-2">{{ comment.user.name}}</span>
                                <small class="c-badge">Top Comment</small>
                              </div>
                              <small>{{ comment.created_at | moment("MMM D, YYYY") }}</small>
                            </div>
                            <p class="text-justify comment-text mb-0">{{ comment.content }}</p>
                            <!-- <div class="d-flex flex-row user-feed">
                              <span class="wish"><i class="fa fa-heartbeat mr-2"></i>24</span>
                              <span class="ml-3"><i class="fa fa-comments-o mr-2"></i>Reply</span>
                            </div> -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row d-flex justify-content-center align-items-center  my-5" v-else>
                <div class=" lds-dual-ring"></div>
              </div>
              <!-- End -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
import axios from "axios";

  export default {
    name: "inningModal",

    components: {
    },
    data: function() {
      return {
        commentInput: '',
        feedback: [],
        feedback_id: "",
        pageSize: "10",
        page: 10,
        pager: {},
        perPage: 3,
        comments: {},
        showLoader: 1,
        count: 0, 
        user_id: "", 

      };
    },
    methods: {
    getComments(feedback_id) {
    this.showLoader = 1;
    axios
      .get(
        `${process.env.VUE_APP_API_URL}/feedback-comments?feedback_id=${feedback_id}
        &perPage=${this.page ? this.page : ""}
        &size=${this.pageSize ? this.pageSize : ""}`,
        {} 
      )
      .then((response) => {
        if (response.data.statusCode == 200) {
          this.comments = response.data.data.data;
          this.count = response.data.data.total;
          console.log(this.comments )
          this.showLoader = 0;
        } else {
          // Handle error response
          this.errorMessage = response.data.message;
          this.showLoader = 0;
        }
      })
      .catch((error) => {
        // Handle axios request error
        this.errorMessage = error.message;
        this.showLoader = 0;
      });
},
    postComments(feedback) {
        const formData = new FormData();
         formData.append("feedback_id", feedback.id);
         formData.append("user_id", this.user_id);
         formData.append("content", this.commentInput);
    axios
      .post(process.env.VUE_APP_API_URL + "/feedback-comments", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
      .then((response) => {
        if (response.data.statusCode == 200) {
            this.getComments(feedback.id)
            this.commentInput = '';
        } else {
          // Handle error response
          this.errorMessage = response.data.message;
        }
      })
      .catch((error) => {
        // Handle axios request error
        this.errorMessage = error.message;
      });
}
     
    },
    mounted() {
        const userId = localStorage.getItem("user_id")
        this.user_id = userId.toString();
        
        this.$root.$on("openBoxViewScoresModal", (registry) => {
        this.feedback = [];
        this.feedback = registry;
        this.feedback_id = registry.id;
        var elem = this.$refs.openBoxViewScoresModal;
        if (elem) {
          elem.click();
        }
        this.getComments(this.feedback_id)
      });
    },
  };
  </script>
  
  <style scoped>
  .modal-dialog {
    max-width: 60%!important;
    margin: 1.75rem auto;
}
  
  .notSigned {
    padding: 4px 10px;
    background: rgba(252, 100, 15, 0.54);
    color: var(--not-signed);
    font-family: var(--outfit);
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0.01em;
    border-radius: 24px;
    }
    .terminated {
    padding: 4px 10px;
    background: rgba(245, 34, 45, 0.19);
    color: #f5222d;
    font-family: var(--outfit);
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0.01em;
    border-radius: 24px;
    }
    .active {
    padding: 4px 10px;
    background: #F9FC78;
    color: #B7AB0E;
    font-family: var(--outfit);
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0.01em;
    border-radius: 24px;
    }
    .lds-dual-ring:after {
    content: " ";
    display: block;
    width: 40px;
    height: 40px;
    margin: 1px;
    margin-left: 14px;
    border-radius: 50%;
    border: 3px solid #07546b;
    border-color: #07546b transparent #07546b transparent;
    animation: lds-dual-ring 1.2s linear infinite;
}
.card{
	width: 100%;
	background-color: #fff;
	border: none;
}

.form-color{
  
   background-color: #fafafa;

}

.form-control{

	height: 48px;
	border-radius: 25px;
}

.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #35b69f;
    outline: 0;
    box-shadow: none;
    text-indent: 10px;
}

.c-badge{
	background-color: #35b69f;
    color: white;
    height: 20px;
    font-size: 11px;
    width: 92px;
    border-radius: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 2px;
}

.comment-text{
	font-size: 13px;
}

.wish{

	color:#35b69f;
}


.user-feed{

	    font-size: 14px;
	    margin-top: 12px;
}

  </style>
  