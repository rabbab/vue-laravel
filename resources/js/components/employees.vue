<template>
    <v-app>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            <h1 class="m-0 text-dark">
                                Employee
                            </h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <button class="btn btn-success float-right" @click="addEmployee">
                                CREATE EMPLOYEE
                                <i class="fas fa-plus fa-fw"></i>
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-tools">
                                        <!-- <form @submit.prevent>
                                                <v-text-field class="m-0 p-0" v-model="search" append-icon="mdi-magnify"
                                                    label="Rechercher" single-line hide-details></v-text-field>
                                            </form> -->
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <v-data-table :headers="headers" :items="employees.data ? employees.data : employees"
                                        :server-items-length="employees.total" class="elevation-1" :loading="loading"
                                        :options.sync="options" :search="search" :footer-props="{
                                            showFirstLastPage: true,
                                            'items-per-page-options': [10, 50, 100, 500, -1],
                                        }">
                                        <template v-slot:item.actions="{ item }">
                                            <v-icon color="green" class="edit-icon mr-2" small @click="viewEmployee(item)">
                                                mdi-eye
                                            </v-icon>
                                            <v-icon color="blue" class="edit-icon mr-2" small @click="editEmployee(item)">
                                                mdi-pencil
                                            </v-icon>
                                            <v-icon color="red" class="delete-icon" small @click="deleteEmployee(item.id)">
                                                mdi-delete
                                            </v-icon>
                                        </template>
                                    </v-data-table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content -->
            <addEditEmployeeModal></addEditEmployeeModal>
            <viewEmployeeModal :employeeData="employeeInfo"></viewEmployeeModal>
        </div>
    </v-app>
</template>
  
<script>
import addEditEmployeeModal from "./modals/addEditEmployeeModal.vue";
import viewEmployeeModal from "./modals/viewEmployeeModal.vue";
export default {
    data() {
        return {
            form: new form(),
            employees: [],
            curpage: 1,
            search: "",
            itemsPerPage: 10,
            loading: true,
            options: {},
            employeeInfo: {},
            sortBy: "",
            sortDesc: "",
            headers: [
                { text: "NAME", value: "first_name" },
                { text: "EMAIL", value: "email" },
                { text: "Company", value: "company.name" },
                { text: "phone", value: "phone" },
                {
                    text: "ACTIONS",
                    value: "actions",
                    sortable: false,
                },
            ],
        };
    },
    components: {
        addEditEmployeeModal,
        viewEmployeeModal
    },
    watch: {
        //DataTable watcher!
        options: {
            handler() {
                this.getResults(
                    this.options.page ? this.options.page : null,
                    this.options.itemsPerPage ? this.options.itemsPerPage : null
                );
            },
            deep: true,
        },
        search() {
            this.getResults();
        },
    },
    methods: {
        getResults(page = 1, rows = 10, sortBy = null, sortDesc = null) {
            this.loading = true;
            this.curpage = page;
            if (this.options.sortBy && this.options.sortBy.length > 0) {
                this.sortBy = this.options.sortBy[0];
            } else {
                this.sortBy = "";
            }
            if (this.options.sortDesc && this.options.sortDesc.length > 0) {
                this.sortDesc = this.options.sortDesc[0];
            } else {
                this.sortDesc = "";
            }
            axios
                .get(
                    "api/employees?page=" +
                    page +
                    "&search=" +
                    this.search +
                    "&numRows=" +
                    rows +
                    "&sortBy=" +
                    this.sortBy +
                    "&sortDesc=" +
                    this.sortDesc
                )
                .then((response) => {
                    this.employees = response.data;
                    this.loading = false;
                })
                .catch(() => {
                    this.loading = false;
                    toast.fire({
                        icon: "error",
                        title: "Something went wrong!",
                    });
                });
        },
        addEmployee() {
            $("#addEditEmployeeModal").modal("show");
        },
        viewEmployee(employee) {
            this.employeeInfo = employee;
            $("#viewEmployeeModal").modal("show", employee);
        },
        editEmployee(employee) {
            this.employeeInfo = employee;
            $("#addEditEmployeeModal").modal("show", employee);
        },
        deleteEmployee(id) {
            swal
                .fire({
                    title: "Confirm",
                    text: "You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancle",
                    confirmButtonText: "Yes, delete it!",
                })
                .then((result) => {
                    this.$Progress.start();
                    if (result.value) {
                        // Send request to the server
                        this.form
                            .delete("api/employees/" + id)
                            .then(() => {
                                this.cities.total -= 1;
                                Fire.$emit("reloadEmployees");
                                this.$Progress.finish();
                                swal.fire(
                                    "Deleted",
                                    "Delete Message Success",
                                    "success"
                                );
                            })
                            .catch(() => {
                                this.$Progress.fail();
                                swal.fire(
                                    "Failed",
                                    "Delete Message Error",
                                    "warning"
                                );
                            });
                    }
                });
        },
    },
    created() {
        Fire.$on("reloadEmployees", () => {
            this.getResults(this.curpage);
        });
    },
};
</script>
