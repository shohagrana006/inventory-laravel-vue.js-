<template>
  <div>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="row my-3">
          <div class="col-lg-4">
            <router-link
              to="/add/product"
              class="btn btn-primary"
              style="border-radius: 0"
              >Add Product</router-link
            >
          </div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row">
          <!-- DataTales Example -->
          <div class="col-lg-12">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Stock Product</h6>
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
                        <th>Product Name</th>
                        <th>Product Code</th>
                        <th>Image</th>
                        <th>Buying Price($)</th>
                        <th>Product Quantity</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="product in filterSearch" :key="product.id">
                        <td>{{ product.product_name }}</td>
                        <td>{{ product.product_code }}</td>
                        <td>
                          <img
                            :src="product.image"
                            height="50"
                            width="50"
                            alt=""
                          />
                        </td>
                        <td>{{ product.buying_price }}</td>
                        <td>{{ product.product_quantity }}</td>
                        <td v-if="product.product_quantity >= 1">
                          <span class="badge badge-success">Aviable</span>
                        </td>
                        <td v-else="">
                          <span class="badge badge-danger">stockout</span>
                        </td>
                        <td>
                          <router-link
                            :to="{
                              name: 'editstock',
                              params: { id: product.id },
                            }"
                            class="btn btn-sm btn-warning"
                            >Update Stock</router-link
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
      products: [],
      searchTerm: "",
    };
  },
  computed: {
    filterSearch() {
      return this.products.filter((product) => {
        return product.product_name.match(this.searchTerm);
      });
    },
  },
  methods: {
    allProduct() {
      axios
        .get("/api/product")
        .then(({ data }) => (this.products = data))
        .catch(console.log("error"));
    },
  },
  mounted() {
    this.allProduct();
  },
};
</script>

<style scoped>
#searchTerm {
  width: 350px;
  margin-bottom: 15px;
}
</style>
