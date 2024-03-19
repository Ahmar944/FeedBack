<template>
  <div>
    <div id="mySidebar" class="sidebar">
      <ul class="menu-list">
        <li class="menu-item">
          <router-link  to="/" class="menu-link">
            <div class="item-icon">
              <img src="../../assets/images/home.png" alt="" />
            </div>
            <div class="item-name">FeedBack</div>
          </router-link>
        </li>
        <!-- <li class="menu-item">
          <router-link  to="/profile" class="menu-link">
            <div class="item-icon">
              <img src="../../assets/images/pen.png" alt="" />
            </div>
            <div class="item-name">Profile</div>
          </router-link>
        </li> -->
        <li class="menu-item">
          <router-link to="/feedback" class="menu-link">
            <div class="item-icon">
              <img src="../../assets/images/file.png" alt="" />
            </div>
            <div class="item-name">Give FeedBack</div>
          </router-link>
        </li>       
      </ul>
      <div class="closebtn" @click="closeNav()">
        <img src="../../assets/images/Collapse.png" alt="" />
      </div>
      <div id="main" @click="openNav()">
        <img src="../../assets/images/Collapse.png" alt="" />
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "LeftMenu",
  computed: {
    ...mapGetters("auth", ["user"]),
  },
  data() {
    return {
      User:false
    };
  },
  methods: {
   
    openNav: function () {
      var x = window.matchMedia("(min-width: 769px)");

      if (x.matches) {
        document.getElementById("mySidebar").setAttribute("style", "width:180px");
        document.getElementById("main").setAttribute("style", "display:none");
        document.querySelector(".closebtn").setAttribute("style", "display:block");
        // document
        //   .querySelector(".registry-wrapper")
        //   .setAttribute("style", "width:calc(100vw - 180px)");
        // document
        //   .querySelector(".home-wrapper")
        //   .setAttribute("style", "width:calc(100vw - 180px)");
      }

      var y = window.matchMedia("(max-width: 768px)");

      if (y.matches) {
        document.getElementById("mySidebar").setAttribute("style", "width:50px");
        document.getElementById("main").setAttribute("style", "display:none");
        document.querySelector(".closebtn").setAttribute("style", "display:block");
        document
          .querySelector(".registry-wrapper")
          .setAttribute("style", "width : calc(100vw - 50px)");
        document
          .querySelector(".home-wrapper")
          .setAttribute("style", "width : calc(100vw - 50px)");
      }
    },

    closeNav: function () {
      document.getElementById("mySidebar").setAttribute("style", "width:0");
      document.getElementById("main").setAttribute("style", "display:block");
      document.querySelector(".closebtn").setAttribute("style", "display:none");
      // document.querySelector(".registry-wrapper").setAttribute("style", "width:100vw");
      // document.querySelector(".home-registry-wrapper").setAttribute("style", "width:100vw");
    },
  },
  mounted() {
    console.log(this.user);
    // if(this.user.user.role_id === 1){
    // this.isAdmin=true
    // }
  //  if (localStorage.getItem("permissions") == 2) {
  //       this.User= true;
  //   }
  },
};
</script>

<style scoped>
.usertab {
  height: 17px;
  width: 20px
}
</style>
