<template>
    <div class="app-page">
      <Navbar />
      <div class="main-wrapper">
        <LeftMenu />
        <div class="registry-wrapper p-0 bg-transparent overflow-hidden">
          <div class="filter-wrapper">
            <RegistryFilters  />
          </div>
          <div class="home-registry-wrapper">
            <RegistryTop :count="count"/>
            
            <div
              v-if="showLoader == 1"
              class="lds-dual-ring-registry"
              id="loading"
            ></div>
            <div class="tab-content" id="myTabContent">
                <RegistryTable :message="parentMessage"
                  :displayedRegistry="registry"
                  :getDataRegistry="getDataRegistry"
                />
            </div>
            <RegistryBottom :page="pager" :count="count" />    
          </div>
        </div>
      </div>
    </div>
  </template>
  <script>
  import axios from "axios";
  import { mapGetters, mapActions } from "vuex";
  import LeftMenu from "../components/leftmenu/LeftMenu.vue";
  import RegistryTop from "../components/registry/RegistryTop.vue";
  import RegistryTable from "../components/registry/RegistryTable.vue";
  import RegistryBottom from "../components/registry/RegistryBottom.vue";
  import Navbar from "../components/header/Navbar.vue";
  import RegistryFilters from "../components/registry/RegistryFilter.vue";
  
  export default {
    name: "Home",
  
    components: {
      Navbar,
      LeftMenu,
      RegistryTop,
      RegistryTable,
      RegistryBottom,
      RegistryFilters,
    },
  
    data: function() {
      return {
        parentMessage: false,
        errorMessage: null,
        registry: {},
        showLoader: 0,
        page: 1,
        pager: {},
        perPage: 3,
        pages: [],
        success: null,
        error: null,
        count: 0,        
        filter: {},
        pageSize: "10",
      };
    },
  
    computed: {
      ...mapGetters("auth", ["user"]),
    },
  
    methods: {
      ...mapActions("auth", ["sendVerifyResendRequest"]),
      gettingValueChanged(value) {
        this.parentMessage = value
      },
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
    watch: {
      "$route.query.page": {
        immediate: true,
        handler(page) {
          page = parseInt(page) || 1;
          if (page !== this.pager.currentPage || page == this.pager.totalPages + 1) {
            this.showLoader = 1;
            axios
              .get(`${process.env.VUE_APP_API_URL}/feedbacks?page=${
                  page ? page : ""
                }&size=${this.pageSize ? this.pageSize : ""}`,
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
      },
    },
    mounted() {
      this.getDataRegistry();
      this.$root.$on("filtersCallForRegistry", (data) => {
        this.filter = data;
        if (data.pageSize) {
          this.pageSize = data.pageSize.text;
        }
        this.getDataRegistry();
      });
      // this.$root.$on("filtersForRegistry", (data) => {
      // this.filter = data;
      
      // this.getDataRegistry();
    // });
    },
  };
  </script>