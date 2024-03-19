<template>
  <div class="auth-page">
    <div class="container-fluid p-0">
      <div class="row no-gutters">
        <div class="col-12 col-md-6 d-none d-md-block">
          <AuthLeft :paragraph="para" :member="mem" :button2="btn" />
        </div>
        <div class="col-12 col-md-6">
          <div class="auth-page-right d-flex flex-column justify-content-center">
            

            <div class="auth-page-right-content">
              <div class="heading">
                <h6>Hello!</h6>
                <p v-if="errorMessage != null" class="error">
                  {{ errorMessage }}
                </p>
                <p v-else>Sign Up to Get Started</p>
              </div>
              <form @keyup.enter="register(0)">
                <div class="form-group">
                  <div class="form-icon">
                    <img src="../../assets/images/name-icon.png" alt="" />
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="Name"
                    autocomplete="off"
                    v-model.trim="$v.details.name.$model"
                    :class="{
                      'is-invalid': $v.details.name.$error,
                      'is-valid': !$v.details.name.$invalid,
                    }"
                  />
                  <div class="invalid-tooltip">
                    <span v-if="!$v.details.name.required"
                      >Name is required</span
                    >
                    <span v-if="!$v.details.name.minLength"
                      >Name must have at least
                      {{ $v.details.name.$params.minLength.min }}
                      characters</span
                    >
                    <span v-if="!$v.details.name.maxLength"
                      >Name must have at most
                      {{ $v.details.name.$params.maxLength.max }}
                      characters</span
                    >
                  </div>
                </div>
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
                  />
                  <div class="invalid-tooltip">
                    <span v-if="!$v.details.email.required"
                      >Business email is required</span
                    >
                    <span v-if="!$v.details.email.email"
                      >Business email must be valid
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
                  class="auth-btn mt-4"
                  @click="register(0)"
                  :disabled="isLoadingArray[0]"
                >
                  <div v-if="isLoadingArray[0]" class="lds-dual-ring"></div>
                  <span v-else>Register</span>
                </button>
                <!-- Disabled button for recaptcha -->
                <!-- <button
                  type="button"
                  class="dis-auth-btn"
                  title="Button is disabled, to enable first verify reCAPTCHA"
                  >Register</button> -->
              </form>
              <!-- <vue-recaptcha
                class="mt-4 d-flex align-items-center justify-content-center"
                @verify="checkRecaptcha"
                :sitekey="VUE_APP_RECAPTA_KEY"
              ></vue-recaptcha> -->
            </div>

            <div class="account d-md-none">
              <router-link to="/login" class="forgot-password"
                >Sign In</router-link
              >
            </div>

            
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// import { VueRecaptcha } from "vue-recaptcha";
import { mapGetters, mapActions } from "vuex";
import {
  required,
  minLength,
  maxLength,
  email,
} from "vuelidate/lib/validators";
import AuthLeft from "../../components/authleft/AuthLeft.vue";

export default {
  name: "Register",

  components: {
    AuthLeft,
    // VueRecaptcha,
  },

  data: function() {
    return {
      isLoadingArray: [],
      // VUE_APP_RECAPTA_KEY: this.$recaptchaKey,
      details: {
        name: "",
        email: "",
        password: ""
      },
      type: "password",
      btnText: '<i class="fa fa-eye-slash"></i>',
      errorMessage: null,
      para: "Sign up to enjoy the perks!",
      mem: "Already a member?",
      btn: "Sign In",
    };
  },

  validations: {
    details: {
     
      name: {
        required,
        minLength: minLength(3),
        maxLength: maxLength(15),
      },
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
    ...mapActions("auth", ["sendRegisterRequest"]),

    register: function(index) {
      this.$v.$touch();
      if (this.$v.$pending || this.$v.$error) return;
      this.$set(this.isLoadingArray, index, true);
      this.sendRegisterRequest(this.details).then((response) => {
        if (response.data.statusCode === 200) {
          this.$set(this.isLoadingArray, index, false);
          setTimeout(() => {
            this.$router.push({ name: "Login" });
          }, 500);
        } else {
          setTimeout(() => {
            this.$set(this.isLoadingArray, index, false);
            if (response.data.statusCode === 400 && response.data.message) {
              this.errorMessage = response.data.message;
            } else {
              this.$set(this.isLoadingArray, index, false);
              this.errorMessage = "An error occurred during registration.";
            }
          }, 500);
        }
      }).catch((error) => {
        this.$set(this.isLoadingArray, index, false);
        console.error('Error occurred:', error);
        this.errorMessage = "An error occurred during registration.";
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

    // checkRecaptcha: function() {
    //   document.querySelector(".auth-btn").style.display = "block";
    //   document.querySelector(".dis-auth-btn").style.display = "none";
    // },
  },
};
</script>

<style scoped>
/* .auth-btn {
  display: none;
} */
.dis-auth-btn {
  display: none;
}
</style>
