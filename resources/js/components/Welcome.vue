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
                    src="../../../public/img/products/prod-1.jpg"
                    width="40%"
                    class="product-image"
                    alt="Product Image"
                  />
                </div>

                <div class="col-12 col-sm-6">
                  <h3 class="my-3">{{ product.name }}</h3>

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
                    <div class="btn btn-primary btn-lg btn-flat" @click="loginfo">
                      <i class="fas fa-cart-plus fa-lg mr-2"></i>
                      Add to Cart
                    </div>

                    <div class="btn btn-default btn-lg btn-flat" @click="loginfo">
                      <i class="fas fa-credit-card fa-lg mr-2"></i>
                      Buy
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
  </div>
</template>

<script>
export default {
  data() {
    return {
      products: {},
      categos: {}
    };
  },
  methods: {
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
    loginfo: function() {
      Swal.fire({
        title: " you should login ",
        showClass: {
          popup: "animate__animated animate__fadeInDown"
        },
        hideClass: {
          popup: "animate__animated animate__fadeOutUp"
        }
      });
    },
    getResults: function(page = 1) {
      axios.get("api/getproduct?page=" + page).then(respnse => {
        this.products = respnse.data;
      });
    }
  },
  created() {
    this.getproduct();
    this.getcatego();
    setInterval(() => this.getproduct(), 3000);
  }
};
</script>
