import Login from "@/Pages/Auth/Login.vue";
import Register from "@/Pages/Auth/Register.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Dashboard from "@/Pages/Dashboard.vue";
import Role from "@/Pages/Role/Index.vue";
import Lead from "@/Pages/Lead/Index.vue";
import LeadColor from "@/Pages/Lead/LeadColor.vue";
import LeadImport from "@/Pages/Lead/Import.vue";






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
      },
      {
        path: "/leads",
        name: "leads",
        component: Lead,
      },
      {
        path: "/lead-colors",
        name: "lead-colors",
        component: LeadColor,
      },
      {
        path: "/lead-import",
        name: "lead-import",
        component: LeadImport,
      }
    ],
  },

];

export default routes;
