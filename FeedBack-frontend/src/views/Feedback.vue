<template>
    <div class="app-page">
      <Navbar />
      <div class="main-wrapper">
        <LeftMenu />
        <div class="registry-wrapper p-0  overflow-hidden">
            <h3 class="p-2">Submit Feedback or Bug Report</h3>
            <div >
                <Feedback/>
            </div>
        </div>
      </div>
    </div>
  </template>
  <script>
  import axios from "axios";
  import { mapGetters, mapActions } from "vuex";
  import LeftMenu from "../components/leftmenu/LeftMenu.vue";
  import Navbar from "../components/header/Navbar.vue";
  import Feedback from "../components/feedback/feedback.vue";
  
  export default {
    name: "FeedBack",
  
    components: {
      Navbar,
      LeftMenu,
      Feedback
      
    },
  
    data: function() {
      return {
        showLoader: 0,
      };
    },
  
    computed: {
      ...mapGetters("auth", ["user"]),
    },
  
    methods: {
      ...mapActions("auth", ["sendVerifyResendRequest"]),
     
      getDataRegistry() {
        this.showLoader = 1;
        axios
          .get(
            `${process.env.VUE_APP_API_URL}/feedbacks?page=${this.page}&size=${this.pageSize ? this.pageSize : ""}`,
            {}
          )
          .then((response) => {
            if (response.data.statusCode == 200) {
              this.registry = response.data.data.data;
              this.pager = response.data.data;
              this.count = response.data.data.total;
              this.showLoader = 0;
            } else {
              this.errorMessage = response.data.message;
              this.showLoader = 0;
            }
          });
      }
    },
    
    mounted() {
      this.getDataRegistry();
      this.$root.$on("filtersCallForRegistry", (data) => {
        this.filter = data;
        if (data.pageSize) {
          this.pageSize = data.pageSize.text;
        }
        // this.getDataRegistry();
      });
      // this.$root.$on("filtersForRegistry", (data) => {
      // this.filter = data;
      
      // this.getDataRegistry();
    // });
    },
  };
  </script>