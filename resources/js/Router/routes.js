import Login from "@/Pages/Auth/Login.vue";
import Register from "@/Pages/Auth/Register.vue";
import ForgotPassword from "@/Pages/Auth/ForgotPassword.vue";
import ResetPassword from "@/Pages/Auth/ResetPassword.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Dashboard from "@/Pages/Dashboard.vue";
import Role from "@/Pages/Role/Index.vue";





const routes = [
  {
    path: "/",
    component: GuestLayout,
    beforeEnter: (to, from, next) => {
      const isAuthenticated = localStorage.getItem('token');
      if (isAuthenticated) {
        return next({ name: 'dashboard' });
      }
      next();
    },
    children: [
      {
        path: "/",
        name: "login",
        component: Login,
      },
      {
        path: "/register",
        name: "register",
        component: Register,
      }
    ],
  },
  {
    path: "/dashboard",
    component: AuthenticatedLayout,
    beforeEnter: (to, from, next) => {
      const isAuthenticated = localStorage.getItem('token');
      if (!isAuthenticated) {
        return next({ name: 'login' });
      }
      next();
    },
    children: [
      {
        path: "",
        name: "dashboard",
        component: Dashboard,
      },
      {
        path: "/roles",
        name: "roles",
        component: Role,
      }
    ],
  },

];

export default routes;