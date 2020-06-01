<template>

    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Codigos QR</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">QRcodes</li>
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
                                <h3 class="card-title">QRcodes autorizados</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="height: 450px;">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Valor</th>
                                        <th>Opções</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="qrcode in qrcodes" v-bind:key="qrcode.id">
                                        <td>{{qrcode.value}}</td>
                                        <td><a class="btn btn-sm btn-danger" v-on:click.prevent="deleteQR(qrcode.value)"> Delete</a></td>
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
                                <h3 class="card-title">Adicionar Novo QR</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form class="form-horizontal" @submit.prevent="onSubmit">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*(É suposto definir um numero com entre 5 a 9 digitos)
                                <div class="card-body" style="height: 300px;">
                                    <div class="form-group row">
                                        <label for="QRcode" class="col-sm-2 col-form-label">QRcode Value</label>
                                        <div class="col-sm-10">
                                            <input type="number" min="10000" max="999999999" class="form-control" id="QRcode" name="QRcode" required autocomplete="QRcode" autofocus placeholder="Ex: 1234567890" v-model="body.value">
                                        </div>
                                    </div>
                                    <div id="parent" v-if="body.value">
                                        <vue-qrcode  id="imgto" classe="center" :value="body.value" />  
                                        <a id="banana" class="btn btn-sm btn-danger" href="123" download="filename.jpg"> Download PNG</a>                                    
                                    </div>
                                    <div id="card-footer">
                                    <button type="submit" class="btn btn-info" >Add QRcode</button>
                                </div>
                                </div>
                                <!-- /.card-body -->
                                
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
import VueQrcode from 'vue-qrcode'

    export default {

        data() {

            return {
                qrcodes: [],
                body:{
                    value: '',
                    park_number: window.park_number,
                },
                file:'',
                text:'123',
                errorMessage:null,
                img:null, 
            }

        },
        components: {
            VueQrcode,
        },


        created() {
            //console.log(window.park_number);
            axios.get('/api/qrcodes/'+window.park_number)
                .then(({data}) => this.qrcodes = data);
        },

        methods: {
            onSubmit(){
                this.errorMessage=null;
                axios.post('/api/qrcode/add',this.body)
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
                
                /////////////////////////////////Donwload imagem automatico
                this.img = document.getElementById("imgto");
                
                var image_data = atob(this.img.src.split(',')[1]);
                // Use typed arrays to convert the binary data to a Blob
                var arraybuffer = new ArrayBuffer(image_data.length);
                var view = new Uint8Array(arraybuffer);
                for (var i=0; i<image_data.length; i++) {
                    view[i] = image_data.charCodeAt(i) & 0xff;
                }
                try {
                    // This is the recommended method:
                    var blob = new Blob([arraybuffer], {type: 'application/octet-stream'});
                } catch (e) {
                    // The BlobBuilder API has been deprecated in favour of Blob, but older
                    // browsers don't know about the Blob constructor
                    // IE10 also supports BlobBuilder, but since the `Blob` constructor
                    //  also works, there's no need to add `MSBlobBuilder`.
                    var bb = new (window.WebKitBlobBuilder || window.MozBlobBuilder);
                    bb.append(arraybuffer);
                    var blob = bb.getBlob('application/octet-stream'); // <-- Here's the Blob
                }

                // Use the URL object to create a temporary URL
                var url = (window.webkitURL || window.URL).createObjectURL(blob);

                var link = document.createElement("a");
                link.download = 'qr_ '+ this.body.value  +'.png';
                link.href = url;

                document.body.appendChild(link);
                link.click();
                // Cleanup the DOM
                document.body.removeChild(link);
                /////////////////////////////////////Download imagem automatico

            },
            deleteQR(qrcode){
                //console.log(matricula);
                axios.delete('/api/qrcode/'+qrcode);
                this.delayGet();
            }, 
            fetchData(){
                axios.get('/api/qrcodes/'+window.park_number)
                .then(({data}) => this.qrcodes = data);
            },
            delayGet(){
                setTimeout(() => this.fetchData(), 700);
            }
        }
    }

</script>
<style>
#parent {
    text-align:center;
}
.center {
    margin: 0 auto;
}
</style>