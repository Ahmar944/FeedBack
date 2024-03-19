<template>
  <div class="top-nav">
    <div class="brand">
      <h4 class="">FeedBack</h4>
      <!-- <img class="navlogo" src="../../assets/images/Logo.png" alt="FeedBack" />    -->
      <!-- <img class="nda d-none" src="../../assets/images/globalnda-dark-yellow.png" alt="GlobalNDA" />    -->
    </div>
    <div class="nav-content">
      <!-- <form class="form-group mb-0">
        <button type="submit" class="search-icon">
          <img src="../../assets/images/search.png" alt="" />
        </button>
        <input
          class="form-control"
          type="search"
          placeholder="Type Here..."
          aria-label="Search"
        />
      </form> -->
      <ul>
        <li class="nav-item">
          <a class="nav-link bell-icon">
            <img src="../../assets/images/bell.png" alt="" />
            <!-- <span class="counter">4</span> -->
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link">
            <!-- <ThemeButton /> -->
          </a>
        </li>
        <li
          class="nav-item"
          @click="openUserMenu"
          v-click-outside="userMenuOutside"
        >
          <a class="nav-link">
            <img src="../../assets/images/user.png" alt="" />
          </a>
        </li>
      </ul>
    </div>

    <div v-if="userMenu" class="menu-options">
      <ul>
        <a href="#" target="_blank" class="menu-link">Help</a>
        <a @click="logout" class="menu-link">Logout</a>
      </ul>
    </div>
  </div>
</template>

<script>
// import ThemeButton from "../Theme/ThemeButton.vue";
import { mapActions } from "vuex";
export default {
  name: "Navbar",
  data() {
    return {
      userMenu: false,
      isAdmin: false,
      isVerfiier: false,
      enterpriseAdmin: false,


    };
  },
  components: {
    // ThemeButton,
  },
  methods: {
    ...mapActions("auth", ["sendLogoutRequest"]),
    openUserMenu() {
      this.userMenu = !this.userMenu;
    },
    logout: function() {
      this.sendLogoutRequest().then((response) => {
        if (response.data.statusCode == 200) {
          if (this.enterpriseAdmin) {
            this.$router.push({ name: "EnterpriseLogin" });
          } else {
            this.$router.push({ name: "Login" });
          }
        } else {
          console.log("error");
        }
      });
    },
    userMenuOutside() {
      this.userMenu = false;
    },
  },
  mounted(){
    if(localStorage.getItem("permissions") == 1){
      this.isAdmin = true;
    }else if(localStorage.getItem("permissions") == 4){
      this.isVerifier = true;
    } else if (localStorage.getItem("permissions") == 5) {
        this.enterpriseAdmin = true;
    }
    else{
      this.isAdmin = false;
      this.isVerifier = false;
    }
  }
};
</script>

<style></style>
