<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Products Table</h3>
            <div class="card-tools">
              <button class="btn btn-success" @click="newModal">
                Add new product
                <i class="fab fa-shopify"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>product</th>
                  <th>Descripition</th>
                  <th>Price</th>
                  <th>Status</th>
                   <th>Img</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for=" product in products.data" :key="product.id">
                  <td>{{product.id}}</td>
                  <td>{{product.name}}</td>
                  <td>{{product.catego.name}}</td>
                  <td>{{product.description}}</td>
                  <td>${{product.price}}</td>
                  <td><img :src="product.img?'/storage/'+product.img:'/img/products/prod-1.jpg'" height="40px" width="40px" alt=""></td>
                  <td v-if="product.show">Shown</td>
                  <td v-if="!product.show">Hidden</td>

                  <td>
                    <button @click="editModal(product)" class="btn btn-edit btn-info btn-sm">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button
                      @click="deleteproduct(product.id)"
                      class="btn btn-delete btn-danger btn-sm"
                    >
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="products" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="addNewproductModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewproductModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="editMode" class="modal-title" id="addNewproductModalLabel">Edit product</h5>
            <h5 v-show="!editMode" class="modal-title" id="addNewproductModalLabel">Add New product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form @submit.prevent="(editMode ? updateproduct() : createproduct())">
              <div class="form-group">
                <label for="name">Name</label>
                <input
                  v-model="form.name"
                  type="text"
                  name="name"
                  placeholder="name the product"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
              </div>

              <div class="form-group">
                <label for="catego_id">choose the categore name</label>
                <select
                  name="catego_id"
                  v-model="form.catego_id"
                  id="catego_id"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('catego_id') }"
                >
                  <option
                    v-for=" catego in categos.data"
                    :key="catego.id"
                    :value="catego.id"
                  >{{ catego.name }}</option>
                </select>
                <has-error :form="form" field="type"></has-error>
              </div>
              <div class="form-group">
                <label for="price">Price</label>
                <input
                  v-model="form.price"
                  type="text"
                  name="price"
                  placeholder="price the product"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('price') }"
                />
                <has-error :form="form" field="name"></has-error>
              </div>
              <div class="form-group">
                <textarea
                  v-model="form.description"
                  name="description"
                  id="description"
                  placeholder="Short description for product (Optional)"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('description') }"
                ></textarea>
                <has-error :form="form" field="description"></has-error>
              </div>

              <div class="form-group">
                <label for="inputPhoto" class="col-form-label">img</label>
                <div class="form-control">
                  <input type="file" @change="onImageChange" name="form.img" id="inputPhoto" />
                </div>
              </div>

              <div class="form-group">
                <label for="show">do you want to show it ?</label>
                <select
                  name="show"
                  v-model="form.show"
                  id="show"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('show') }"
                >
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>
                <has-error :form="form" field="type"></has-error>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
 const objectToFormData = window.objectToFormData

export default {
  data() {
    return {
      editMode: false,
      products: {},
      categos: {},
      // Create a new form instance
      form: new Form({
        id: "",
        name: "",
        catego_id: "",
        description: "",
        show: "",
        img: "",
        price: ""
      })
    };
  },
  methods: {
    getResults: function(page = 1) {
      axios.get("api/product?page=" + page).then(respnse => {
        this.products = respnse.data;
      });
    },
    editModal: function(product) {
      (this.editMode = true), this.form.reset();
      $("#addNewproductModal").modal("show");
      this.form.fill(product);
    },
    newModal: function() {
      (this.editMode = false), this.form.reset();
      $("#addNewproductModal").modal("show");
    },
    loadproducts: function() {
      axios.get("api/product").then(({ data }) => (this.products = data));
    },
    loadcategos: function() {
      axios.get("api/catego").then(({ data }) => (this.categos = data));
    },
    updateproduct: function() {
      this.$Progress.start();
      this.form
        .put("api/product/" + this.form.id)
        .then(() => {
          $("#addNewproductModal").modal("hide");
          Swal.fire("Updated!", "Your file has been updated.", "success");
          this.$Progress.finish();
          Fire.$emit("AfterCreate");
        })
        .catch(() => {});
    },
    createproduct: function() {
      this.$Progress.start();
      this.form
        .submit('post',"api/product",{
              // Transform form data to FormData
              transformRequest: [function (data, headers) {
                return objectToFormData(data)
              }],

              onUploadProgress: e => {
                // Do whatever you want with the progress event
                // console.log(e)
              }
            })
        .then(() => {
          $("#addNewproductModal").modal("hide");
          Toast.fire({
            icon: "success",
            title: "product added successfully"
          });
          this.$Progress.finish();
          Fire.$emit("AfterCreate");
        })
        .catch((e) => {
            console.log(e)
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!"
          });
        });
    },
    deleteproduct: function(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        this.form
          .delete("api/product/" + id)
          .then(() => {
            if (result.value) {
              Swal.fire("Deleted!", "Your file has been deleted.", "success");
              Fire.$emit("AfterCreate");
            }
          })
          .catch(() => {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Something went wrong!"
            });
          });
      });
    },
    onImageChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      console.log(files);
      if (!files.length) return;
      this.form.img=files[0]
      this.createImage(files[0]);
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = e => {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },

  },
  created() {
    this.loadproducts();
    this.loadcategos();
    Fire.$on("AfterCreate", () => {
      this.loadproducts();
    });;

  }
};
</script>
