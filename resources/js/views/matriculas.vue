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
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="height: 400px;">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Matricula</th>
                                        <th>Opções</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="matricula in matriculas" v-bind:key="matricula.id">
                                        <td>{{matricula.matricula}}</td>
                                        <td><a class="btn btn-sm btn-danger" v-on:click.prevent="deleteMatricula(matricula.id)"> Delete</a></td>
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
                            <form class="form-horizontal" @submit.prevent="onSubmit">
                                <div class="card-body" style="height: 159px;">
                                    <div class="form-group row">
                                        <label for="matricula" class="col-sm-2 col-form-label">Matricula</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="matricula" name="matricula" required autocomplete="matricula" autofocus placeholder="Matricula" v-model="body.matricula">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info" >Add Matricula</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>

                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Carregar .csv</h3>
                            </div>
                            <div class="card-body">
                                <label for="exampleInputFile"> File .csv </label><br>
                                <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-info" v-on:click="submitFile()">Submit</button>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
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
                body:{
                    matricula: "",
                    park_number: window.park_number,
                },
                form: new Form({}),
                file:''
            }

        },


        created() {
            //console.log(window.park_number);
            axios.get('/api/matricula/'+window.park_number)
                .then(({data}) => this.matriculas = data);
        },

        methods: {
            onSubmit(){
                this.body.matricula = this.body.matricula.trim();
                this.body.matricula = this.body.matricula.toUpperCase();

                //console.log(this.body)
                axios.post('/api/matricula/add',this.body)
                    .then(body => this.matriculas.push(this.body));
            },
            deleteMatricula(matricula){
                //console.log(matricula);
                axios.delete('/api/matricula/'+matricula);
                axios.get('/api/matricula/'+window.park_number)
                .then(({data}) => this.matriculas = data);
            },
            submitFile(){
                
                const data = new FormData();
                data.append('file', this.file);
                data.append('park_number', window.park_number);
               
                axios.post('/api/file/upload',data);
                this.fetchData();

            },
            
            handleFileUpload(){
                this.file = this.$refs.file.files[0];
            },

            fetchData(){
                axios.get('/api/matricula/'+window.park_number)
                .then(({data}) => this.matriculas = data);
            }
        }
    }

</script>
