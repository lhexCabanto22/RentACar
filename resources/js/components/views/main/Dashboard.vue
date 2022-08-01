<template>
    <div class="dashboard">

        <v-subheader>
            <h1>Dashboard</h1>
        </v-subheader>
        <v-row>
            <v-col md="3" cols="12" v-for="(data, index) in dashboard" :key="data.data">
                <v-card elevation="0" class="rounded-lg">
                    <v-card-text class="d-flex justify-space-between align-center">
                        <div>
                            <div class="mb-4">
                                <strong class="text-capitalize">{{index}}</strong>
                            </div>
                            <v-subheader class="display-3">{{ data.item }}</v-subheader>
                        </div>
                         <v-btn
                        :key="data.icon"
                            rounded
                            class="pa-10"
                            dark
                            :color="data.color"
                        >
                            <v-icon x-large extended>
                                    {{ data.icon }}
                            </v-icon>
                            </v-btn>
                        <!-- </v-sheet> -->
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </div>
</template>
<script>

export default {
    data () {
        return {
            dashboard: {
                car: {
                    item: '',
                    color: 'orange',
                    icon: 'mdi-car',
                },
                rent: {
                    item: '',
                    color: 'green accent-2',
                    icon: 'mdi-car-key',
                   
                },
                customer: {
                    item: '',
                    color: 'blue-grey',
                    icon: 'mdi-account-group',
                 
                },
                brand: {
                    item: '',
                    color: 'red',
                    icon: 'mdi-watermark',
                   
                }
            },
            route: '',
            headers: [
                { text: 'Car', value: 'name', sortable: false},
                { text: 'Rented', value: 'rented', sortable: false},
            ],
         
        dashboardTop:[]
        }
    },
    created () {
        this.initialize()
    },
    methods: {
        initialize() {
         this.dashboardData()
        //   axios.get('/api/dashboardTop').then(({data}) => {
        //   this.dashboardTop = data;
        // })
        },
        dashboardData() {
            axios.get('/api/dashboard').then(({data}) => {
                this.dashboard.rent.item = data.rent;
                this.dashboard.car.item = data.car;
                this.dashboard.customer.item = data.customer;
                this.dashboard.brand.item = data.brand;
            })
        },
    },
  }

</script>