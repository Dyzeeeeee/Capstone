const routes = [
  {
    path: "/admin",
    component: () => import("@/layouts/AdminLayout.vue"),
    children: [
      {
        path: "dashboard",
        component: () => import("@/views/admin/Dashboard.vue"),
      },
      { path: "menu", component: () => import("../views/admin/Menu.vue") },
      { path: "stocks", component: () => import("../views/admin/Stocks.vue") },
      {
        path: "counter",
        component: () => import("../views/admin/Counter.vue"),
      },
      { path: "Orders", component: () => import("../views/admin/Orders.vue") },
    ],
  },
  {
    path: "/employee",
    component: () => import("@/layouts/EmployeeLayout.vue"),
    children: [
      {
        path: "dashboard",
        component: () => import("@/views/employee/Dashboard.vue"),
      },
      {
        path: "session/:id",
        component: () => import("../views/employee/Session.vue"),
      },
      {
        path: "counter",
        component: () => import("../views/employee/Counter.vue"),
      },
      {
        path: "payment/:id",
        component: () => import("../views/employee/Payment.vue"),
      },
    ],
  },

  {
    Path: "/login",
    component: () => import("../views/auth/LoginView.vue"),
  },
  {
    path: "/register",
    component: () => import("../views/auth/RegisterView.vue"),
  },
  {
    path: "/website",
    component: () => import("@/layouts/WebsiteLayout.vue"),
    children: [
      {
        path: "home",
        component: () => import("@/views/website/Home.vue"),
      },
      {
        path: "about",
        component: () => import("@/views/website/About.vue"),
      },
    ],
  },
];

export default routes;
