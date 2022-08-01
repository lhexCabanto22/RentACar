<template>
<div id="app">
  <v-app id="inspire">
    <v-app id="inspire">
      <v-main>
        <v-container
          class="fill-height"
          fluid
        >
          <v-row
            align="center"
            justify="center"
          >
            <v-col
              cols="12"
              sm="8"
              md="4"
            >
              <v-card class="elevation-12" :loading="isLoading">
                <v-toolbar
                  color="cyan darken-3"
                  dark
                  flat
                >
                  <v-toolbar-title>Login form</v-toolbar-title>
                  <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                  <v-form>
                    <v-text-field
                      label="Login"
                      name="login"
                      prepend-icon="mdi-account"
                      type="text"
                      v-model="form.email"
                    ></v-text-field>
  
                    <v-text-field
                      id="password"
                      label="Password"
                      name="password"
                      prepend-icon="mdi-lock"
                      type="password"
                      v-model="form.password"
                    ></v-text-field>
                  </v-form>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="cyan darken-3 white--text" @click="login">Login</v-btn>
                </v-card-actions>
              </v-card>
              <v-snackbar
                  v-model="snackbar"
                >
                  {{ text }}
                  <template v-slot:action="{ attrs }">
                    <v-btn
                      color="pink"
                      text
                      v-bind="attrs"
                      @click="snackbar = false"
                    >
                      Close
                    </v-btn>
                  </template>
                </v-snackbar>
            </v-col>
          </v-row>
        </v-container>
      </v-main>
    </v-app>
  </v-app>
</div>
</template>

<script>
export default {
    data() {
      return {
        form: {
          email: '',
          password: '',
        },
        isLoading: false,
        snackbar: false,
        text: {},
      }
    },
    created(){

    },
    methods: {
      login() {
        this.isLoading = 'red'
        axios.post('api/login', this.form).then(response => {
             localStorage.setItem('token', response.data.accessToken)
             if(response.data.admin){
               localStorage.setItem('admin', response.data.admin)
             } else {
              localStorage.setItem('attendant', response.data.attendant)
             }
             this.$router.push('/dashboard')
        }).catch(err=> {
          this.text = err.response.data.error
          this.snackbar = true
        }).finally(() => {
          this.isLoading = false
        })
      }
    },

  
}
</script>