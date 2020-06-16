<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Categoreis Table</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newModal">
                Add new categore
                <i class="fas fa-catego-tag"></i>
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
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for=" catego in categos.data" :key="catego.id">
                  <td>{{catego.id}}</td>
                  <td>{{catego.name}}</td>

                  <td>
                    <button @click="editModal(catego)" class="btn btn-edit btn-info btn-sm">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button
                      @click="deletecatego(catego.id)"
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
            <pagination :data="categos" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="addNewCategoModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewCategoModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="editMode" class="modal-title" id="addNewCategoModalLabel">Edit catego</h5>
            <h5 v-show="!editMode" class="modal-title" id="addNewCategoModalLabel">Add New catego</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form @submit.prevent="(editMode ? updatecatego() : createcatego())">
              <div class="form-group">
                <input
                  v-model="form.name"
                  type="text"
                  name="name"
                  placeholder="name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
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
export default {
  data() {
    return {
      editMode: false,
      categos: {},
      // Create a new form instance
      form: new Form({
        id: "",
        name: ""
      })
    };
  },
  methods: {
    getResults: function(page = 1) {
      axios.get("api/catego?page=" + page).then(respnse => {
        this.categos = respnse.data;
      });
    },
    editModal: function(catego) {
      (this.editMode = true), this.form.reset();
      $("#addNewCategoModal").modal("show");
      this.form.fill(catego);
    },
    newModal: function() {
      (this.editMode = false), this.form.reset();
      $("#addNewCategoModal").modal("show");
    },
    loadcategos: function() {
      axios.get("api/catego").then(({ data }) => (this.categos = data));
    },
    updatecatego: function() {
      this.$Progress.start();
      this.form
        .put("api/catego/" + this.form.id)
        .then(() => {
          $("#addNewCategoModal").modal("hide");
          Swal.fire("Updated!", "Your file has been updated.", "success");
          this.$Progress.finish();
          Fire.$emit("AfterCreate");
        })
        .catch(() => {});
    },
    createcatego: function() {
      this.$Progress.start();
      this.form
        .post("api/catego")
        .then(() => {
          $("#addNewCategoModal").modal("hide");
          Toast.fire({
            icon: "success",
            title: "catego added successfully"
          });
          this.$Progress.finish();
          Fire.$emit("AfterCreate");
        })
        .catch(() => {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!"
          });
        });
    },
    prino: function() {
      window.print();
    },
    deletecatego: function(id) {
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
          .delete("api/catego/" + id)
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
    }
  },
  created() {
    this.loadcategos();

    this.loadcategos();
    Fire.$on("AfterCreate", () => {
      this.loadcategos();
    });
  }
};
</script>

