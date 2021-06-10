<template>
  <div>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="row my-3">
          <div class="col-lg-4 ml-4">
            <router-link to="/given/salary" class="btn btn-primary"
              >Pay Salary</router-link
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
                  View Salary Details
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
                        <th>Month</th>
                        <th>Details</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="salary in filterSearch" :key="salary.id">
                        <td>{{ salary.salary_month }}</td>
                        <td>
                          <router-link
                            :to="{
                              name: 'viewsalary',
                              params: { id: salary.salary_month },
                            }"
                            class="btn btn-success btn-sm"
                            >View</router-link
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
        return salary.salary_month.match(this.searchTerm);
      });
    },
  },
  methods: {
    allSalary() {
      axios
        .get("/api/salary/")
        .then(({ data }) => (this.salaries = data))
        .catch();
    },
  },
  created() {
    this.allSalary();
  },
};
</script>

<style scoped>
#searchTerm {
  width: 350px;
  margin-bottom: 15px;
}
</style>
