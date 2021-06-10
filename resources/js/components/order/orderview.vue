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
          <div class="col-lg-6">
            <div class="p-4">
              <div class="card-header">
                <h1 class="h4 text-gray-900 m-auto mb-4">Order details</h1>
              </div>
              <div class="card-body">  

                <ul class="list-group">
                  <li class="list-group-item"><b>Name: </b> {{orders.name}}</li>  
                  <li class="list-group-item"><b>Phone: </b> {{orders.phone}}</li>  
                  <li class="list-group-item"><b>Address: </b> {{orders.address}}</li>  
                  <li class="list-group-item"><b>Date: </b> {{orders.order_date}}</li>  
                  <li class="list-group-item"><b>Pay Through: </b> {{orders.payby}}</li>  
                </ul>

              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="p-4">
              <div class="card-header">
                <h1 class="h4 text-gray-900 m-auto mb-4">Order details</h1>
              </div>
              <div class="card-body">  

                <ul class="list-group">
                  <li class="list-group-item"><b>Sub Total: </b> {{orders.sub_total}} $</li>  
                  <li class="list-group-item"><b>Vat: </b> {{orders.vat}} %</li>  
                  <li class="list-group-item"><b>Total: </b> {{orders.total}} $</li>  
                  <li class="list-group-item"><b>Pay Ammount: </b> {{orders.pay}} $</li>  
                  <li class="list-group-item"><b>Due Ammount: </b> {{orders.due}} $</li>  
                </ul>

              </div>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-lg-12">
            <div class="p-4">
              <div class="card-header">
                <h1 class="h4 text-gray-900 mb-4">Order details</h1>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered"
                    width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Product Name</th>
                        <th>Product Code</th>
                        <th>Image</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="detail in details" :key="detail.id">
                        <td>{{detail.product_name}}</td>
                        <td>{{detail.product_code}}</td>
                        <td><img :src="'/'+detail.image" width="60"/></td>
                        <td>{{detail.pro_quantity}}</td>
                        <td>{{detail.pro_price}} $</td>
                        <td>{{detail.sub_total}} $</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
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
      errors: {},
      orders: {},
      details: {},
    };
  },
  mounted() {
    let id = this.$route.params.id;
    axios
      .get("/api/order/details/" + id)
      .then(({ data }) => (this.orders = data))
      .catch(console.log("error"));

    axios
      .get("/api/order/orderdetails/" + id)
      .then(({ data }) => (this.details = data))
      .catch(console.log("error"));

   
  },
  methods: {},
};
</script>

<style>
.resize_int {
  padding-top: 15px !important;
  padding-bottom: 35px !important;
}
#searchTerm{
  width: 550px;
  margin-bottom: 15px;
}
</style>
