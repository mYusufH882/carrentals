// route.js
import { createRouter, createWebHistory } from 'vue-router';
import Login from './auth/Login.vue';
import Register from './auth/Register.vue';
import Dashboard from './layout/Dashboard.vue';
import Home from './layout/Home.vue';
import Mobil from './admin/mobil/Mobil.vue';
import Layout from './layout/components/Layout.vue';
import PeminjamanAdmin from './admin/peminjaman/PinjamMobil.vue';
import PengembalianAdmin from './admin/pengembalian/KembaliMobil.vue';
import InputMobil from './admin/mobil/InputMobil.vue';
import EditMobil from './admin/mobil/EditMobil.vue';

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: { requiresAuth: false },
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: { requiresAuth: false },
    },
    {
      path: '/',
      component: Layout,
      meta: { requiresAuth: true },
      children: [
        {
          path: '/dashboard',
          name: 'Dashboard',
          component: Dashboard,
          meta: { requiresAuth: true, role: 'rental' },
        },
        {
          path: '/mobil',
          name: 'Mobil',
          component: Mobil,
          meta: { requiresAuth: true, role: 'rental' }
        },
        {
          path: '/input-mobil',
          name: 'InputMobil',
          component: InputMobil,
          meta: { requiresAuth: true, role: 'rental' }
        },
        {
          path: '/edit-mobil/:id',
          name: 'EditMobil',
          component: EditMobil,
          meta: { requiresAuth: true, role: 'rental' }
        },
        {
          path: '/peminjaman-admin',
          name: 'Peminjaman',
          component: PeminjamanAdmin,
          meta: { requiresAuth: true, role: 'rental' }
        },
        {
          path: '/pengembalian-admin',
          name: 'Pengembalian',
          component: PengembalianAdmin,
          meta: { requiresAuth: true, role: 'rental' }
        },
      ]
    },
    {
        path: '/home',
        name: 'Home',
        component: Home,
        meta: { requiresAuth: true, role: 'customer' },
    },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach(async (to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const isAuthenticated = !!localStorage.getItem('authToken'); 
  const userRole = localStorage.getItem('userRole');

  if (requiresAuth && !isAuthenticated) {
    next('/login');
  } else if (requiresAuth && isAuthenticated) {
    if (to.meta.role && to.meta.role !== userRole) {
      if (userRole === 'rental') {
        next('/dashboard'); // Pengguna rental ke Dashboard
      } else if (userRole === 'customer') {
        next('/home'); // Pengguna customer ke Home
      }
    } else {
      next(); // Role sesuai, lanjutkan ke rute yang diminta
    }
  } else {
    next(); // Rute tidak membutuhkan autentikasi, lanjutkan
  }
});

export default router;
