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
    width: 90vw;
    margin: auto; 
    height: auto;
}

.hide{
    display: none;
}


            </style>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container-fluid">            
                <div class="row col col-md-12 main-row" id="main-row">
                        <div class="col col-md-8 flex-container" id="main">
                                
                        </div>
                        <div class="col col-md-4 flex-container" id="main-side">
                                <div class="row">
                                        <div class="col-sm-6 form-side" id="form-side">
                                                                      
                                                          
                                        </div>                                        
                                      </div>
                        </div>
                </div>
        </div>
        
        
            
    <script>
        let formfields = "";
        let testArray = {};
        let tempArray = [];
        let optionalValues = {};
        function _(id){
            return document.getElementById(id);
        }

        //*********************roof forms***********************/
            function getRoofs() {
                let toappend = "";
                //fetch('http://localhost:8000/api/roofs')// http://142.93.170.119/api/roofs 
                fetch('http://142.93.170.119/api/roofs')
                    .then((res) => res.json())
                    .then((data) => {
                        data.data.forEach(function (roof) {
                            toappend += `<div class="card roofs" style="width: 13rem;">`+
                                        `<img src="../img/${roof.roofType.replace(/ /g, '').toLowerCase()}.jpg" alt="" onclick="getConnector(${roof.id})"  class="card-img-top">`+
                                        `<div class="card-body">`+
                                        `<p class="card-text" id="${roof.id}">${roof.roofType}</p>`+
                                        `</div></div>`;
                })
                          
                document.getElementById("main").innerHTML = toappend;  
                    })
            }
           getRoofs(); 

        function getForm(id,imgId) { 
           
            console.log("Roof id: "+imgId);
            let img = _(imgId).innerHTML.replace(/ /g, '').toLowerCase();
            formfields +='<div class="card card-form" style="width: 18rem;">'+
                    '<img src="../img/'+img+'calc.jpg" alt="" class="card-img-top">'+
                    '<div class="card-body">'+
                    '<p class="card-text"><form>';
            //fetch('http://localhost:8000/api/fields')
            fetch('http://142.93.170.119/api/fields')
                .then((res) => res.json())
                .then((data) => {
                    data.data.forEach(function (field) {
                        let found = id.find(function(element){
                            return element == field.id;
                        });
                        if(field.id == found){ 
                                formfields += `<div class="form-group"><label for="${field.fieldName}">${field.fieldName}</label><input id="${field.fieldName}" type="text" name="${field.fieldName}" class="form-control" onblur="storeMain('${field.fieldName}','${field.id}')"></div>`;                                                                                                                                              
                                
                            }
                        })
                        formfields += '<button type="submit" class="btn btn-primary" onclick="getOptional(event,'+imgId+')">Submit</button></form></p></div></div>';
                        _("form-side").innerHTML = formfields;
                    })
        }

         function getConnector(id){
            console.log("Roof id: "+id);
             let fields = [];
            //fetch('http://localhost:8000/api/FieldRoofConnector/'+id)
            fetch('http://142.93.170.119/api/FieldRoofConnector/'+id)
                .then((res) => res.json())
                .then((data) => {
                    data.data.forEach(function (field) {
                        fields.push(field.fieldId);
                });                
                    })
            getForm(fields,id);
         }

    function storeMain(name, id, roofId){        
        let inputValue = document.getElementById(name).value;
        testArray[id] = inputValue;      
    }

    function getOptional(e, roofId) {
        e.preventDefault();
        console.log("Roof id: "+roofId);
        _("main-row").innerHTML = "";

        let optionals = ""

        optionals += '<h2>Section title</h2><div class="table-responsive">'+
                    '<table class="table table-striped table-sm"><thead><tr>'+
                    '<th>Tétel szövege</th><th>Mennyiseg</th><th>Egység</th>'+
                    '<th>Anyag egységár (Ft)</th><th>Díj egységre (Ft)</th><th>Anyag összesen (Ft)</th><th>Díj összesen (Ft)</th></tr></thead><tbody>';
                //fetch('http://localhost:8000/api/kalks')
               fetch('http://142.93.170.119/api/kalks')
                    .then((res) => res.json())
                    .then((data) => {
                        data.data.forEach(function (optional) {
                            if(optional.opcionalis == 1){
                                optionals += `<tr><td>${optional.title}</td><td>`+
                                `<input type="text" class="form-control" id="${optional.id}" placeholder="0" onblur="fuvarmozg(${optional.id})" onkeyup="optionalSumFunc(${optional.id})"></td>`+
                                `<td>${optional.egyseg}</td><td id="egysegar${optional.id}">${optional.egysegar}</td><td id="dijegysegre${optional.id}">${optional.dijegysegre}</td>`+
                                `<td><input type="text" class="form-control" id="anyagSum${optional.id}" placeholder="0"></td>`+
                                `<td><input type="text" class="form-control" id="sum${optional.id}" placeholder="0"></td></tr>`;
                            }
                })
                          
                optionals += '</tbody></table><button class="btn btn-success btn-lg" onclick="getSummary(event,'+roofId+')">Elkuld</button></div>';
                _("main-row").innerHTML = optionals;
                    })
    }
    


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
        let amount = _(id).value;
        optionalValues['id'+id]=id;
        optionalValues[id]= amount;      
        let anyag = (amount * parseInt(_("egysegar"+id).innerHTML));
        let dijEgyseg = (amount * parseInt(_("dijegysegre"+id).innerHTML));

        _("anyagSum"+id).value=anyag;
        _("sum"+id).value=dijEgyseg;  
        
    }

    let optionals = "";
function getSummary(e,roofId){
    console.log("Roof id: "+roofId);
    e.preventDefault();
    _("main-row").innerHTML = "";
        
   
        optionals += '<h2>A kalkuláció eredménye</h2><div class="table-responsive">'+
    '<table class="table table-striped table-sm sum-table col-md-12"><thead><tr>'+
    '<th>Tétel szövege</th><th>Egység</th><th>Mennyiseg</th><th>Anyag egységár (Ft)</th><th>Díj egységre (Ft)</th><th>Anyag összesen (Ft)</th><th>Díj összesen (Ft)</th>'+
    '</tr></thead><tbody class="inner">';

    //fetch('http://localhost:8000/api/kalks')
    fetch('http://142.93.170.119/api/kalks')
        .then((res) => res.json())
        .then((data) => {                        
            data.data.forEach(function (optional) {
                let something = '<tr><td>'+optional.title+'</td><td>'+optional.egyseg+'</td>'+
                                '<td id="'+optional.id+'">'+((optional.id == optionalValues['id'+optional.id])? optionalValues[optional.id] : "0")+'</td>'+
                                '<td id="anyag'+optional.id+'"></td>'+
                                '<td id="dij'+optional.id+'"></td>'+
                                '<td id="anyagSum'+optional.id+'"></td>'+
                                '<td id="dijSum'+optional.id+'"></td>'+
                                '</tr>';
                 $(".inner").append(something); 
                 calculator(optional.id, optional.egysegar, optional.dijegysegre,optional.opcionalis,roofId)
    })         
        })
        optionals += '</tbody></table></div><div class="row">Total value to pay: <span id="gTotal"></span></div>'; 
    _("main-row").innerHTML = optionals;
}



function calculator(id, egysegar,dijegyseg,optional,roofId){

/****************Formulas****************/
//P8 = SQRT(P2*P2-pow((M2-Q2)/2.2))
let M5 = 0;
let M4 = 0;
let P8 = 0;

if(roofId==3){
    P8 = Math.sqrt(testArray[5]*testArray[5]-Math.pow(((testArray[2]-testArray[6])/2),2));
    //P7 = (L2*M2-2*P8)
    let P7 = testArray[1]*testArray[2]-2*P8;
    //M8 = P2+R2/2
    let M8 = parseFloat(testArray[5])+(parseFloat(testArray[8]/2));
    //M6 = SQRT(M8*(M8-P2)*(M8-P2)*(M8-R2))
    let M6 = Math.sqrt(M8*(M8-testArray[5])*(M8-testArray[5])-(M8-testArray[8]));                
    //M5 = 2*(P7+M6)
     M5 = 2*(P7+M6);
     //M4 =2*M2
     M4 = 2 * testArray[2];

    console.log("P8 = " +P8);
    console.log("P7 = " +P7);
    console.log("M8 = " +M8);    
    console.log("M6 = " +M6);
    console.log("M5 = " +M5);

    console.log("Roof id: "+roofId);
}
    if(optional==1){
        var egysegAr = optionalValues[id]*egysegar;
        var dijEgysegAr = optionalValues[id]*dijegyseg;
        _("anyag"+id).innerHTML = egysegar;
        _("dij"+id).innerHTML = dijegyseg;
        _("anyagSum"+id).innerHTML = egysegAr;
        _("dijSum"+id).innerHTML = dijEgysegAr;
    }
    
    if(optional!=1){

    ///szerkezet epites    
    if(id==13){
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = (testArray[2]*2)*testArray[1];
                break;
            case 3:
                // felig kontyolt nyereg 
                szerkezet = M5;
                break;
            default:
                // code block
        }
        
        egyseg(id,szerkezet,egysegar,dijegyseg)        
    }

    //Para atereszto
    if(id==14){
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = (testArray[2]*2)*testArray[1];
                break;
            case 3:
                // felig kontyolt nyereg                
                szerkezet = M5;
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)        
    }

    //Ereszalj dobozolt
    if(id==15){
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = M4;
                break;
            case 3:
                szerkezet = M4;
                break;
            default:
                // code block
                }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    //Ereszalj latszo
    if(id==16){
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = M4; 
                break;
            case 3:
                szerkezet = M4;
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==17){ //emeletek
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = parseInt(testArray[3]); 
                break;
            case 3:
                szerkezet =parseInt(testArray[3]);
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==18){ //allvanyozas
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = (M4*(parseInt(testArray[3])+1)*3); //M4*(N2+1)*3
                break;
            case 3:
                szerkezet = (M4*(parseInt(testArray[3])+1)*3);//=M4*(N2+1)*3
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==19){ //szuk zsindely eltav
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = parseInt(testArray[2]); 
                break;
            case 3:
                szerkezet = 4*parseInt(testArray[5])+parseInt(testArray[6]);//=4*P2+Q2
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }
    if(id==20){ //Deszka surites
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = (testArray[2]*2)*testArray[1]; 
                break;
            case 3:
                szerkezet = M5;
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==21){ //OSB
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = (testArray[2]*2)*testArray[1]; 
                break;
            case 3:
                szerkezet = M5;
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==22){ //Csatornazas
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = M4; 
                break;
            case 3:
                szerkezet = M4;
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==23){ //aluminium
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = (testArray[2]*2)*testArray[1]; 
                break;
            case 3:
                szerkezet = M4;
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==24){ //alatet lemez
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = parseInt((testArray[2]*2)*testArray[1])*1.1; 
                break;
            case 3:
                szerkezet = M5*1.1;
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==25){ //Rovarhalo
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = parseInt(testArray[2]*2); 
                break;
            case 3:
                szerkezet = M4;
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==26){ //Oromszego lemez
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = parseInt(testArray[1]*4); 
                break;
            case 3:
                szerkezet = 4*(testArray[1]-P8); //=4*(L2-P8)
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==27){ //Garancias zsindely
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = (testArray[2]*2)*testArray[1]; 
                break;
            case 3:
                szerkezet = M5;
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==28){ //hofogok
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = (testArray[2]*2)*3; 
                break;
            case 3:
                szerkezet = parseInt(testArray[2]*3);
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==29){ //gerinc szellozo
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = parseInt(testArray[2]*2); 
                break;
            case 3:
                szerkezet = parseInt(testArray[6]);
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==30){ //szeg
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = parseInt((testArray[2]*2)*testArray[1])/100; 
                break;
            case 3:
                szerkezet = parseFloat(M5/100);
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==31){ //sitt
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = parseInt((testArray[2]*2)*testArray[1])/25; 
                break;
            case 3:
                szerkezet = parseFloat(M5/25);
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==32){ //zsindely ragaszto
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = (parseInt((testArray[2]*2)*testArray[1])/100)*6; 
                break;
            case 3:
                szerkezet = parseFloat(M5/100*6);
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==11){ //anyag fuvar ktg
        let szerkezet = 0; //to be filled
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==33){ //kezdozsindely
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = (testArray[2]*2)*parseInt(testArray[1]); 
                break;
            case 3:
                szerkezet = M4;
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==34){ //mobilvc
        let szerkezet = 0; //to be filled
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==35){ //kiszallas
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = (parseInt((testArray[2]*2)*testArray[1])/10)*testArray[1]; 
                break;
            case 3:
                szerkezet = M5/10*parseInt(testArray[4]);
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==36){ //pontszellozo
        let szerkezet = 0;
        switch(roofId) {
            case 3:
                szerkezet = 4; 
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    if(id==37){ //el kupozas
        let szerkezet = 0;
        switch(roofId) {
            case 3:
                szerkezet = parseFloat(testArray[5])*4; 
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    }

    
}

function egyseg(id,egyseg,egysegar,dijegyseg){

    var egysegAr = egyseg*egysegar;
        var dijEgysegAr = egyseg*dijegyseg;

    _(id).innerHTML = egyseg;
    _("anyag"+id).innerHTML = egysegar;
        _("dij"+id).innerHTML = dijegyseg;
        _("anyagSum"+id).innerHTML = egysegAr;
        _("dijSum"+id).innerHTML = dijEgysegAr;
}


//getSummary();
    </script>
    </body>
</html>
