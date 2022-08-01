<template>
 <div id="app">
  <v-app id="inspire">
       <v-navigation-drawer class="cyan darken-3"
      dark
      v-model="drawer" app>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-h4 text-md-center">
              <img src="storage/image/1.png" height="60">
            Rent a Car
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list
        dense
        nav
      >
      <v-list-item-group>
            <v-list-item
          v-for="item in nav"
          :key="item.title"
          :to="item.link"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
      
      </v-list>
    </v-navigation-drawer>
      <v-app-bar
        app
        color="cyan darken-3"
        dark
      >
        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
       <v-spacer></v-spacer>
            <v-menu    bottom left
        offset-y>
              <template v-slot:activator="{ on, attrs }">
              
                <v-icon color="orange" dark v-bind="attrs" v-on="on"  class="white--text ma-4">mdi-bell</v-icon>
              </template>
              <v-list>
                <v-list-item
                  v-for="(item, index) in nav"
                  :key="index"
                >
                  <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>
               
         <v-menu
        bottom
        min-width="200px"
        rounded
        offset-y
      >
        <template v-slot:activator="{ on }">
          <v-btn
            icon
            x-large
            v-on="on"
          >
            <v-avatar
              color="indigo"
              size="48"
            >
              <span class="white--text text-h5"></span>
            </v-avatar>
          </v-btn>
        </template>
        <v-card>
          <v-list-item-content class="justify-center">
            <div class="mx-auto text-center">
              <h3>{{ user.name }}</h3>
              <p class="text-caption mt-1">
                {{ user.email }}
              </p>
              <v-divider class="my-3"></v-divider>
              <v-btn
                depressed
                rounded
                text
                @click="logout"
              >
                Disconnect
              </v-btn>
            </div>
          </v-list-item-content>
        </v-card>
      </v-menu>
      
      </v-app-bar>
      <v-main>
        <v-container fluid >
          <v-row align-items="center" justify="center">
            <v-col class="text-center">
             <router-view></router-view>
            </v-col>
          </v-row>
        </v-container>
      </v-main>
      <v-footer color="cyan darken-3" app>
        <span class="white--text">&copy; Qonvex Bootcamp - Rent A Car Project 2022</span>
      </v-footer>
    </v-app>
</div>
</template>

<script>
  export default {
    data () {
      return {
          admin: [
          { title: 'Dashboard', icon: 'mdi-view-dashboard', link: '/dashboard' },
          { title: 'Car', icon: 'mdi-car' ,link: '/car'},
          { title: 'Brand', icon: 'mdi-watermark' ,link: '/brand'},
          { title: 'Rent', icon: 'mdi-car-key' ,link: '/rent'},
          { title: 'Customer', icon: 'mdi-account-group' ,link: '/customer'},
          { title: 'Office', icon: 'mdi-help-box', link: '/office'},
          { title: 'User', icon: 'mdi-account' ,link: '/user'},
          { title: 'Role', icon: 'mdi-group', link: '/role' },
        ],
        attendant: [
          { title: 'Dashboard', icon: 'mdi-view-dashboard', link: '/dashboard' },
          { title: 'Car', icon: 'mdi-car' ,link: '/car'},
          { title: 'Brand', icon: 'mdi-watermark' ,link: '/brand'},
          { title: 'Rent', icon: 'mdi-car-key' ,link: '/rent'},
          { title: 'Customer', icon: 'mdi-account-group' ,link: '/customer'},
          // { title: 'Office', icon: 'mdi-help-box', link: '/office'},
          // { title: 'User', icon: 'mdi-account' ,link: '/user'},
          // { title: 'Role', icon: 'mdi-group', link: '/role' },
        ],
        nav: null,
        drawer: null,
        token: localStorage.getItem('token'),
        user: {},
        notification: []
      }
    },
    created() {
      this.initialize();
    },
    mounted(){
      this.getNav();
    },
    methods: {
      initialize(){
        axios.get('api/notifications').then(res => {
          this.notification = res.data.notify
        })
       
      },
      getNav()
      { 
        if(localStorage.getItem('admin')){
          this.nav = this.admin
        } else {
          this.nav = this.attendant
        }
      },
      loggedIn(){
        axios.get('api/users').then(res =>{
          this.user = res.data
        })
      },
      logout(){
        localStorage.removeItem('token');
        localStorage.removeItem('admin');
        localStorage.removeItem('attendant');
        this.$router.push('/login');
      }
    },
      created(){
      axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
      this.loggedIn()
    }
  }

</script>