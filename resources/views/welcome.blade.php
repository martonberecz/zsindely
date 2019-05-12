<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <style>
            #main img{
                max-width: 40vw;
                max-height: 40vh;
            }


     .flex-container {
        margin-top: 5vh;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        width: 100%;
    }
    .roofs {
        flex-basis: 25%;
        flex-grow: 1;
        margin-right: 0.5vw;
    }

    .main-row{
        height: 100vh;
    }

    .roofs{
        margin-bottom: 1vh;
        border: none;
    }

    .card-text{
        text-align: center;
    }

.sum-table{
    width: 50vw;
    margin: auto; 
    height: auto;
}

            </style>

    </head>
    <body>
        <div class="container-fluid">            
                <div class="row col col-md-12 main-row" id="main-row">
                        <div class="col col-md-8 flex-container" id="main">
                                
                        </div>
                        <div class="col col-md-4 flex-container" id="main">
                                <div class="row">
                                        <div class="col-sm-6 form-side" id="form-side">
                                                                      
                                                          
                                        </div>                                        
                                      </div>
                        </div>
                </div>
        </div>
        
        
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>

        function _(id){
            return document.getElementById(id);
        }

        //*********************roof forms***********************/
            function getRoofs() {
                let toappend = "";
                fetch('http://142.93.170.119/api/roofs')
                    .then((res) => res.json())
                    .then((data) => {
                        data.data.forEach(function (roof) {
                            toappend += `<div class="card roofs" style="width: 13rem;">`+
                                        `<img src="../img/${roof.roofType.replace(/ /g, '').toLowerCase()}.jpg" alt="" onclick="getFrom(${roof.id})"  class="card-img-top">`+
                                        `<div class="card-body">`+
                                        `<p class="card-text" id="${roof.id}">${roof.roofType}</p>`+
                                        `</div></div>`;
                })
                          
                document.getElementById("main").innerHTML = toappend;  
                    })
            }
            getRoofs();
let mainForm ={};
        function getFrom(id) { 
           let formfields = "";

            let img = _(id).innerHTML.replace(/ /g, '').toLowerCase();
            formfields +='<div class="card card-form" style="width: 18rem;">'+
                    '<img src="../img/'+img+'calc.jpg" alt="" class="card-img-top">'+
                    '<div class="card-body">'+
                    '<p class="card-text"><form>';
            
            fetch('http://142.93.170.119/api/fields')
                .then((res) => res.json())
                .then((data) => {
                    data.data.forEach(function (field) {
                        if(field.roofId == id){  
                            if(field.field1 != undefined)  {
                                formfields += `<div class="form-group"><label for="${field.field1}">${field.field1}</label><input type="text" name="${field.field1}" class="form-control" id="${field.field1}" onblur="storeMain('${field.field1}')"></div>`;                                                                                      
                            }
                            if(field.field2 != undefined)  {
                                formfields += `<div class="form-group"><label for="${field.field2}">${field.field2}</label><input type="text" name="${field.field2}" class="form-control" id="${field.field2}" onblur="storeMain('${field.field2}')"></div>`;                                                                                      
                            }
                            if(field.field3 != undefined)  {
                                formfields += `<div class="form-group"><label for="${field.field3}">${field.field3}</label><input type="text" name="${field.field3}" class="form-control" id="${field.field3}" onblur="storeMain('${field.field3}')"></div>`;                                                                                      
                            }
                            if(field.field4 != undefined)  {
                                formfields += `<div class="form-group"><label for="${field.field4}">${field.field4}</label><input type="text" name="${field.field4}" class="form-control" id="${field.field4}" onblur="storeMain('${field.field4}')"></div>`;                                                                                      
                            }
                            if(field.field5 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field5+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            if(field.field6 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field6+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            if(field.field7 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field7+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            if(field.field8 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field8+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            if(field.field9 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field9+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            if(field.field10 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field10+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            if(field.field11 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field11+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            if(field.field12 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field12+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            if(field.field13 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field13+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            if(field.field14 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field14+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            if(field.field15 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field15+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            if(field.field16 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field16+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            if(field.field17 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field17+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            if(field.field18 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field18+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            if(field.field19 != undefined)  {
                                formfields += '<div class="form-group"><label for="">'+field.field19+'</label><input type="text" class="form-control"></div>';                                                       
                            }
                            }
                        })
                        formfields += '<button type="submit" class="btn btn-primary" onclick="getOptional(event)">Submit</button></form></p></div></div>';
                        _("form-side").innerHTML = formfields;
                    })
         }
    
    function storeMain(id){
        mainForm[id] = _(id).value;

        console.log(mainForm);
    }

    function getOptional(e) {
        e.preventDefault();
        _("main-row").innerHTML = "";

        let optionals = ""

        optionals += '<h2>Section title</h2><div class="table-responsive">'+
                    '<table class="table table-striped table-sm"><thead><tr>'+
                    '<th>Tétel szövege</th><th>Mennyiseg</th><th>Egység</th>'+
                    '<th>Anyag egységár (Ft)</th><th>Díj egységre (Ft)</th><th>Anyag összesen (Ft)</th><th>Díj összesen (Ft)</th></tr></thead><tbody>';
                fetch('http://142.93.170.119/api/kalks')
                    .then((res) => res.json())
                    .then((data) => {
                        data.data.forEach(function (optional) {
                            if(optional.opcionalis == 1){
                                optionals += `<tr><td>${optional.title}</td><td><input type="text" class="form-control" id="mennyiseg${optional.id}" placeholder="0" onblur="fuvarmozg(${optional.id})" onkeyup="optionalSumFunc(${optional.id})"></td><td>${optional.egyseg}</td><td id="egysegar${optional.id}">${optional.egysegar}</td><td id="dijegysegre${optional.id}">${optional.dijegysegre}</td><td><input type="text" class="form-control" id="anyagSum${optional.id}" aria-describedby="emailHelp" placeholder="0"></td><td><input type="text" class="form-control" id="sum${optional.id}" placeholder="0"></td></tr>`;
                            }
                })
                          
                optionals += '</tbody></table><button class="btn btn-success btn-lg" onclick="getSummary(event)">Elkuld</button></div>';
                _("main-row").innerHTML = optionals;
                    })
    }
    
let tempArray = [];

function fuvarmozg(id){
    let beszerzes = parseInt(_("egysegar11").innerHTML);
    let mozgatas = parseInt(_("egysegar12").innerHTML); 
    
    if(tempArray.indexOf(id)<0){
        tempArray.push(id);
        beszerzes = beszerzes + (0.1 * parseInt(_("egysegar"+id).innerHTML));
        mozgatas = mozgatas + (0.05 * parseInt(_("egysegar"+id).innerHTML));
    }

    if(tempArray.indexOf(id)>-1 && _("mennyiseg"+id).value == 0){
        delete tempArray[tempArray.indexOf(id)];

        beszerzes = beszerzes - (0.1 * parseInt(_("egysegar"+id).innerHTML));
        mozgatas = mozgatas - (0.05 * parseInt(_("egysegar"+id).innerHTML));
    }

    //anyag beszerzes id = 11
        //anyagmozgatas id = 12
        
    _("egysegar11").innerHTML=beszerzes;
    _("egysegar12").innerHTML=mozgatas;
}

    function optionalSumFunc(id){         

        let amount = _("mennyiseg"+id).value;
        let anyag = (amount * parseInt(_("egysegar"+id).innerHTML));
        let dijEgyseg = (amount * parseInt(_("dijegysegre"+id).innerHTML));

        _("anyagSum"+id).value=anyag;
        _("sum"+id).value=dijEgyseg;  
        
    }
function getSummary(e){
    e.preventDefault();
        _("main-row").innerHTML = "";

        let optionals = ""

        optionals += '<h2>A kalkuláció eredménye</h2><div class="table-responsive">'+
                    '<table class="table table-striped table-sm sum-table"><thead><tr>'+
                    '<th>Tétel szövege</th><th>Mennyiseg</th><th>Egység</th>'+
                    '</tr></thead><tbody>';
                fetch('http://142.93.170.119/api/kalks')
                    .then((res) => res.json())
                    .then((data) => {
                        data.data.forEach(function (optional) {
                                optionals += `<tr><td>${optional.title}</td><td id="mennyiseg${optional.id}></td><td>${optional.egyseg}</td></tr>`;
                            
                })
                          
                optionals += '</tbody></table></div>';
                _("main-row").innerHTML = optionals;
                console.log(mainForm);
                    })
}
    </script>
    </body>
</html>
