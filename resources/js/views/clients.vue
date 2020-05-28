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
        <div class="alert alert-danger" v-if="errorMessage">
            <i type="button" class="fas fa-times" v-on:click="errorMessage=false"></i>
            &nbsp;&nbsp;&nbsp;<strong>{{ errorMessage }}</strong>
        </div>
        <!-- Main content -->
        <div class="content">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Lista de Parques</h3>
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
                                        <th>Opções</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="cliente in clients" v-bind:key="cliente.id">
                                        <td>{{cliente.name}}</td>
                                        <td>{{cliente.park_number}}</td>
                                        <td>{{cliente.lugares_livres}}</td>
                                        <td>{{cliente.lugares_max}}</td>
                                        <td><a class="btn btn-sm btn-danger" v-on:click.prevent="deleteCliente(cliente.id)"> Delete</a></td>
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
                                <h3 class="card-title">New Park Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form class="form-horizontal" @submit.prevent="onSubmit">
                                <div class="card-body" style="height: 239px;">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name" name="name" required autocomplete="name" autofocus placeholder="Name" v-model="form.name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="number" class="col-sm-2 col-form-label">Park Number</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="number" name="number" required autocomplete="number" autofocus placeholder="Park Number" v-model="form.park_number">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="number" class="col-sm-2 col-form-label">Total Spots</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="total" name="total" required autocomplete="total" autofocus placeholder="Total Spots" v-model="form.lugares_max">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info">Add Park</button>
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
                form: {
                    'name': '',
                    'park_number': '',
                    'lugares_max': '',
                },
                int:null,
                errorMessage:null,
            }
        },
        created() {
            axios.get('/api/cliente')
                    .then(({data}) => this.clients = data);
            this.startInterval();
            
        },
        beforeDestroy () {
            clearInterval(this.int);
        },
        methods: {
            onSubmit(){
                this.errorMessage = null;

                axios.post('/api/cliente/add',this.form)
                    .catch(error => {
                        if(error.response){
                            if(error.response.status==400){
                                this.errorMessage=error.response.data;
                            }else{
                                this.errorMessage="Erro desconhecido, tente outra vez ou dê refresh à pagina";
                            }
                       }
                    })
                    this.delayGet();
                    //.then(client => this.clients.push(client))

            },
            startInterval(){
                this.int = setInterval(() => {
                    axios.get('/api/cliente')
                    .then(({data}) => this.clients = data);
                }, 5000)
            },
            deleteCliente(id){
                axios.delete('/api/cliente/'+id)
                this.delayGet();
            },
            delayGet(){
                setTimeout(() => axios.get('/api/cliente')
                    .then(({data}) => this.clients = data), 600);
            }
        }
    }
</script>