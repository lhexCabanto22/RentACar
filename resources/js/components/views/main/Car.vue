<template>
  <v-data-table
    :headers="headers"
    :items="cars"
    sort-by="id"
    class="elevation-1"
  >
    <template v-slot:[`item.status`]="{ item }">
              <v-btn icon @click="updateStatus(item.id)">
                <v-icon  v-if="item.status" color="error" > mdi-car-clock</v-icon>
                <v-icon v-else color="success">mdi-car-key</v-icon>
              </v-btn>
            </template>
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>CARS</v-toolbar-title>
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
        
          <template v-slot:activator="{ on, attrs }">
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
                      v-model="editedItem.description"
                      label="Description"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.plate_number"
                      label="Plate No"
                    ></v-text-field>
                  </v-col>
                   <v-col
                   cols="12"
                    sm="6"
                    md="4"
                  >
                     <v-select
                      :items="brand"
                      v-model="editedItem.brand_id"
                      item-value="id" 
                      item-text="name"
                      label="Select brand"
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
        v-if="admin"
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
        { text: 'Description', value: 'description' },
        { text: 'Plate No', value: 'plate_number' },
        { text: 'Brand', value: 'brand.name' },
        {text: 'Status', value: 'status'},
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      admin: localStorage.getItem('admin'),
      cars: [],
      office: [],
      brand:[],
      editedIndex: -1,
      editedItem: {
        name: '',
        description: '',
        plate_number: '',
        brand_id:'',
      },
      defaultItem: {
        name: '',
        description: '',
        plate_number: '',
        brand_id:'',
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Add car' : 'Edit car'
      },
    },

    watch: {
      dialog (val) {
        if(val) {
           axios.get('api/brand').then(response =>{
            this.brand = response.data.brand
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
          axios.get('/api/car').then(res => {
            this.cars = res.data.car
          }).catch(errors =>{
          if(errors.response.status == 401)
          {
            localStorage.removeItem('token')
            this.$router.push('/login')
          }
        })
      },

      editItem (item) {
        this.editedIndex = this.cars.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
          axios.delete('api/car/'+item.id)
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
          axios.put('api/car/'+this.editedItem.id, this.editedItem).then(res => {
            this.initialize();
          }).catch(error => console.log(error.response))
        } else {
          axios.post('api/car', this.editedItem).then(res => { 
            this.cars.push(res.data.car)
            this.initialize()
          })
          .catch(err => {
            console.log(err.response);
          })
        }
        this.close()
      },

       updateStatus(id){
       axios.put('api/updateCarStatus/'+id)
          this.initialize()
    }
    },
  }
</script>
