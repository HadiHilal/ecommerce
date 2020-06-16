<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>

            <div class="card-tools">
              <button class="btn btn-success" @click="newModal">
                Add new user
                <i class="fas fa-user-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>User</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Date Register</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for=" user in users.data" :key="user.id">
                  <td>{{user.id}}</td>
                  <td>{{user.name}}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.type | upText}}</td>
                  <td>{{user.created_at | hmDate}}</td>

                  <td>
                    <button @click="editModal(user)" class="btn btn-edit btn-info btn-sm">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button @click="deleteUser(user.id)" class="btn btn-delete btn-danger btn-sm">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="users" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="addNewUserModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewUserModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="editMode" class="modal-title" id="addNewUserModalLabel">Edit User</h5>
            <h5 v-show="!editMode" class="modal-title" id="addNewUserModalLabel">Add New User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form @submit.prevent="(editMode ? updateUser() : createUser())">
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

              <div class="form-group">
                <input
                  v-model="form.email"
                  type="email"
                  name="email"
                  placeholder="Email Address"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                />
                <has-error :form="form" field="email"></has-error>
              </div>

              <div class="form-group">
                <select
                  name="type"
                  v-model="form.type"
                  id="type"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('type') }"
                >
                  <option value>Select User Role</option>
                  <option value="admin">Admin</option>
                  <option value="user">Standard User</option>
                </select>
                <has-error :form="form" field="type"></has-error>
              </div>

              <div class="form-group">
                <input
                  v-model="form.password"
                  type="password"
                  name="password"
                  id="password"
                  placeholder="Password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                />
                <has-error :form="form" field="password"></has-error>
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
      users: {},
      // Create a new form instance
      form: new Form({
        id: "",
        name: "",
        email: "",
        pasword: "",
        type: ""
      })
    };
  },
  methods: {
    getResults: function(page = 1) {
      axios.get("api/user?page=" + page).then(respnse => {
        this.users = respnse.data;
      });
    },
    editModal: function(user) {
      (this.editMode = true), this.form.reset();
      $("#addNewUserModal").modal("show");
      this.form.fill(user);
    },
    newModal: function() {
      (this.editMode = false), this.form.reset();
      $("#addNewUserModal").modal("show");
    },
    loadUsers: function() {
      axios.get("api/user").then(({ data }) => (this.users = data));
    },
    updateUser: function() {
      this.$Progress.start();
      this.form
        .put("api/user/" + this.form.id)
        .then(() => {
          $("#addNewUserModal").modal("hide");
          Swal.fire("Updated!", "Your file has been updated.", "success");
          this.$Progress.finish();
          Fire.$emit("AfterCreate");
        })
        .catch(() => {});
    },
    createUser: function() {
      this.$Progress.start();
      this.form
        .post("api/user")
        .then(() => {
          $("#addNewUserModal").modal("hide");
          Toast.fire({
            icon: "success",
            title: "user added successfully"
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
    deleteUser: function(id) {
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
          .delete("api/user/" + id)
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
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios.get("api/findUser?q=" + query).then(data => {
        this.users = data.data;
      });
    });
    this.loadUsers();

    this.loadUsers();
    Fire.$on("AfterCreate", () => {
      this.loadUsers();
    });
    // this function load the table after 3 seconds
    //    setInterval(() => this.loadUsers(), 3000);
  }
};
</script>
