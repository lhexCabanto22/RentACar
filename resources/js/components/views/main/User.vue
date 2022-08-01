<template>
  <v-data-table
    :headers="headers"
    :items="users"
    sort-by="id"
    class="elevation-1"
   
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>Users</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog
          v-model="dialog"
          max-width="500px"
        >
          <template v-slot:activator="{ on, attrs }"  v-if="admin">
            <v-btn
              color="primary"
              dark
              rounded
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
             +
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.name"
                      label="Name"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.contact"
                      label="Contact"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.address"
                      label="Address"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.email"
                      label="Email"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.password"
                      label="Password"
                      type="password"
                    ></v-text-field>
                    
                  </v-col>
                  <v-col
                   cols="12"
                    sm="6"
                    md="4"
                  >
                     <v-select
                     :items="office"
                      v-model="editedItem.office_id"
                      item-value="id" 
                      item-text="name"
                      label="Select Office"
                      ></v-select>
                  </v-col>
                   <v-col
                   cols="12"
                    sm="6"
                    md="4"
                  >
                     <v-select
                      :items="role"
                      v-model="editedItem.role_id"
                      item-value="id" 
                      item-text="type"
                      label="Select Role"
                      ></v-select>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="close"
              >
                Cancel
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="save"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItem(item)">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="deleteItemConfirm(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn
        color="primary"
        @click="initialize"
      >
        Reset
      </v-btn>
    </template>
  </v-data-table>
</template>

<script>
  export default {
    data: () => ({
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          text: '#',
          align: 'start',
          sortable: false,
          value: 'id',
        },
        { text: 'Name', value: 'name' },
        { text: 'Contact', value: 'contact' },
        { text: 'Address', value: 'address' },
        { text: 'Email', value: 'email' },
        { text: 'Office', value: 'office.name' },
        { text: 'Role', value: 'role.type' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      admin: [],
      users: [],
      office: [],
      role:[],
      editedIndex: -1,
      editedItem: {
        name: '',
        contact: '',
        address: '',
        email: '',
        password: '',
        office_id:'',
        role_id:'',
      },
      defaultItem: {
        name: '',
        contact: '',
        address: '',
        email: '',
        password: '',
        office_id:'',
        role_id:'',
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Add User' : 'Edit User'
      },
    },

    watch: {
      dialog (val) {
        if(val) {
            axios.get('api/office').then(response =>{
            this.office = response.data
          })
           axios.get('api/role').then(response =>{
            this.role = response.data
          })
          
        }
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
          axios.get('/api/user').then(res => {
            this.users = res.data.users
          }).catch(errors => {
          if(errors.response.status == 401)
          {
            localStorage.removeItem('token')
            this.$router.push('/login')
          }
        })
        this.admin = localStorage.getItem('admin');
      },

      editItem (item) {
        this.editedIndex = this.users.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
          axios.delete('api/user/delete/'+item.id)
          this.initialize()
          this.closeDelete()
      },

      deleteItemConfirm (item) {
        this.dialogDelete = true
        this.item = item
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        if (this.editedIndex > -1) {
          axios.put('api/user/'+this.editedItem.id, this.editedItem).then(res => {
            this.initialize();
          }).catch(error => console.log(error.response))
        } else {
          axios.post('api/user', this.editedItem).then(res => { 
            this.users.push(res.data.user)
             this.initialize();
          })
          .catch(err => {
            console.log(err.response);
          })
        }
        this.close()
      },
    },
  }
</script>