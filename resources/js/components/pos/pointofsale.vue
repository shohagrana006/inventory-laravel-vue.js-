<template>
  <div>
    <div class="row">
      <!-- Area Chart -->
      <div class="col-xl-5 col-lg-4">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div
            class="
              card-header
              py-3
              d-flex
              flex-row
              align-items-center
              justify-content-between
            "
          >
            <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
            <a class="btn btn-info btn-sm">Add Customer</a>
          </div>

          <!-- Card Body -->
          <div class="card-body">
            <div class="table-responsive table-sm">
              <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>quantity</th>
                    <th>Unit</th>
                    <th>total</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="showcart in showcarts" :key="showcart.id">
                    <td>{{ showcart.pro_name }}</td>
                    <td>
                      <input
                        type="text"
                        readonly
                        :value="showcart.pro_quantity"
                        class="cartInput"
                      />
                      <a
                        @click.prevent="increment(showcart.id)"
                        class="btn btn-sm btn-success"
                        >+</a
                      >
                      <a
                        @click.prevent="decrement(showcart.id)"
                        class="btn btn-sm btn-danger"
                        v-if="showcart.pro_quantity >= 2"
                        >-</a
                      >
                      <a
                        @click.prevent="decrement(showcart.id)"
                        class="btn btn-sm btn-danger disabled"
                        v-else=""
                        >-</a
                      >
                    </td>
                    <td>{{ showcart.pro_price }}</td>
                    <td>{{ showcart.sub_total }}</td>
                    <td>
                      <span
                        class="btn btn-sm btn-danger"
                        @click="deleteFormCart(showcart.id)"
                        >X</span
                      >
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="card-footer">
            <ul class="list-group">
              <li
                class="
                  list-group-item
                  d-flex
                  justify-content-between
                  align-items-center
                "
              >
                Total Quantity: <strong>{{ qty }}</strong>
              </li>
              <li
                class="
                  list-group-item
                  d-flex
                  justify-content-between
                  align-items-center
                "
              >
                Sub Total: <strong>{{ subtotal }} $</strong>
              </li>
              <li
                class="
                  list-group-item
                  d-flex
                  justify-content-between
                  align-items-center
                "
              >
                Vat Ammount: <strong>{{ vats.vat }} $</strong>
              </li>
              <li
                class="
                  list-group-item
                  d-flex
                  justify-content-between
                  align-items-center
                "
              >
                Total:
                <strong>{{ (subtotal * vats.vat) / 100 + subtotal }} $</strong>
              </li>
            </ul>
            <br /><br />
            <form action="" @submit.prevent="orderDone">
              <label for="">Customer Name</label>
              <select class="form-control" v-model="customer_id">
                <option :value="customer.id" v-for="customer in customers" :key="customer.id">{{ customer.name }} </option>
              </select>

              <label for="">Pay</label>
              <input type="text" class="form-control" v-model="pay" />

              <label for="">Due</label>
              <input type="text" class="form-control" v-model="due" />

              <label for="">Pay By</label>
              <select class="form-control" v-model="payby">
                <option value="handcash">Hand Cash</option>
                <option value="cheaque">Cheaque</option>
                <option value="giftcard">Gift Card</option>
              </select>
              <button type="submit" class="btn btn-success btn-sm mt-3">Submit</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Pie Chart -->
      <div class="col-xl-7 col-lg-8">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div
            class="
              card-header
              py-3
              d-flex
              flex-row
              align-items-center
              justify-content-between
            "
          >
            <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
          </div>
          <!-- Card Body -->
          <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link active"
                  id="home-tab"
                  data-toggle="tab"
                  href="#home"
                  role="tab"
                  aria-controls="home"
                  aria-selected="true"
                  >All Products</a
                >
              </li>
              <li
                class="nav-item"
                role="presentation"
                v-for="category in categories"
                :key="category.id"
                @click="subproduct(category.id)"
              >
                <a
                  class="nav-link"
                  id="profile-tab"
                  data-toggle="tab"
                  href="#profile"
                  role="tab"
                  aria-controls="profile"
                  aria-selected="false"
                  >{{ category.category_name }}</a
                >
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <input
                type="text"
                v-model="searchTerm"
                placeholder="Search Here"
                class="form-control"
                id="searchTerm"
              />
              <div
                class="tab-pane fade show active"
                id="home"
                role="tabpanel"
                aria-labelledby="home-tab"
              >
                <div class="row">
                  <div
                    class="col-lg-3 col-md-3 col-sm-4 col-4"
                    v-for="product in filterSearch"
                    :key="product.id"
                  >
                    <button
                      class="btn btn-sm"
                      @click.prevent="addToCart(product.id)"
                    >
                      <div class="card mt-3">
                        <img class="card-img-top" :src="product.image" />
                        <div class="card-body">
                          <p>
                            <strong>{{ product.product_name }}</strong>
                          </p>
                          <p>$ {{ product.selling_price }}</p>
                          <span
                            v-if="product.product_quantity >= 1"
                            class="badge badge-success"
                            >Aviable {{ product.product_quantity }}</span
                          >
                          <span v-else="" class="badge badge-danger"
                            >Stockout</span
                          >
                        </div>
                      </div>
                    </button>
                  </div>
                </div>
              </div>
              <div
                class="tab-pane fade"
                id="profile"
                role="tabpanel"
                aria-labelledby="profile-tab"
              >
                <div class="row">
                  <div
                    class="col-lg-3 col-md-3 col-sm-4 col-4"
                    v-for="product in getfilterSearch"
                    :key="product.id"
                  >
                    <button
                      class="btn btn-sm"
                      @click.prevent="addToCart(product.id)"
                    >
                      <div class="card mt-3">
                        <img class="card-img-top" :src="product.image" />
                        <div class="card-body">
                          <p>
                            <strong>{{ product.product_name }}</strong>
                          </p>
                          <p>$ {{ product.selling_price }}</p>
                          <span
                            v-if="product.product_quantity >= 1"
                            class="badge badge-success"
                            >Aviable {{ product.product_quantity }}</span
                          >
                          <span v-else="" class="badge badge-danger"
                            >Stockout</span
                          >
                        </div>
                      </div>
                    </button>
                  </div>
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
      customer_id:'',
      pay:'',
      due:'',
      payby:'',

      products: [],
      categories: "",
      getproducts: [],
      searchTerm: "",
      customers: "",
      showcarts: [],
      vats: "",
    };
  },
  computed: {
    filterSearch() {
      return this.products.filter((product) => {
        return product.product_name.match(this.searchTerm);
      });
    },
    getfilterSearch() {
      return this.getproducts.filter((getproduct) => {
        return getproduct.product_name.match(this.searchTerm);
      });
    },
    qty() {
      let sum = 0;
      for (let i = 0; i < this.showcarts.length; i++) {
        sum += parseFloat(this.showcarts[i].pro_quantity);
      }
      return sum;
    },
    subtotal() {
      let sum = 0;
      for (let i = 0; i < this.showcarts.length; i++) {
        sum += parseFloat(this.showcarts[i].sub_total);
      }
      return sum;
    },
  },
  methods: {
    // cart add function
    addToCart(id) {
      axios
        .get("/api/cart/add/" + id)
        .then(() => {
          Reload.$emit("afterAdd");
          Notification.cart_success();
        })
        .catch("error");
    },
    showCart() {
      axios
        .get("/api/show/cart/")
        .then(({ data }) => (this.showcarts = data))
        .catch(console.log("hoissssssssssssssssss"));
    },
    deleteFormCart(id) {
      axios
        .get("/api/delete/cart/" + id)
        .then(() => {
          Reload.$emit("afterAdd");
          Notification.cart_delete();
        })
        .catch();
    },
    increment(id) {
      axios
        .get("/api/increment/" + id)
        .then(() => {
          Reload.$emit("afterAdd");
          Notification.cart_success();
        })
        .catch();
    },
    decrement(id) {
      axios
        .get("/api/decrement/" + id)
        .then(() => {
          Reload.$emit("afterAdd");
          Notification.cart_success();
        })
        .catch();
    },
    // cart add function

    // vat
    vat() {
      axios
        .get("/api/vat")
        .then(({ data }) => (this.vats = data))
        .catch();
    },
    // vat

    // order form start
    orderDone(){
      let total = this.subtotal*this.vats.vat / 100 + this.subtotal;
      var data = {qty:this.qty, subtotal:this.subtotal, customer_id:this.customer_id, payby:this.payby, pay:this.pay, due:this.due, vat:this.vats.vat, total:total}

      axios.post('/api/orderdone/', data)
           .then(() => {
               Notification.create();
               this.$router.push({name: 'order'});
            })
            .catch()
    },
    // order form end

    allProduct() {
      axios
        .get("/api/product")
        .then(({ data }) => (this.products = data))
        .catch(console.log("error"));
    },
    allcategories() {
      axios
        .get("/api/category")
        .then(({ data }) => (this.categories = data))
        .catch(console.log("error"));
    },
    allCustomers() {
      axios
        .get("/api/customer/")
        .then(({ data }) => (this.customers = data))
        .catch(console.log("error"));
    },
    subproduct(id) {
      axios
        .get("/api/get/product/" + id)
        .then(({ data }) => (this.getproducts = data))
        .catch();
    },
  },
  mounted() {
    this.allProduct();
    this.allcategories();
    this.allCustomers();
    this.showCart();
    Reload.$on("afterAdd", () => {
      this.showCart();
    });
    this.vat();
  },
};
</script>

<style scoped>
  #searchTerm {
    width: 550px;
    margin-top: 15px;
    margin-bottom: 15px;
  }
  .cartInput {
    width: 30px;
    border: none;
    background-color: #f1f1f1;
    text-align: center;
  }
</style>
