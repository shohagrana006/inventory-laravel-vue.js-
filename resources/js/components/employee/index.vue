<template>
  <div>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="row my-3">
          <div class="col-lg-4 ml-4">
            <router-link to="/add/employee" class="btn btn-primary"
              >Add Employee</router-link
            >
          </div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row">
          <!-- DataTales Example -->
          <div class="col-lg-12">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Employee</h6>
              </div>
              <div class="card-body">
                <input
                  type="text"
                  v-model="searchTerm"
                  placeholder="Search Here"
                  class="form-control"
                  id="searchTerm"
                />
                <div class="table-responsive">
                  <table
                    class="table table-bordered"
                    width="100%"
                    cellspacing="0"
                  >
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Photo</th>
                        <th>Salary($)</th>
                        <th>Joining Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="employee in filterSearch" :key="employee.id">
                        <td>{{ employee.name }}</td>
                        <td>{{ employee.phone }}</td>
                        <td>{{ employee.email }}</td>
                        <td>
                          <img
                            :src="employee.photo"
                            height="50"
                            width="50"
                            alt=""
                          />
                        </td>
                        <td>{{ employee.salary }}</td>
                        <td>{{ employee.joining_date }}</td>
                        <td>
                          <router-link
                            :to="{
                              name: 'editemployee',
                              params: { id: employee.id },
                            }"
                            class="btn btn-info btn-sm"
                            >Edit</router-link
                          >
                          <a
                            @click="deleteEmployee(employee.id)"
                            class="btn btn-danger btn-sm"
                            >Delete</a
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
export default {
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }
  },
  data() {
    return {
      employees: [],
      searchTerm: "",
    };
  },
  computed: {
    filterSearch() {
      return this.employees.filter((employee) => {
        return employee.phone.match(this.searchTerm);
      });
    },
  },
  methods: {
    allEmployee() {
      axios
        .get("api/employee")
        .then(({ data }) => (this.employees = data))
        .catch();
    },
    deleteEmployee(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete("api/employee/" + id)
            .then(() => {
              this.employees = this.employees.filter((employee) => {
                return employee.id != id;
              });
            })
            .catch(() => {
              this.$router.push({ name: "employee" });
            });
          Swal.fire("Deleted!", "Your file has been deleted.", "success");
        }
      });
    },
  },
  created() {
    this.allEmployee();
  },
};
</script>

<style scoped>
#searchTerm {
  width: 350px;
  margin-bottom: 15px;
}
</style>
