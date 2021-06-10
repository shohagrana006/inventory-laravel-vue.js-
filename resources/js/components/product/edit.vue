<template>
  <div>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="row mt-3">
          <div class="col-lg-4 ml-4">
            <router-link to="/product" class="btn btn-primary"
              >All Product</router-link
            >
          </div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-4">
              <div class="">
                <h1 class="h4 text-gray-900 mb-4">Update Product</h1>
              </div>
              <form
                class="user"
                @submit.prevent="productUpdate"
                enctype="multipart/form-data"
              >
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">Category Name:</label>
                    <select class="form-control" v-model="form.category_id">
                      <option
                        v-for="category in categories"
                        :value="category.id"
                      >
                        {{ category.category_name }}
                      </option>
                    </select>
                    <small class="text-danger" v-if="errors.category_id">{{
                      errors.category_id[0]
                    }}</small>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">Supplier Name:</label>
                    <select class="form-control" v-model="form.supplier_id">
                      <option
                        v-for="supplier in suppliers"
                        :value="supplier.id"
                      >
                        {{ supplier.name }}
                      </option>
                    </select>
                    <small class="text-danger" v-if="errors.supplier_id">{{
                      errors.supplier_id[0]
                    }}</small>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="exampleFirstName"
                      placeholder="Product Name"
                      v-model="form.product_name"
                    />
                    <small class="text-danger" v-if="errors.product_name">{{
                      errors.product_name[0]
                    }}</small>
                  </div>
                  <div class="col-sm-6">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="exampleInputEmail"
                      placeholder="Product Code"
                      v-model="form.product_code"
                    />
                    <small class="text-danger" v-if="errors.product_code">{{
                      errors.product_code[0]
                    }}</small>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input
                      type="date"
                      class="form-control form-control-user resize_int"
                      id="exampleInputPassword"
                      placeholder="Buying Date "
                      v-model="form.buying_date"
                    />
                    <small class="text-danger" v-if="errors.buying_date">{{
                      errors.buying_date[0]
                    }}</small>
                  </div>
                  <div class="col-sm-6">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="exampleRepeatPassword"
                      placeholder="Product Quantity"
                      v-model="form.product_quantity"
                    />
                    <small class="text-danger" v-if="errors.product_quantity">{{
                      errors.product_quantity[0]
                    }}</small>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-4 mb-3 mb-sm-0">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="exampleInputPassword"
                      placeholder="Root"
                      v-model="form.root"
                    />
                    <small class="text-danger" v-if="errors.root">{{
                      errors.root[0]
                    }}</small>
                  </div>
                  <div class="col-sm-4">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="exampleRepeatPassword"
                      placeholder="Buying Price"
                      v-model="form.buying_price"
                    />
                    <small class="text-danger" v-if="errors.buying_price">{{
                      errors.buying_price[0]
                    }}</small>
                  </div>
                  <div class="col-sm-4">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="exampleRepeatPassword"
                      placeholder="Selling Price"
                      v-model="form.selling_price"
                    />
                    <small class="text-danger" v-if="errors.selling_price">{{
                      errors.selling_price[0]
                    }}</small>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input
                      type="file"
                      class="form-control form-control-user resize_int"
                      id="exampleInputPassword"
                      placeholder="Choose Image"
                      @change="onFileSelected"
                    />
                    <small class="text-danger" v-if="errors.image">{{
                      errors.image[0]
                    }}</small>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <img :src="form.image" height="50" width="50" alt="" />
                  </div>
                </div>
                <button
                  type="submit"
                  class="btn btn-primary btn-user btn-block"
                >
                  Update Product
                </button>
              </form>
              <hr />
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
      form: {
        category_id: "",
        supplier_id: "",
        product_name: "",
        product_code: "",
        buying_date: "",
        product_quantity: "",
        root: "",
        buying_price: "",
        selling_price: "",
        image: "",
        new_image: "",
      },
      errors: {},
      categories: {},
      suppliers: {},
    };
  },
  mounted() {
    let id = this.$route.params.id;
    axios
      .get("/api/product/" + id)
      .then(({ data }) => (this.form = data))
      .catch(console.log("error"));

    axios.get("/api/category/").then(({ data }) => (this.categories = data));
    axios.get("/api/supplier/").then(({ data }) => (this.suppliers = data));
  },
  methods: {
    onFileSelected(event) {
      let file = event.target.files[0];
      if (file.size > 1048770) {
        Notification.img_validation();
      } else {
        let reader = new FileReader();
        reader.onload = (event) => {
          this.form.new_image = event.target.result;
          console.log(event.target.result);
        };
        reader.readAsDataURL(file);
      }
    },
    productUpdate() {
      let id = this.$route.params.id;
      axios
        .patch("/api/product/" + id, this.form)
        .then(() => {
          this.$router.push({ name: "product" });
          Notification.create();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
  },
  created() {
    axios.get("/api/category/").then(({ data }) => (this.categories = data));
    axios.get("/api/supplier/").then(({ data }) => (this.suppliers = data));
  },
};
</script>

<style>
.resize_int {
  padding-top: 15px !important;
  padding-bottom: 35px !important;
}
</style>
