<template>
  <div>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <!-- DataTales Example -->
          <div class="col-lg-12">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Today Order</h6>
              </div>
              <div class="card-body">
                <input type="text" v-model="searchTerm" placeholder="Search Here"
                  class="form-control" id="searchTerm"/>
                <div class="table-responsive">
                  <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Total</th>
                        <th>Pay</th>
                        <th>Due</th>
                        <th>Pay by</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="order in filterSearch" :key="order.id">
                        <td>{{ order.name }}</td>
                        <td>{{ order.total }}</td>
                        <td>{{ order.pay }}</td>
                        <td>{{ order.due }}</td>
                        <td>{{ order.payby }}</td>
                        <td>
                          <router-link
                            :to="{name: 'orderview', params: { id: order.id },}"
                            class="btn btn-info btn-sm">View</router-link>
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
      orders: [],
      searchTerm: "",
    };
  },
  computed: {
    filterSearch() {
      return this.orders.filter((order) => {
        return order.name.match(this.searchTerm);
      });
    },
  },
  methods: {
    allOrder() {
      axios
        .get("/api/order/")
        .then(({ data }) => (this.orders = data))
        .catch();
    },
  },
  created() { 
    this.allOrder();
  },
};
</script>

<style scoped>
#searchTerm {
  width: 350px;
  margin-bottom: 15px;
}
</style>
