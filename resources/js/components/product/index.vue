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
                <h6 class="m-0 font-weight-bold text-primary">All Product</h6>
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
                        <th>Category Name</th>
                        <th>Supplier Name</th>
                        <th>Product Quantity</th>
                        <th>Buying Price($)</th>
                        <th>Buying Date</th>
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
                            height="70"
                            width="70"
                            alt=""
                          />
                        </td>
                        <td>{{ product.category_name }}</td>
                        <td>{{ product.name }}</td>
                        <td>{{ product.product_quantity }}</td>
                        <td>{{ product.buying_price }}</td>
                        <td>{{ product.buying_date }}</td>
                        <td>
                          <router-link
                            :to="{
                              name: 'editproduct',
                              params: { id: product.id },
                            }"
                            class="btn btn-sm btn-warning"
                            >Edit</router-link
                          >
                          <a
                            @click="deleteProduct(product.id)"
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
    deleteProduct(id) {
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
            .delete("/api/product/" + id)
            .then(() => {
              this.products = this.products.filter((product) => {
                return product.id != id;
              });
            })
            .catch(this.$router.push({ name: product }));
          Swal.fire("Deleted!", "Your file has been deleted.", "success");
        }
      });
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
