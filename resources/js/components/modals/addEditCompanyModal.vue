<template>
    <div>
        <div class="modal fade" id="addEditCompanyModal" city="dialog" aria-labelledby="addEditCompanyModalLabel"
            aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEditCompanyModalLabel" v-if="editMode === false">
                            Company
                        </h5>
                        <h5 class="modal-title" id="addEditCompanyModalLabel" v-else>
                            Edit Company
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? editCompany() : addCompany()">
                        <input type="hidden" name="_token" />
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name<span class="required-star">*</span></label>
                                <input v-model="form.name" type="text" name="name" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('name') }" />
                                <div class="error-message" v-if="form.errors.has('name')"
                                    v-html="form.errors.get('name')" />
                            </div>
                            <div class="form-group">
                                <label>Email<span class="required-star">*</span></label>
                                <input v-model="form.email" type="email" name="email" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('email') }" />
                                <div class="error-message" v-if="form.errors.has('email')"
                                    v-html="form.errors.get('email')" />
                            </div>
                            <div class="form-group">
                                <label>Logo</label>
                                <input type="file" @change="onFileChange" accept="image/*" />
                            </div>
                            <div class="form-group">
                                <label>Website<span class="required-star">*</span></label>
                                <input v-model="form.website" type="text" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('website') }" />
                                <div class="error-message" v-if="form.errors.has('website')"
                                    v-html="form.errors.get('website')" />
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button @click.prevent="addCompany" v-if="editMode === false" type="submit"
                                class="btn btn-primary">
                                Create Company
                            </button>
                            <button @click.prevent="editCompany" v-else type="submit" class="btn btn-primary">
                                Edit Company
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
import { VFileInput } from 'vuetify/lib';
export default {
    name: "addEditCompanyModal",
    data() {
        return {
            companies: [],
            editMode: false, // or true if appropriate
            // Create a new form instance
            form: new form({
                id: "",
                name: "",
                email: "",
                logo: null,
                website: "",
            }),
        };
    },
    components: {
        VFileInput,
    },
    methods: {
        hideFile() {
            this.hide = true;
        },
        onFileChange(event) {
            this.form.logo = event.target.files[0];
        },
        addCompany() {
            this.$Progress.start();
            this.form
                .post("api/companies")
                .then(() => {
                    Fire.$emit("reloadCompanies");
                    $("#addEditCompanyModal").modal("hide");
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
        editCompany() {
            this.$Progress.start();
            this.form
                .put("api/companies/" + this.form.id)
                .then(() => {
                    Fire.$emit("reloadCompanies");
                    $("#addEditCompanyModal").modal("hide");
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
        $("#addEditCompanyModal").on("show.bs.modal", function (e) {
            if (e.relatedTarget) {
                that.editMode = true;
                form.fill(e.relatedTarget);
            } else {
                form.reset();
                that.editMode = false;
            }
        });
    },
};
</script>
  