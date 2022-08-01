import Vue from 'vue'
import VueRouter from 'vue-router'

import IndexMain from '../components/views/main/IndexMain.vue';
import Dashboard from '../components/views/main/Dashboard.vue';
import Office from '../components/views/main/Office.vue';
import User from '../components/views/main/User.vue';
import Car from '../components/views/main/Car.vue';
import Brand from '../components/views/main/Brand.vue';
import Rent from '../components/views/main/Rent.vue';
import Customer from '../components/views/main/Customer.vue';
import Login from '../components/views/auth/Login.vue';
import Role from '../components/views/main/Role.vue';

Vue.use(VueRouter);

const routes = [
  {
      path: "/",
      name: "Main",
      component: IndexMain,
      meta: {requiresAuth: true},
      children: [
        {
          path: '/role',
          name: 'Role',
          component: Role,
          meta: {requiresAuth: true},
        },
        {
          path: '/dashboard',
          name: 'Dashboard',
          meta: {requiresAuth: true},
          component: Dashboard
        },
        {
          path: '/office',
          name: 'Office',
          meta: {requiresAuth: true},
          component: Office
        },
        {
          path: '/user',
          name: 'User',
          meta: {requiresAuth: true},
          component: User
        },
        {
          path: '/car',
          name: 'Car',
          meta: {requiresAuth: true},
          component: Car
        },
        {
          path: '/brand',
          name: 'Brand',
          meta: {requiresAuth: true},
          component: Brand
        },
        {
          path: '/rent',
          name: 'Rent',
          meta: {requiresAuth: true},
          component: Rent
        },
        {
          path: '/customer',
          name: 'Customer',
          meta: {requiresAuth: true},
          component: Customer
        }
    
      ]
      
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: {guest: true}
  },
 

]

const router = new VueRouter({
  mode: 'history',
  routes
})

function isLoggedIn()
{
  return localStorage.getItem('token');
}

router.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.requiresAuth))
  {
    if (!isLoggedIn()) {
        next({
          path: '/login',
          query: { redirect: to.fullPath },
        });
    } else {
      next();
    }
  } else if(to.matched.some(record => record.meta.guest)) {
    if (isLoggedIn()) {
        next({
          path: '/dashboard',
          query: { redirect: to.fullPath },
        });
    } else {
      next();
    }
  } else {
    next();
  }
})

export default router