<template>
  <v-data-table
    :headers="headers"
    :items="rents"
    sort-by="id"
    class="elevation-1"
  >
      <template v-slot:[`item.name`]="{ item }">
       {{item.customer.first_name + ' ' + item.customer.last_name}}
      </template>
       <template v-slot:[`item.status`]="{ item }">
              <v-btn icon @click="updateStatus(item.id)">
                <v-icon  v-if="item.status" color="primary" >mdi-car-key</v-icon>
                <v-icon v-else color="error">mdi-car-clock</v-icon>
              </v-btn>
            </template>
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>RENTS</v-toolbar-title>
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
                     <v-select
                      :items="car"
                      v-model="editedItem.car_id"
                      item-value="id" 
                      item-text="name"
                      label="Select car"
                      ></v-select>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.quantity"
                      label="Quantity"
                      type="number"
                      min="1"
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
                     <v-select
                     :items="customer"
                      v-model="editedItem.customer_id"
                      item-value="id" 
                      item-text="first_name"
                      label="Select customer"
                      ></v-select>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.rent_date"
                      label="Rent Date"
                      type="date"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.return_date"
                      label="Return Date"
                      type="date"
                    ></v-text-field>
                    
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
         v-if="admin"
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
      nav: null,
      headers: [
        {
          text: '#',
          align: 'start',
          sortable: false,
          value: 'id',
        },
        { text: 'Customer', value: 'name'},
        { text: 'Cars', value: 'car.name' },
        { text: 'Quantity', value: 'quantity' },
        { text: 'Contact', value: 'customer.contact'},
        { text: 'Address', value: 'customer.barangay'},
        { text: 'Rented Date', value: 'rent_date' },
        { text: 'Return Date', value: 'return_date' },
        { text: 'Status', value: 'status' },
      ],
      admin: [
          {
          text: '#',
          align: 'start',
          sortable: false,
          value: 'id',
        },
        { text: 'Customer', value: 'name'},
        { text: 'Cars', value: 'car.name' },
        { text: 'Quantity', value: 'quantity' },
        { text: 'Contact', value: 'customer.contact'},
        { text: 'Address', value: 'customer.barangay'},
        { text: 'Rented Date', value: 'rent_date' },
        { text: 'Return Date', value: 'return_date' },
        { text: 'Status', value: 'status' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      rents: [],
      customer: [],
      car:[],
      editedIndex: -1,
      editedItem: {
          car_id: '',
          quantity: '',
          customer_id:'',
          rent_date: '',
          return_date:'',
     
      },
      defaultItem: {
        car_id: '',
        quantity: '',
        customer_id:'',
        rent_date: '',
        return_date:'',
        
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Add rent' : 'Edit rent'
      },
    },

    watch: {
      dialog (val) {
        if(val) {
            axios.get('api/customer').then(response =>{
            this.customer = response.data.office
          })
           axios.get('api/car_display').then(response =>{
            this.car = response.data.cars
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
          axios.get('/api/rent',{}).then(res => {
            this.rents = res.data.rent
          }).catch(errors =>{
          if(errors.response.status == 401)
          {
            localStorage.removeItem('token')
            this.$router.push('/login')
          }
        })
      },
      getNav(){
        if(localStorage.getItem('admin'))
        {
          this.nav = this.admin
        }
      },
      editItem (item) {
        this.editedIndex = this.rents.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
          axios.delete('api/rent/'+item.id)
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
          axios.put('api/rent/'+this.editedItem.id, this.editedItem).then(res => {
            this.initialize();
          }).catch(error => console.log(error.response))
        } else {
          axios.post('api/rent',this.editedItem).then(res => { 
            this.rents.push(res.data.rents)
            this.initialize();
          })
          .catch(err => {
            console.log(err.response);
          })
        }
        this.close()
      },

       updateStatus(id){
       axios.put('api/updateStatus/'+id)
          this.initialize()
    }
    },

   
  }
</script>