<template>

    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Users</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Utilizadores da Plataforma</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="height: 450px;">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Park Number</th>
                                        <th>Opções</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="user in users" v-bind:key="user.id">
                                        <td>{{user.id}}</td>
                                        <td>{{user.name}}</td>
                                        <td>{{user.email}}</td>
                                        <td>{{user.type}}</td>
                                        <td v-if="user.type =='user'"> {{user.park_number}}</td>
                                        <td><a class="btn btn-sm btn-danger" v-if="user.type =='user'" v-on:click.prevent="deleteUser(user.id)"> Delete</a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-lg-6">

                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">New User Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form class="form-horizontal" @submit.prevent="onSubmit" @keydown="form.errors.clear()">
                                <div class="card-body" style="height: 339px;">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name" required autocomplete="name" autofocus placeholder="Name" v-model="form.name">
                                            <span class="invalid-feedback d-block" role="alert" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputEmail3" placeholder="Email" v-model="form.email" required>
                                                <span class="invalid-feedback d-block" role="alert" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
                                            </div>

                                        </div>

                                    <div class="form-group row">

                                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="password" placeholder="Password" v-model="form.password" required>
                                            <span class="invalid-feedback d-block" role="alert" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></span>
                                        </div>
                                    </div>
                                
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Type of User</label>
                                        <div class="col-sm-10">
                                            <select v-model="form.type">
                                                <option v-for="type1 in types" v-bind:key="type1.name" :value="type1.value"> {{ type1.name }}
                                            </option> 
                                            </select>                                           
                                            <span class="invalid-feedback d-block" role="alert" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row" v-if="this.form.type=='user'">
                                        <label for="number" class="col-sm-2 col-form-label">Park Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="number" name="number" required autocomplete="number" autofocus placeholder="Park Number" v-model="form.park_number">
                                            <span class="invalid-feedback d-block" role="alert" v-if="form.errors.has('number')" v-text="form.errors.get('number')"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info" :disabled="form.errors.any()">Add User</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>

                    </div>

                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /.content -->

    </div>

</template>

<script>

    export default {

        data() {

            return {
                users: [],
                form: new Form({
                    'name': '',
                    'email': '',
                    'password': '',
                    'password_confirmation': '',
                    'type':'',
                    'park_number':''

                }),
                types:[{name: "Admin", value: "admin"}, {name: "User", value: "user" }],
                type: '',
            }

        },


        created() {
            axios.get('api/users')
                .then(({data}) => this.users = data);
        },

        methods: {
            onSubmit(){
                this.form.password_confirmation = this.form.password; // Temp for this form only.
                this.form
                    .post('/users')
                    .then(user => this.users.push(user));
            },
            deleteUser(id){
                axios.delete('/api/users/'+id)
                this.delayGet();
                //axios.get('/api/users')
                //    .then(({data}) => this.users = data);
            },
            delayGet(){
                setTimeout(() => this.created(), 900);
            }
        },

        watch: {
            'form.type': function() {
                if(this.form.type=="admin"){
                    this.form.park_number="";
                }
            },
            'form.park_number': function() {
                if(this.form.type=="admin"){
                    this.form.park_number="";
                }
            }
        }
    }

</script>
