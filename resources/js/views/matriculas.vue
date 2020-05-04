<template>

    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Matriculas (Autorizações)</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Matriculas</li>
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
                                <h3 class="card-title">Matriculas Autorizadas</h3>

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
                            <div class="card-body table-responsive p-0" style="height: 400px;">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Matricula</th>
                                        <th>Park Number (ID)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="matricula in matriculas" v-bind:key="matricula.id">
                                        <td>{{matricula.matricula}}</td>
                                        <td>{{matricula.park_number}}</td>
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
                                <h3 class="card-title">Autorizar nova matricula</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form class="form-horizontal" @submit.prevent="onSubmit" @keydown="form.errors.clear()">
                                <div class="card-body" style="height: 159px;">
                                    <div class="form-group row">
                                        <label for="matricula" class="col-sm-2 col-form-label">Matricula</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="matricula" name="matricula" required autocomplete="matricula" autofocus placeholder="Matricula" v-model="form.matricula">
                                            <span class="invalid-feedback d-block" role="alert" v-if="form.errors.has('matricula')" v-text="form.errors.get('matricula')"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="number" class="col-sm-2 col-form-label">Park Number</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="number" name="number" required autocomplete="number" autofocus placeholder="Park Number" v-model="form.park_number">
                                            <span class="invalid-feedback d-block" role="alert" v-if="form.errors.has('number')" v-text="form.errors.get('number')"></span>
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
                matriculas: [],
                form: new Form({
                    'matricula': '',
                    'park_number': '',
                })
            }

        },


        created() {
            axios.get('/api/matricula')
                .then(({data}) => this.matriculas = data);
        },

        methods: {
            onSubmit(){
                this.form
                    .post('/api/matricula/add')
                    .then(matricula => this.matriculas.push(matricula));
            }
        }
    }

</script>
