<template>
    <div>
        <!-- Modal -->
        <div class="modal fade" id="viewEmployeeModal" role="dialog" aria-labelledby="viewCity" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modalLarge" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewEmployeeModal">
                            View Employee:
                            {{ employeeData.name }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Print Data -->
                        <div id="printData">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>First Name</th>
                                        <td>{{ employeeData.first_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Name</th>
                                        <td>{{ employeeData.last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ employeeData.email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Company</th>
                                        <td>{{ employeeData.company && employeeData.company.name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ employeeData.phone }}</td>
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
    name: "viewEmployeeModal",
    props: ["employeeData"],
    data() {
        return {};
    },
};
</script>
  