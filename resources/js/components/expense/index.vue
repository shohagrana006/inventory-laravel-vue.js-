<template>
  <div>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="row my-3">
          <div class="col-lg-4 ml-4">
            <router-link to="/add/expense" class="btn btn-primary"
              >Add Expense</router-link
            >
          </div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row">
          <!-- DataTales Example -->
          <div class="col-lg-12">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Expense</h6>
              </div>
              <div class="card-body">
                <input
                  type="text"
                  v-model="searchTerm"
                  placeholder="Search Here by name"
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
                        <th>Expense Details</th>
                        <th>Expense Ammount</th>
                        <th>Expense Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="expense in filterSearch" :key="expense.id">
                        <td>{{ expense.details }}</td>
                        <td>{{ expense.ammount }}</td>
                        <td>{{ expense.date }}</td>
                        <td>
                          <router-link
                            :to="{
                              name: 'editexpense',
                              params: { id: expense.id },
                            }"
                            class="btn btn-sm btn-primary"
                            >Edit</router-link
                          >
                          <a
                            @click="deleteExpense(expense.id)"
                            class="btn btn-sm btn-danger"
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
      this.$router.push("/");
    }
  },
  data() {
    return {
      expenses: [],
      searchTerm: "",
    };
  },
  computed: {
    filterSearch() {
      return this.expenses.filter((expense) => {
        return expense.details.match(this.searchTerm);
      });
    },
  },
  methods: {
    allExpense() {
      axios
        .get("/api/expense")
        .then(({ data }) => (this.expenses = data))
        .catch(console.log("error"));
    },
    deleteExpense(id) {
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
            .delete("/api/expense/" + id)
            .then(() => {
              this.expenses = this.expenses.filter((expense) => {
                return expense.id != id;
              });
            })
            .catch(() => {
              this.$router.push("/expense");
            });
          Swal.fire("Deleted!", "Your file has been deleted.", "success");
        }
      });
    },
  },
  mounted() {
    this.allExpense();
  },
};
</script>


<style scoped>
#searchTerm {
  width: 350px;
  margin-bottom: 15px;
}
</style>
