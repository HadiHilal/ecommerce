<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Orders Table</h3>

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
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="order in orders.data" :key="order.id">
                  <td>{{order.id}}</td>
                  <td>{{order.user.name}}</td>
                  <td>{{order.product.name}}</td>
                  <td>{{order.created_at | hmDate}}</td>
                  <td>
                    <router-link
                      :to="{ name: 'orders', params: { id: order.id }}"
                      class="btn btn-info"
                    >show more</router-link>
                  </td>
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
      orders: {},
      form: new Form({
        id: "",
        user_id: "",
        product_id: "",
        card: "",
        created_at: ""
      })
    };
  },
  methods: {
    loadOrders: function() {
      axios.get("api/order").then(({ data }) => (this.orders = data));
    }
  },
  created() {
    this.loadOrders();
    setTimeout(() => {
      this.loadOrders();
    }, 5000);
  }
};
</script>
