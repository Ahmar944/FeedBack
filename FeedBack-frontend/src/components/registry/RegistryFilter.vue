<template>
  <!-- <div> -->
  <div class="container-fluid filter-content">
    <div class="row no-gutters p-0 px-1 mb-2 justify-content-between">
      <div class="col-12 d-flex ">
        <h5 class="mb-md-1">Welcome {{ user_name }} to FeedBack.vue</h5>
        
      </div>
    </div>
  
    
  </div>
  <!-- </div> -->
</template>

<script>

import { mapGetters } from "vuex";

export default {
  name: "RegistryFilter",
  data: function() {
    return {
      user_name: "",
     
    };
  },
  computed: {
    ...mapGetters("auth", ["user"]),
  },
    methods: {},
  mounted() {

    if (localStorage.getItem("user_name")) {
      this.user_name = localStorage.getItem("user_name")
    } 
  },
};
</script>

<style scoped>
.form-group {
    margin-bottom: 0.5em;
}
.date-pick {
  height: 45px;
  width: 100%;
  border: 1px solid var(--light-gray)!important;
  padding-top: auto;
  border-radius: 0.25rem;
  position: relative;
}
.i {
  height: 20px;
  position: absolute;
  right: 0;
  padding-right: 3px;
}
.custom-select {
  border: 1px solid var(--light-gray)!important;
  border-radius: 0.25rem;
}

/* Custom Css for check inputs start */
/* .dis{
  display: contents!important;
} */
label {
  display: flex; 
  align-items: center; 
  /* color: #9e9e9e; */
  position: relative;
}
input {
  width: 0;
  height: 0;
  opacity: 0;
}
label > span {
  width: 15px;
  height: 15px;
  display: flex;
  justify-content: center;
  border: 2px solid #9e9e9e;
  margin-right: 10px;
  border-radius: 3px;
  transition: all .3s;
  cursor: pointer;
}
input:checked + label > span {
  border: 7px solid #ffee00;
  animation: bounce 250ms;
}
input:checked + label > span::before {
  content: '';
  position: absolute;
  top: 6px;
  left: 4px;
  border-right: 3px solid transparent;
  border-bottom: 3px solid transparent;
  transform: rotate(45deg);
  transform-origin: 0% 100%;
  animation: checked-box 125ms 250ms forwards;
}
@keyframes checked-box {
  0% {
    width: 0;
    height: 0;
    border-color: #212121;
    transform: translate(0,0) rotate(45deg);
  }
  33% {
    width: 4px;
    height: 0;
    border-color: #212121;
    transform: translate(0,0) rotate(45deg);
  }
  100% {
    margin-top: 6px;
    width: 4px;
    height: 8px;
    border-color: #212121;
    transform: translate(0,-8px) rotate(45deg);
  }
}
@keyframes bounce {
  0% {
    transform: scale(1);
  }
  33% {
    transform: scale(.7);
  }
  100% {
    transform: scale(1);
  }
}
/* Custom Css for check inputs end */

</style>
