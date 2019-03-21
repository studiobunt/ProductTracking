<?php
    session_start();
    if(!isset($_SESSION['login'])) {
        header('LOCATION:../index.php'); die();
    }
?>
<html>  
    <head>  
        <title>Krojnica</title>  
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>  
    </head>  
    <body>  
        <div class="container">  
   <br />
            <h3 align="center">Krojnica</h3><br />
            <nav class="navbar navbar-default">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <a class="navbar-brand" href="#">#</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div  id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="indexKrojnica.php">Krojnica <span class="sr-only">(current)</a></li>
                    <li><a href="../sivara/indexSivara.php">Šivara</a></li>
                    <li><a href="../magacin/indexMagacin.php">Magacin</span></a></li>
                    <li><a href="../lager/indexLager.php">Lager</span></a></li>                    
                    <li><a href="../musterije/indexMusterije.php">Mušterije</span></a></li>
                    <li><a href="../racuni/invoice.php">Računi</span></a></li>
                    <li><a href="../logout.php">Izloguj se</span></a></li>
                  </ul>
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
             </nav>
   <div class="table-responsive" ng-app="liveApp" ng-controller="liveController" ng-init="fetchData()">
                <div class="form-group">
                <div class="input-group">
                 <span class="input-group-addon">Pretraga</span>
                 <input type="text" name="search_query" ng-model="search_query" ng-keyup="fetchData()" placeholder="Pretraži po šifri modela" class="form-control" />
                </div>
               </div>
                <div class="alert alert-success alert-dismissible" ng-show="success" >
                    <a href="#" class="close" data-dismiss="alert" ng-click="closeMsg()" aria-label="close">&times;</a>
                    {{successMessage}}
                </div>
                <form name="testform" ng-submit="insertData()">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Model</th>
                                <th>Boja</th>
                                <th>Komadi</th>
                                <th>Datum dolaska</th>
                                <th>Datum završetka</th>
                                <th>Naredba</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" ng-model="addData.model" class="form-control" placeholder="Unesi model" ng-required="true" /></td>
                                <td><select name="dodajBoju" ng-model="addData.boja" class="form-control" ng-required="true">  
                                        <option value="">Unesi boju</option>
                    <option value="crna">crna</option>
                    <option value="teget">teget</option>
                    <option value="tamno siva">tamno siva</option>
                    <option value="svetlo siva">svetlo siva</option>
                    <option value="zelena">zelena</option>
                    <option value="bordo">bordo</option>
                    <option value="marsal">marsal</option>
                    <option value="plava">plava</option>
                    <option value="teksas">teksas</option>
                    <option value="crvena">crvena</option>
                    <option value="bez">bez</option>
                    <option value="zuta">zuta</option>
                    <option value="bela">bela</option>
                    <option value="oker">oker</option>
                    <option value="braon">braon</option>
                                </select></td>
                                <td><input type="text" ng-model="addData.kilaza" class="form-control" placeholder="Unesi broj komada" ng-required="true" /></td>
                                <td><input type="date" min="2018-01-01" max="2019-12-31" ng-model="addData.datum_dolaska" class="form-control" placeholder="Unesi datum dolaska" ng-required="true" /></td>
                                <td></td>
                                <td><button type="submit" class="btn btn-success btn-sm" ng-disabled="testform.$invalid">Dodaj</button></td>
                            </tr>
                            <tr ng-repeat="data in namesData" ng-include="getTemplate(data)">
                            </tr>
                            
                        </tbody>
                    </table>
                </form>
                <script type="text/ng-template" id="display">
                    <td style="padding-top:1.25%">{{data.model}}</td>
                    <td><select name="boja" ng-model="boja" class="form-control" ng-click="loadBoje(data.model)" ng-change="loadKomadi(data.model, boja)">  
                          <option value="">Odaberi boju</option>  
                          <option ng-repeat="boja in boje" value="{{boja.boja}}">{{boja.boja}}</option>  
                     </select> </td>
                    <td style="padding-top:1.25%">{{komad}}</td>
                    <td>{{data.dolazak}}</td>
                    <td>{{data.zavrsetak}}</td>
                    <td width="20%">  
                        <button type="button" class="btn btn-warning btn-sm" ng-click="zavrsi(data.model, boja, komad)">Završi</button>
                        <button type="button" ng-disabled="!boja || boja.length == 0" class="btn btn-primary btn-sm" ng-click="showEdit(data, boja)">Izmeni</button>
                        <button type="button" ng-disabled="!boja || boja.length == 0" class="btn btn-danger btn-sm" ng-click="deleteData(data.model, boja)">Obriši</button>
                    </td>
                </script>
                <script type="text/ng-template" id="edit">
                    <td><input type="text" ng-model="formData.model" class="form-control"  /></td>
                    <td><input type="text" ng-model="formData.boja" class="form-control" disabled /></td>
                    <td><input type="text" ng-model="formData.komad" class="form-control" /></td>
                    <td><input type="text" ng-model="formData.dolazak" class="form-control" /></td>
                    <td><input type="text" ng-model="formData.zavrsetak" class="form-control" /></td>
                    <td>
                        <input type="hidden" ng-model="formData.data.id" />
                        <button type="button" class="btn btn-info btn-sm" ng-click="editData()">Sačuvaj</button>
                        <button type="button" class="btn btn-default btn-sm" ng-click="reset()">Otkaži</button>
                    </td>
                </script>         
   </div>  
  </div>
    </body>  
</html>  
<script>
var app = angular.module('liveApp', []);

app.controller('liveController', function($scope, $http){

    $scope.formData = {};
    $scope.addData = {};
    $scope.success = false;

    $scope.getTemplate = function(data){
        if (data.model === $scope.formData.model)
        {
            return 'edit';
        }
        else
        {
            return 'display';
        }
    };

    $scope.fetchData = function(){
              $http({
               method:"POST",
               url:"select.php",
               data:{search_query:$scope.search_query}
              }).success(function(data){
               $scope.namesData = data;
              });
    };

    $scope.insertData = function(){
        $http({
            method:"POST",
            url:"insert.php",
            data:$scope.addData,
        }).success(function(data){
            $scope.success = true;
            $scope.successMessage = data.message;
            $scope.fetchData();
            $scope.addData = {};
        });
    };

    $scope.showEdit = function(data, boja) {
        $scope.formData = angular.copy(data);
        $scope.formData.komad = $scope.komad;
        $scope.formData.boja = boja;
    };

    $scope.editData = function(){
        $http({
            method:"POST",
            url:"edit.php",
            data:$scope.formData,
        }).success(function(data){
            $scope.success = true;
            $scope.successMessage = data.message;
            $scope.fetchData();
            $scope.formData = {};
            $scope.komad = "";
        });
    };

    $scope.reset = function(){
        $scope.formData = {};
    };

    $scope.closeMsg = function(){
        $scope.success = false;
    };

    $scope.deleteData = function(model, boja){
        if(confirm("Jesi li siguran da hoćeš da obrišeš?"))
        {
            $http({
                method:"POST",
                url:"delete.php",
            data:{'model':model, 'boja':boja}
            }).success(function(data){
                $scope.success = true;
                $scope.successMessage = data.message;
                $scope.fetchData();
            }); 
        }
    };

    $scope.zavrsi = function(model, boja, komad){
        if(confirm("Jesi li siguran da hoćeš da prebaciš model u šivaru?"))
        {
            $http({
                method:"POST",
                url:"insertZavrsenoKrojnica.php",
                data:{'model':model, 'boja':boja, 'komad':komad}
            }).success(function(data){
                $scope.success = true;
                $scope.successMessage = data.message;
                $scope.fetchData();
            }); 
        }
    };

    $scope.loadBoje = function(model){
            $http({
                method:"POST",
                url:"ubaciBoje.php",
                data:{'model':model}
            }).success(function(data){
                $scope.boje = data;
            }); 
    };

    $scope.loadKomadi = function(model, boja){
        $http({
            method:"POST",
            url:"ubaciKomad.php",
            data:{'model':model, 'boja':boja}
        }).success(function(data){
            $scope.komad = data[0]["komad"];
            console.log($scope.komad);
        }); 
    };

});

</script>
