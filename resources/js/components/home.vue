<template>
  <div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 card text-left">
      <h1 class="h3 mb-0 text-gray-800 card-header">Dashboard</h1>
    </div>
    <!-- Content Row -->
    <div class="row">
      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div
                  class="text-xs font-weight-bold text-primary text-uppercase mb-1"
                >
                 Today Total Sell
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                  $ {{todaysell}}
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-calendar fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div
                  class="text-xs font-weight-bold text-success text-uppercase mb-1"
                >
                  Today Income
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                  $ {{todayincome}}
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div
                  class="text-xs font-weight-bold text-danger text-uppercase mb-1"
                >
                  Today due
                </div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                      $ {{todaydue}}
                    </div>
                  </div>
                  <div class="col">
                    <div class="progress progress-sm mr-2">
                      <div
                        class="progress-bar bg-info"
                        role="progressbar"
                        style="width: 50%"
                        aria-valuenow="50"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Pending Requests Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div
                  class="text-xs font-weight-bold text-warning text-uppercase mb-1"
                >
                  Today Expense Ammount
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{todayexpense}}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-comments fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="col-lg-12">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Products Out of Stock</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" width="100%" cellspacing="0">
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
                      <tr v-for="product in products" :key="product.id">
                        <td>{{ product.product_name }}</td>
                        <td>{{ product.product_code }}</td>
                        <td>
                          <img :src="product.image" height="50" width="50" alt=""/>
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
                          <router-link :to="{ name: 'editstock', params: { id: product.id },}"
                            class="btn btn-sm btn-warning">Update Stock</router-link>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>



    </div>
    <!-- Content Row -->
  </div>
</template>

<script type="text/javascript">
export default {
  mounted() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }
  },
  data(){
    return{
      todaysell:'',
      todayincome:'',
      todaydue:'',
      todayexpense:'',
      products:'',
    }
  },
  mounted(){
   this.todaySell();
   this.todayIncome();
   this.todayDue();
   this.todayExpense();
   this.stockOut();
  },
  methods:{
     todaySell(){
      axios
        .get("/api/today/sell/")
        .then(({data}) => (this.todaysell = data))
        .catch();
    },
     todayIncome(){
      axios
        .get("/api/today/income/")
        .then(({data}) => (this.todayincome = data))
        .catch();
    },
     todayDue(){
      axios
        .get("/api/today/due/")
        .then(({data}) => (this.todaydue = data))
        .catch();
    },
     todayExpense(){
      axios
        .get("/api/today/expense/")
        .then(({data}) => (this.todayexpense = data))
        .catch();
    },
     stockOut(){
      axios
        .get("/api/today/stockout/")
        .then(({data}) => (this.products = data))
        .catch();
    },

  },



};
</script>

<style type="text/css">
</style>