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
      {
        path: "validated/:id",
        component: () => import("../views/employee/Validated.vue"),
      },
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
  {
    path: "/",
    component: () => import("@/layouts/WebsiteLayout.vue"),
    children: [
      {
        path: "",
        component: () => import("@/views/website/Home.vue"),
      },
      {
        path: "about",
        component: () => import("@/views/website/About.vue"),
      },
      {
        path: "service",
        component: () => import("@/views/website/Service.vue"),
      },
      {
        path: "menu",
        component: () => import("@/views/website/Menu.vue"),
      },
      {
        path: "booking",
        component: () => import("@/views/website/Booking.vue"),
      },
      {
        path: "team",
        component: () => import("@/views/website/Team.vue"),
      },
      {
        path: "testimonial",
        component: () => import("@/views/website/Testimonial.vue"),
      }, 
    ],
  },
];

export default routes;
