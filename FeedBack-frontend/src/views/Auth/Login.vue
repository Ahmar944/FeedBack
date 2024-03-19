<template>
  <div class="auth-page">
    <div class="container-fluid p-0">
      <div class="row no-gutters">
        <div class="col-12 col-md-6 d-none d-md-block">
          <AuthLeft :paragraph="para" :member="mem" :button1="btn" />
        </div>
        <div class="col-12 col-md-6">
          <div class="auth-page-right d-flex flex-column justify-content-center">
           
            <div class="auth-page-right-content">
              <div class="heading">
                <h6>Hello Again!</h6>

                <p v-if="errorMessage != null" class="error">
                  {{ errorMessage }}
                </p>
                <p v-else>Welcome Back</p>
              </div>
              <form @keyup.enter="login(0)">
                <div class="form-group">
                  <div class="form-icon">
                    <img src="../../assets/images/email-icon.png" alt="" />
                  </div>
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    placeholder="Business Email"
                    autocomplete="off"
                    v-model.trim="$v.details.email.$model"
                    :class="{
                      'is-invalid': $v.details.email.$error,
                      'is-valid': !$v.details.email.$invalid,
                    }"
                    v-on:keyup="errorNull"
                  />
                  <div class="invalid-tooltip">
                    <span v-if="!$v.details.email.required"
                      >Bussiness email is required</span
                    >
                    <span v-if="!$v.details.email.email"
                      >Bussiness email must be valid
                    </span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-icon">
                    <img src="../../assets/images/password-icon.png" alt="" />
                  </div>
                  <input
                    :type="type"
                    class="form-control"
                    id="password"
                    placeholder="Password"
                    autocomplete="off"
                    v-model.trim="$v.details.password.$model"
                    :class="{
                      'is-invalid': $v.details.password.$error,
                      'is-valid': !$v.details.password.$invalid,
                    }"
                    v-on:keyup="errorNull"
                  />
                  <i
                    v-html="btnText"
                    id="togglePassword"
                    @click="showPassword"
                  ></i>
                  <div class="invalid-tooltip">
                    <span v-if="!$v.details.password.required"
                      >Password is required</span
                    >
                    <span v-if="!$v.details.password.minLength"
                      >Password must have at least
                      {{ $v.details.password.$params.minLength.min }}
                      letters</span
                    >
                    <span v-if="!$v.details.password.maxLength"
                      >Password must have at most
                      {{ $v.details.password.$params.maxLength.max }}
                      letters</span
                    >
                  </div>
                </div>
                <button
                  type="button"
                  class="auth-btn btn-lg btn-secondary w-100 mt-4"
                  @click="login(0)"
                  :disabled="isLoadingArray[0]"
                >
                  <div v-if="isLoadingArray[0]" class="lds-dual-ring"></div>
                  <span v-else>Login</span>
                </button>
              </form>
              
              <div class="account d-md-none">
                <router-link to="/" class="forgot-password">Register</router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import {
  required,
  minLength,
  maxLength,
  email,
} from "vuelidate/lib/validators";
import AuthLeft from "../../components/authleft/AuthLeft.vue";

export default {
  name: "Login",
  components: {
    AuthLeft,
  },

  data: function() {
    return {
      details: {
        email: "",
        password: "",
      },
      type: "password",
      btnText: '<i class="fa fa-eye-slash"></i>',
      errorMessage: null,
      isLoadingArray: [],
      para: "let's Register",
      mem: "Not a member yet?",
      btn: "Register",
    };
  },
  validations: {
    details: {
      email: {
        required,
        email,
      },
      password: {
        required,
        minLength: minLength(8),
        maxLength: maxLength(15),
      },
    },
  },

  computed: {
    ...mapGetters(["errors"]),
  },
  mounted() {
    this.$store.commit("setErrors", {});
  },
  methods: {
    ...mapActions("auth", ["sendLoginRequest"]),
    login: function(index) {
    this.errorMessage = null;
    this.$v.$touch();
    if (this.$v.$pending || this.$v.$error) return;
    this.$set(this.isLoadingArray, index, true);
    this.sendLoginRequest(this.details).then((response) => {
      if (response.data.statusCode === 200) {
        this.$router.push({ name: "Home" });
      } else {
        setTimeout(() => {
          this.$set(this.isLoadingArray, index, false);
          if (response.data.statusCode === 403) {
            this.$set(this.isLoadingArray, index, false);
            this.errorMessage = "Unauthorized access. Please check your credentials.";
          } else if (response.data.message) {
            this.$set(this.isLoadingArray, index, false);
            this.errorMessage = response.data.message;
          } else {
            this.$set(this.isLoadingArray, index, false);
            this.errorMessage = "An error occurred during login.";
          }
        }, 500);
      }
    }).catch((error) => {
      console.error('Error occurred:', error);
      this.errorMessage = "An error occurred during login.";
    });
  },
    showPassword: function() {
      if (this.type === "password") {
        this.type = "text";
        this.btnText = "<i class='fa fa-eye'></i>";
      } else {
        this.type = "password";
        this.btnText = "<i class='fa fa-eye-slash'></i>";
      }
    },
    errorNull: function() {
      this.errorMessage = null;
    },
  },
};
</script>
