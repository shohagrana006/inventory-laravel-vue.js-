<template>
  <div>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="row my-3">
          <div class="col-lg-4 ml-4">
            <router-link to="/add/customer" class="btn btn-primary"
              >Add Customer</router-link
            >
          </div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row">
          <!-- DataTales Example -->
          <div class="col-lg-12">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Customer</h6>
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
                        <th>Photo</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="customer in filterSearch" :key="customer.id">
                        <td>{{ customer.name }}</td>
                        <td>
                          <img
                            :src="customer.photo"
                            height="50"
                            width="50"
                            alt=""
                          />
                        </td>
                        <td>{{ customer.phone }}</td>
                        <td>{{ customer.email }}</td>
                        <td>{{ customer.address }}</td>
                        <td>
                          <router-link
                            :to="{
                              name: 'editcustomer',
                              params: { id: customer.id },
                            }"
                            class="btn btn-info btn-sm"
                            >Edit</router-link
                          >
                          <a
                            @click="deleteCustomer(customer.id)"
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
      customers: [],
      searchTerm: "",
    };
  },
  computed: {
    filterSearch() {
      return this.customers.filter((customer) => {
        return customer.name.match(this.searchTerm);
      });
    },
  },
  methods: {
    allCustomer() {
      axios
        .get("/api/customer/")
        .then(({ data }) => (this.customers = data))
        .catch();
    },
    deleteCustomer(id) {
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
            .delete("api/customer/" + id)
            .then(() => {
              this.customers = this.customers.filter((customer) => {
                return customer.id != id;
              });
            })
            .catch(() => {
              this.$router.push({ name: "customer" });
            });
          Swal.fire("Deleted!", "Your file has been deleted.", "success");
        }
      });
    },
  },
  created() {
    this.allCustomer();
  },
};
</script>

<style scoped>
#searchTerm {
  width: 350px;
  margin-bottom: 15px;
}
</style>
