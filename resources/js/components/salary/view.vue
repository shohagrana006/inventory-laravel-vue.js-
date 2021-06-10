<template>
  <div>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="row my-3">
          <div class="col-lg-4 ml-4">
            <router-link to="/salary" class="btn btn-primary"
              >Go Back</router-link
            >
          </div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row">
          <!-- DataTales Example -->
          <div class="col-lg-12">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                  Employee Details List
                </h6>
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
                        <th>Month</th>
                        <th>Ammount</th>
                        <th>Salary Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="salary in filterSearch" :key="salary.id">
                        <td>{{ salary.name }}</td>
                        <td>{{ salary.salary_month }}</td>
                        <td>{{ salary.ammount }}</td>
                        <td>{{ salary.salary_date }}</td>
                        <td>
                          <router-link
                            :to="{
                              name: 'editsalary',
                              params: { id: salary.id },
                            }"
                            class="btn btn-success btn-sm"
                            >Edit Salary</router-link
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
      salaries: [],
      searchTerm: "",
    };
  },
  computed: {
    filterSearch() {
      return this.salaries.filter((salary) => {
        return salary.name.match(this.searchTerm);
      });
    },
  },
  methods: {
    viewSalary() {
      let id = this.$route.params.id;
      axios
        .get("/api/view/salary/" + id)
        .then(({ data }) => (this.salaries = data))
        .catch();
    },
  },
  created() {
    this.viewSalary();
  },
};
</script>

<style scoped>
#searchTerm {
  width: 350px;
  margin-bottom: 15px;
}
</style>
