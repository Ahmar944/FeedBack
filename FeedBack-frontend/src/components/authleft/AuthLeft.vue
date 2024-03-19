<template>
  <div class="auth-page-left">
    <div class="content">
      <div class="logo">
        <h1 class="text-white">FeedBack</h1>
      </div>
      <div class="text">
        <p>{{ paragraph }}</p>
        <p>{{ member }}</p>
        <router-link to="/register" class="btn" v-if="showRoute == 1">
          {{ button1 }}
        </router-link>
        <router-link to="/login" class="btn" v-if="showRoute == 2">
          {{ button2 }}
        </router-link>
        <router-link to="/login" class="btn" v-if="showRoute == 3">
          {{ button3 }}
        </router-link>
        <button class="bg-white rounded px-3 py-1" v-if="btn">
          {{ button }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AuthLeft",
  data: function() {
    return {
      showRoute: "",
      btn: "",
    };
  },
  props: ["paragraph", "member", "button1", "button2", "button3", "button"],
  mounted() {
    var linkUrl = window.location.pathname;
    var segment_array = linkUrl.split("/");
    var lastSegment = segment_array.pop();
    if (lastSegment == "login") {
      this.showRoute = 1;
    } else if (lastSegment == "register"  || lastSegment == "") {
      this.showRoute = 2;
    } else if (lastSegment == "verification-email") {
      this.showRoute = 3;
    } else if (
      lastSegment == "forgot-password" ||
      lastSegment == "verify-email" ||
      lastSegment == "new-password"
    ) {
      this.showRoute = 1;
    } else if (lastSegment == "password-update") {
      this.btn.style.display = "none";
    }
  },
};
</script>

<style></style>
