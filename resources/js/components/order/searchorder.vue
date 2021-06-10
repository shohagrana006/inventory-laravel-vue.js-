<template>
  <div>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="row mt-3">
          <div class="col-lg-4 ml-4">
            <router-link to="/order" class="btn btn-primary"
              >Today Order</router-link
            >
          </div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-4">
              <div class="">
                <h1 class="h4 text-gray-900 mb-4 text-center"><u>Search Order</u></h1>
              </div>
              <form class="user" @submit.prevent="searchorder">
                <div class="form-group row">
                  <div class="col-sm-12 mb-3 mb-sm-0">
                  <label>Here Search Order</label>
                    <input type="date" class="form-control form-control-user"
                      id="exampleFirstName" v-model="date"/>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">Search</button>
              </form>
              <hr />
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
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Sub Total</th>
                        <th>Vat</th>
                        <th>Total</th>
                        <th>Pay</th>
                        <th>Due</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="order in orders" :key="order.id">
                        <td>{{order.name}}</td>
                        <td>{{order.qty}}</td>
                        <td>{{order.sub_total}} $</td>
                        <td>{{order.vat}} %</td>
                        <td>{{order.total}} $</td>
                        <td>{{order.pay}} $</td>
                        <td>{{order.due}} $</td>
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
      this.$router.push("/");
    }
  },
  data() {
    return {
      date:'',
      orders:{},
    };
  },
  methods: {
    searchorder() {
        let data = {date:this.date};
      axios
        .post("/api/search/order/", data)
        .then(({data}) => (this.orders = data))
        .catch();
    },
  },
};
</script>


<style>
.resize_int {
  padding-top: 15px !important;
  padding-bottom: 35px !important;
}
</style>
