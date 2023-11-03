<template>
    <div>
        <div class="modal fade" id="addEditEmployeeModal" city="dialog" aria-labelledby="addEditEmployeeModalLabel"
            aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEditEmployeeModalLabel" v-if="editMode === false">
                            Employee
                        </h5>
                        <h5 class="modal-title" id="addEditEmployeeModalLabel" v-else>
                            Edit Employee
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? editEmployee() : addEmployee()">
                        <input type="hidden" name="_token" :value="csrf" />
                        <div class="modal-body">
                            <div class="form-group">
                                <label>First Name<span class="required-star">*</span></label>
                                <input v-model="form.first_name" type="text" name="first_name" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('first_name') }" />
                                <div class="error-message" v-if="form.errors.has('first_name')"
                                    v-html="form.errors.get('first_name')" />
                            </div>
                            <div class="form-group">
                                <label>Last Name<span class="required-star">*</span></label>
                                <input v-model="form.last_name" type="text" name="last_name" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('last_name') }" />
                                <div class="error-message" v-if="form.errors.has('last_name')"
                                    v-html="form.errors.get('last_name')" />
                            </div>
                            <div class="form-group">
                                <label>Company<span class="required-star"></span>*</label>
                                <v-select v-model="form.company_id" :options="companies" label="name"
                                    :reduce="company => company.id" :selectOnTab="true" :key="form.company_id"
                                    :class="{ 'is-invalid': form.errors.has('company_id') }" />
                                <div class="error-message" v-if="form.errors.has('company_id')"
                                    v-html="form.errors.get('company_id')" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="form.email" type="email" name="email" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('email') }" />
                                <div class="error-message" v-if="form.errors.has('email')"
                                    v-html="form.errors.get('email')" />
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input v-model="form.phone" type="text" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('phone') }" />
                                <div class="error-message" v-if="form.errors.has('phone')"
                                    v-html="form.errors.get('phone')" />
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button @click.prevent="addEmployee" v-if="editMode === false" type="submit"
                                class="btn btn-primary">
                                Create Employee
                            </button>
                            <button @click.prevent="editEmployee" v-else type="submit" class="btn btn-primary">
                                Edit Employee
                            </button>

                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "addEditEmployeeModal",
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                : "",
            companies: [],
            editMode: "", // or true if appropriate
            // Create a new form instance
            form: new form({
                id: "",
                first_name: "",
                last_name: "",
                company_id: "",
                email: "",
                phone: "",
            }),
        };
    },
    components: {
    },
    methods: {
        addEmployee() {
            this.$Progress.start();
            this.form
                .post("api/employees")
                .then(() => {
                    Fire.$emit("reloadEmployees");
                    $("#addEditEmployeeModal").modal("hide");
                    toast.fire({
                        icon: "success",
                        title: "Record created successfully",
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                    toast.fire({
                        icon: "warning",
                        title: "Something went wrong!",
                    });
                });
        },
        editEmployee() {
            this.$Progress.start();
            this.form
                .put("api/employees/" + this.form.id)
                .then(() => {
                    Fire.$emit("reloadEmployees");
                    $("#addEditEmployeeModal").modal("hide");
                    toast.fire({
                        icon: "success",
                        title: "Record updated successfully",
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                    toast.fire({
                        icon: "warning",
                        title: "Something went wrong!",
                    });
                });

        },
    },
    mounted() {
        var form = this.form;
        var that = this;
        $("#addEditEmployeeModal").on("show.bs.modal", function (e) {
            if (e.relatedTarget) {
                that.editMode = true;
                form.fill(e.relatedTarget);
                form.logo = e.relatedTarget.logo;
            } else {
                form.reset();
                that.editMode = false;
            }
            axios.get("api/getCompanies")
                .then((response) => {
                    that.companies = response.data;
                    that.$Progress.finish();
                })
                .catch(() => {
                    that.$Progress.fail();
                    toast.fire({
                        icon: "error",
                        title: "SOMETHING_WENT_WRONG",
                    });
                });
        });
    },
};
</script>
  