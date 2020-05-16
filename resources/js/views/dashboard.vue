<template>
    <div class="no">
        <div >
            <!-- Content Header (Page header) -->
            <div class="content-header">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
        
            <section class="content" v-if="type=='user'">
                
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-sm-8 info-box">
                            <div class="info-box-content">
                                <h5 id="progstats" class="mb-2 mt-4">{{ text }}</h5><br>
                                <div class="progress">
                                    <div id="progbar" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;background-color: #f50c0c"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="info-box mb-2 mt-4">
                                <span class="info-box-icon bg-danger"><i class="fas fa-car"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Nr. de Matriculas autorizadas</span>
                                    <span class="info-box-number">{{totalMatriculas}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>

                        </div>
                    </div>

                    
                    <!-- /.row -->
                    <!-- =========================================================== -->
                    <!-- Info Box -->
                    
                    
                    <!-- /.row -->

                    
                    <!-- /.row -->

                    <!-- =========================================================== -->

                </div><!-- /.container-fluid -->
            </section>
        </div>
        <div class="container-fluid row" v-if="type=='admin'">
            
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{totalClients}}</h3>
                        <p>Parques Atualmente</p>
                    </div>
                    <div class="icon">
                    <i class="fas fa-parking"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box " style="color:white;background-color:#039884">
            <div class="inner">
              <h3>{{totalUsers}}</h3>

              <p>Plataform Users</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-friends"></i>
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
                int:null,
                percent:'',
                livres:'',
                max:'',
                ocupados:'',
                dataAux:[],
                text:'Lugares Ocupados: <LOADING>',
                totalMatriculas:'',
                totalClients:'...',
                totalUsers:'...',

            }

        },
        created(){
            this.type=window.user_type;
            //this.fetchData();
        },

        beforeDestroy () {
            console.log('2')
            clearInterval(this.int);

        },
        
        mounted: function() {
            this.fetchData();
        },

        methods: {
            fetchData(){
                this.int= setInterval(() => {
                    if(window.user_type=='user'){
                        axios.get('/api/cliente/'+window.park_number)
                        .then(({data}) => this.dataAux=data)
                        
                        if(this.dataAux[0]!=null){
                            this.livres = this.dataAux[0].lugares_livres;
                            this.max= this.dataAux[0].lugares_max;
                            this.ocupados = this.max - this.livres;
                            this.percent = (this.ocupados/this.max)*100;
                            //console.log(this.percent);

                            document.getElementById('progbar').style.width = this.percent +"%"; //style="width: 40%"
                            this.text ="Lugares Ocupados: "+this.ocupados + " de " + this.max;

                            axios.get('/api/cliente/matriculas/'+window.park_number)
                            .then(({data}) => this.totalMatriculas=data);
                            
                        }
                    }else{
                        axios.get('/api/cliente/count')
                            .then(({data}) => this.totalClients=data);
 
                        axios.get('/api/user/count')
                            .then(({data}) => this.totalUsers=data);
                    }

                }, 2000)
                
            }
        },        
    }

</script>
