<template>

    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Logs</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Logs</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Historico de entradas</h3>

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
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Matricula</th>
                            <th>Park Number (ID)</th>
                            <th>Data</th>
                            <th>Entrada/Saida</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="log in logs" v-bind:key="log.id">
                            <td>{{log.matricula}}</td>
                            <td>{{log.park_number}}</td>
                            <td>{{log.datetime}}</td>
                            <td>{{user.id}}</td>
                        </tr>
                        </tbody>
                    </table>
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
                logs: [],
                form: new Form({
                    'matricula': '',
                    'park_number': '',
                }),
                user: '',
            }

        },


        created() {
            axios.get('/api/logs')
                .then(({data}) => this.logs = data);    
        },

        methods: {
        }
    }

</script>
<style>

* { padding: 0; margin: 0; }

html, body {
  height: 99%;

  display: flex;
  flex-direction: column;
}

body > * {
  flex-shrink: 0;
}

.card-body.table-responsive.p-0 {
  flex-grow: 1;
}

</style>