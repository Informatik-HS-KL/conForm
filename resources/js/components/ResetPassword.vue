 <template>
  <div class="container" style="padding-top: 120px !important">
    <div class="row content">

      <!-- left side image -->
      <div class="col-md-6 img-left">
        <img src="../../assets/forgot_password.svg" class="img-fluid" alt="image">
      </div>

      <!-- right side register card -->
      <div class="col-md-6">
         <h3 class="signin-text mb-3">{{ $t("login.reset")}}</h3>
          <p style="font-weight:100">{{ $t("login.code")}}.</p>
            <form method="POST" action="/forgotpassword">
            
              <div class="form-group">
                <label for="email">{{ $t("login.email")}}</label>
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    v-model="user.email"
                    required
                  />
                  <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
              </div>

              <div class="form-group">
                <label for="verficationCode">{{ $t("login.vercode")}}</label>
                  <input
                    type="number"
                    class="form-control"
                    v-model="user.verfication_code"
                    required
                  />
                  <div class="invalid-feedback" v-if="errors.verfication_code">{{errors.verfication_code[0]}}</div>
              </div>

              <div class="form-group">
                <label for="password">{{ $t("login.forgotpw")}}</label>
                  <input
                    id="password"
                    type="password"
                    class="form-control"
                    v-model="user.password"
                    required
                  />
                  <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
              </div>

              <div class="form-group">
                <label for="password_confirmation">{{ $t("login.confirmpw")}}</label>
                  <input
                    id="password_confirm"
                    type="password"
                    class="form-control"
                    v-model="user.password_confirmation"
                    required
                  />
                  <div class="invalid-feedback" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</div>
              </div>

               <!-- forgot password button -->
              <div class="form-group">
                  <button
                    type="submit"
                    class="btn btn-class"
                    @click="resetPassword"
                    ref="btnSubmit"
                  >
                    {{ $t("login.reset")}}
                  </button>
              </div>
            </form>
            <div class="text-center">
              <router-link to="/login" class="d-block small mt-3">{{ $t("login.signin")}}</router-link>
              <router-link to="/reset-password-request" class="d-block small mt-3">{{ $t("login.resend")}}</router-link>
            </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import * as authService from '../services/auth_service.js';
export default {
  name: 'ResetPasswordRequest',
  data() {
    return {
      user: {
        email: "",
        verfication_code: "",
        password: "",
        password_confirmation: ""
      },
      btnOldHtml: '',
      
      errors: {}  
    }
  },
  beforeRouteEnter(to,from,next) {
    next(vm => {
      vm.user.email = to.params.email
    });
  },
  methods: {
    resetPassword: async function() {
      try {
        this.disableSubmission(this.$refs.btnSubmit);
        this.errors = {};
        const response = await authService.resetPassword(this.user);
        this.flashMessage.success({
          message: response.data.message,
          time: 5000
        });
        this.$router.push('/login');
      } catch (error) {
        switch (error.response.status) {
          case 422:
            this.errors = error.response.data.errors;
            break;
          case 401:
            this.errors = error.response.data.errors;
            break;
          default:
            this.flashMessage.error({
              message: 'Oops, etwas ist schiefgelaufen. Versuche es erneut.',
              time: 5000
            });
            break;
        }
        this.enableSubmission(this.$refs.btnSubmit);
      }
    },
    disableSubmission(btn) {
      btn.setAttribute('disabled', 'disabled');
      this.btnOldHtml = btn.innerHTML;
      btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Please wait...'
    },
    enableSubmission(btn) {
      btn.removeAttribute('disabled');
      btn.innerHTML = this.btnOldHtml;
    }
  }
}
</script>

<style lang="scss" scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
body {
  font-family: 'Poppins', sans-serif;
}

.dark {
  .content {
    background-color: #20232a;
  }

  .form-group {
    label {
      color: #fff;
    }
    
      input {
        background-color: #20232a !important;
        color: #f3f3f3 !important;
      }
  }

  .col-md-6 {
    .text-center {
      a {
        color: #f3f3f3;
      }
    }
  }

  .signin-text {
    color: #fff;
  }
}

.content {
  margin: 8%;
  background-color: #fff;
  padding: 4rem 1rem 4rem 1rem;
  box-shadow: 0 0 5px 5px rgba(0,0,0, .05);
  border-radius: 12px;
}
.signin-text {
  font-style: normal;
  font-weight: 600 !important;
}

.form-control {
  display: block;
  width: 100%;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  border-color: #5C55BA !important;
  border-style: solid !important;
  border-width: 0 0 2px 0 !important;
  height: auto;
  color: #495057;
  padding: 0px !important;
  border-radius: 0;
  background-color: #fff;
  background-clip: padding-box;
}

.form-control:focus {
  color: #495957;
  background-color: #fff;
  border-color: #fff;
  outline: 0;
  box-shadow: none;
}

.btn-class {
  border-color: #5C55BA;
  color: #5C55BA;
}

.btn-class:hover {
  background-color: #5C55BA;
}
</style>