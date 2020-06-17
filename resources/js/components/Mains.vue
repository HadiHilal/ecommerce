<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12 mt-5">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Our Categories</h3>

            <div class="card-tools">
              <button
                type="button"
                class="btn btn-tool"
                data-card-widget="collapse"
                data-toggle="tooltip"
                title="Collapse"
              >
                <i class="fas fa-minus"></i>
              </button>
              <button
                type="button"
                class="btn btn-tool"
                data-card-widget="remove"
                data-toggle="tooltip"
                title="Remove"
              >
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body" style="display: block;">
            <div class="row">
              <div v-for="catego in categos" :key="catego.id">
                <span class="col-md-2">{{ catego.name }}</span>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
      </div>

      <div class="col-md-12 mt-5">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Our Product</h3>

            <div class="card-tools">
              <button
                type="button"
                class="btn btn-tool"
                data-card-widget="collapse"
                data-toggle="tooltip"
                title="Collapse"
              >
                <i class="fas fa-minus"></i>
              </button>
              <button
                type="button"
                class="btn btn-tool"
                data-card-widget="remove"
                data-toggle="tooltip"
                title="Remove"
              >
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body" style="display: block;">
            <div class="row">
              <div
                class="col-md-4 col-sm-6 mt-5"
                v-for="product in products.data"
                :key="product.id"
              >
                <div class="col-12">
                  <img
                    :src="product.img?'/storage/'+product.img:'/img/products/prod-1.jpg'"
                    class="product-image"
                    alt="Product Image"
                  />
                </div>

                <div class="col-12 col-sm-6">
                  <h3 class="my-3">{{ product.name }}</h3>
                  <p>{{ product.description }}</p>
                  <hr />
                  <h4>Available Colors</h4>
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-default text-center active">
                      <input
                        type="radio"
                        name="color_option"
                        id="color_option1"
                        autocomplete="off"
                        checked
                      />
                      Green
                      <br />
                      <i class="fas fa-circle fa-2x text-green"></i>
                    </label>
                    <label class="btn btn-default text-center">
                      <input type="radio" name="color_option" id="color_option2" autocomplete="off" />
                      Blue
                      <br />
                      <i class="fas fa-circle fa-2x text-blue"></i>
                    </label>

                    <label class="btn btn-default text-center">
                      <input type="radio" name="color_option" id="color_option4" autocomplete="off" />
                      Red
                      <br />
                      <i class="fas fa-circle fa-2x text-red"></i>
                    </label>
                  </div>

                  <h4 class="mt-3">
                    Size
                    <small>Please select one</small>
                  </h4>
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-default text-center">
                      <input type="radio" name="color_option" id="color_option1" autocomplete="off" />
                      <span class="text-xl">S</span>
                      <br />Small
                    </label>
                    <label class="btn btn-default text-center">
                      <input type="radio" name="color_option" id="color_option1" autocomplete="off" />
                      <span class="text-xl">M</span>
                      <br />Medium
                    </label>
                    <label class="btn btn-default text-center">
                      <input type="radio" name="color_option" id="color_option1" autocomplete="off" />
                      <span class="text-xl">L</span>
                      <br />Large
                    </label>
                  </div>

                  <div class="bg-gray py-2 px-3 mt-4">
                    <h2 class="mb-0">${{ product.price }}</h2>
                    <h4 class="mt-0">
                      <small>Ex Tax: ${{ product.price }}</small>
                    </h4>
                  </div>

                  <div class="mt-4">
                    <div
                      class="btn btn-primary btn-lg btn-flat"
                      id="addCart"
                      @click="addcart(product)"
                    >
                      <i class="fas fa-cart-plus fa-lg mr-2"></i>
                      Add to Cart
                    </div>
                    <div class="btn btn-warning btn-lg btn-flat mt-2" @click="rateModel(product)">
                      <i class="fas fa-star fa-lg mr-2"></i>
                      Rate the product
                    </div>
                    <div class="btn btn-default btn-lg btn-flat mt-2" @click="newModal(product)">
                      <i class="fas fa-credit-card fa-lg mr-2"></i>
                      Buy it now
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <pagination :data="products" @pagination-change-page="getResults"></pagination>
          </div>

          <!-- /.card-body -->
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="addNewOrderModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewOrderModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addNewOrderModalLabel">Buy product {{product_title}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form @submit.prevent="createOrder">

                <p>
                 {{product.description}}
             </p>

             <p>
                 <span>${{product_price}}</span>
             </p>
              <div class="form-group">
                <label for="card">card</label>
                <input
                  v-model="form.card"
                  type="integer"
                  name="card"
                  placeholder="card number"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('card') }"
                />
                <has-error :form="form" field="card"></has-error>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Buy</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="addCart"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewOrderModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addNewOrderModalLabel">Buy product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div v-for="(cart , n) in carts" :key="cart.id">
              <span>{{ cart.name }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- rate model -->
    <div
      class="modal fade"
      id="rateModel"
      tabindex="-1"
      role="dialog"
      aria-labelledby="rateModelLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="rateModellLabel">Rate Us</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <star-rating
              v-bind:increment="0.5"
              v-model="form.count"
              name="count"
              v-bind:max-rating="5"
              inactive-color="#dedede"
              active-color="#e0ca00"
              v-bind:star-size="40"
            ></star-rating>
            <br />
                <label for="comment">Comment</label>
                <input
                  v-model="form.comment"
                  type="text"
                  name="comment"
                  placeholder="optional"
                  class="form-control"
                />
                  <br />
            <button class="btn btn-success" @click="setrating">publish</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { parse } from "querystring";
export default {
  data() {
    return {
      products: {},
      product: {
        id: "",
        name: ""
      },
      categos: {},
      orders: {},
      carts: [],
      cardd: {
        id: "",
        name: ""
      },
      badge: 0,
      product_title:'',
      product_price:'',
      form: new Form({
        product_id: "",
        card: "",
        count: "",
        user_id: "",
        comment: ""

      })
    };
  },
  methods: {
    viewcart: function() {
      if (localStorage.getItem("carts")) {
        this.carts = JSON.parse(localStorage.getItem("carts"));
        this.badge = this.carts.length;
      }
    },
    addcart: function(product) {
      this.cardd.id = product.id;
      this.cardd.name = product.name;
      this.carts.push(this.cardd);
      this.cardd = {};
      this.storecart();
    },
    remcart: function(props) {
      this.carts.splice(pro, 1);
      this.storecart();
    },
    storecart: function() {
      let parsed = JSON.stringify(this.carts);
      localStorage.setItem("carts", parsed);
      this.viewcart();
    },
    getproduct: function() {
      axios.get("api/getproduct ").then(({ data }) => {
        this.products = data;
      });
    },
    getcatego: function() {
      axios.get("api/getcatego ").then(({ data }) => {
        this.categos = data;
      });
    },
    getResults: function(page = 1) {
      axios.get("api/getproduct?page=" + page).then(respnse => {
        this.products = respnse.data;
      });
    },
    newModal: function(product) {
        this.form.product_id = product.id;
        this.product_title=product.name;
        this.product_price=product.price;
      $("#addNewOrderModal").modal("show");
    },
    rateModel: function(product) {

        this.form.reset();
      $("#rateModel").modal("show");
       this.form.fill(product);
       this.form.product_id=product.id;
    },
    createOrder: function() {
      this.$Progress.start();
      this.form.post("api/order").then(({ data }) => {
        Swal.fire("Congraution!", "Your order done.", "success");
         this.form.product_id = null;
        this.product_title='';
        this.$Progress.finish();
          $("#addNewOrderModal").modal("hide");
      });
    },
    setrating: function() {
      this.$Progress.start();
      this.form.post("api/review").then(({ data }) => {
        Swal.fire("Thanks!", "The product rated.", "success");
        this.$Progress.finish();
         $("#rateModel").modal("hide");
      });
    }
  },
  created() {
    this.getproduct();
    this.getcatego();
    this.viewcart();
    setInterval(() => this.getproduct(), 3000);
  }
};
</script>
