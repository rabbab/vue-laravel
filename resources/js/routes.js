const routes = [
    {
      name: "companies",
      path: "/companies",
      component: require("./components/companies.vue").default,
    },
    {
      name: "employees",
      path: "/employees",
      component: require("./components/employees.vue").default,
    },
];
export default routes;