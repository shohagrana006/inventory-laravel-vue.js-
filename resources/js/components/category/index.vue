<template>
  <div>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="row my-3">
          <div class="col-lg-4 ml-4">
            <router-link to="/add/category" class="btn btn-primary"
              >Add Category</router-link
            >
          </div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row">
          <!-- DataTales Example -->
          <div class="col-lg-12">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">All Category</h6>
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
                        <th>Serial No.</th>
                        <th>Category Name</th>
                        <th>Create</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="category in filterSearch" :key="category.id">
                        <td>{{ category.id }}</td>
                        <td>{{ category.category_name }}</td>
                        <td>{{ category.created_at }}</td>
                        <td>
                          <router-link
                            :to="{
                              name: 'editcategory',
                              params: { id: category.id },
                            }"
                            class="btn btn-sm btn-primary"
                            >Edit</router-link
                          >
                          <a
                            @click="categoryDelete(category.id)"
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
      this.$router.push({ name: "/" });
    }
  },
  data() {
    return {
      categories: [],
      searchTerm: "",
    };
  },
  computed: {
    filterSearch() {
      return this.categories.filter((category) => {
        return category.category_name.match(this.searchTerm);
      });
    },
  },
  methods: {
    allCategory() {
      axios
        .get("/api/category")
        .then(({ data }) => (this.categories = data))
        .catch(console.log("error"));
    },
    categoryDelete(id) {
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
            .delete("/api/category/" + id)
            .then(() => {
              this.categories = this.categories.filter((category) => {
                return category.id != id;
              });
            })
            .catch(() => {
              this.$router.push("/category");
            });
          Swal.fire("Deleted!", "Your file has been deleted.", "success");
        }
      });
    },
  },
  created() {
    this.allCategory();
  },
};
</script>


<style scoped>
#searchTerm {
  width: 350px;
  margin-bottom: 15px;
}
</style>
