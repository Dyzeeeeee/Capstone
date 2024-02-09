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
      { path: "counter", component: () => import("../views/admin/Counter.vue") },
      { path: "Orders", component: () => import("../views/admin/Orders.vue") },
    ],
  },

  {
    path: "/login",
    component: () => import("../views/auth/LoginView.vue"),
  },
  {
    path: "/register",
    component: () => import("../views/auth/RegisterView.vue"),
  },
];

export default routes;
