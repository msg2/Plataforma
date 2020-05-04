<template>

    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Parques (Clientes)</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Parques</li>
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
                                <h3 class="card-title">Lista de Parques</h3>

                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="height: 450px;">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Park Number (ID)</th>
                                        <th>Free Spots</th>
                                        <th>Total Spots</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="cliente in clients" v-bind:key="cliente.id">
                                        <td>{{cliente.name}}</td>
                                        <td>{{cliente.park_number}}</td>
                                        <td>{{cliente.lugares_livres}}</td>
                                        <td>{{cliente.lugares_max}}</td>
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
                                <h3 class="card-title">New Client Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form class="form-horizontal" @submit.prevent="onSubmit" @keydown="form.errors.clear()">
                                <div class="card-body" style="height: 239px;">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name" required autocomplete="name" autofocus placeholder="Name" v-model="form.name">
                                            <span class="invalid-feedback d-block" role="alert" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="number" class="col-sm-2 col-form-label">Park Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="number" name="number" required autocomplete="number" autofocus placeholder="Park Number" v-model="form.park_number">
                                            <span class="invalid-feedback d-block" role="alert" v-if="form.errors.has('number')" v-text="form.errors.get('number')"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="number" class="col-sm-2 col-form-label">Total Spots</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="total" name="total" required autocomplete="total" autofocus placeholder="Total Spots" v-model="form.lugares_max">
                                            <span class="invalid-feedback d-block" role="alert" v-if="form.errors.has('total')" v-text="form.errors.get('total')"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info" :disabled="form.errors.any()">Add Client</button>
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
                clients: [],
                form: new Form({
                    'name': '',
                    'park_number': '',
                    'lugares_max': '',
                })
            }

        },


        created() {
            axios.get('/api/cliente')
                .then(({data}) => this.clients = data);
        },

        methods: {
            onSubmit(){
                this.form
                    .post('/api/cliente/add')
                    .then(client => this.clients.push(client));
            }
        }
    }

</script>
