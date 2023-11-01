<template>
    <div>
        <!-- Modal -->
        <div class="modal fade" id="viewCompanyModal" role="dialog" aria-labelledby="viewCity" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modalLarge" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewCompanyModal">
                            View Company:
                            {{ companyData.name }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Print Data -->
                        <div id="printData">
                            <div class="text-center">
                                <img :src="`/storage/${companyData.logo}`" alt="Company Logo"
                                    style="max-width: 200px; max-height: 200px;" />
                            </div>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ companyData.name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ companyData.email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Website</th>
                                        <td>{{ companyData.website }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button @click.prevent="printSale" class="btn btn-primary">
                                PRINT
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                CLOSE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "viewCompanyModal",
    props: ["companyData"],
    data() {
        return {};
    },
};
</script>
  