<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Reviews Table</h3>

            <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 150px;">
                <input
                  type="text"
                  name="table_search"
                  class="form-control float-right"
                  placeholder="Search"
                />

                <div class="input-group-append">
                  <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>User</th>
                  <th>Product</th>
                  <th>Date</th>
                  <th>Review</th>
                  <th>Comment</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="review in reviews.data" :key="review.id">
                  <td>{{review.id}}</td>
                  <td>{{review.user.name}}</td>
                  <td>{{review.product.name}}</td>
                  <td>{{review.created_at | hmDate}}</td>
                  <td>
                    <star-rating
                      v-model="review.count"
                      v-bind:max-rating="5"
                      inactive-color="#dedede"
                      active-color="#e0ca00"
                      v-bind:star-size="40"
                    ></star-rating>
                  </td>
                  <td>{{review.comment}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      reviews: {},
      form: new Form({
        id: "",
        user_id: "",
        product_id: "",
        count: "",
        created_at: ""
      })
    };
  },
  methods: {
    loadreviews: function() {
      axios.get("api/review").then(({ data }) => (this.reviews = data));
    },

  },
  created() {
    this.loadreviews();
    setTimeout(() => {
      this.loadreviews();
    }, 5000);
  }
};
</script>
