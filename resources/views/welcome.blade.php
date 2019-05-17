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
    max-height: 150vh;
    font-size: 0.9vw;
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
        let testArray = [];
        let tempArray = [];
        let optionalValues = {};
        let egysegFullSum = 0;
        let dijFulSum = 0;
        let anyagmozgatas = 0;
        let fuvarKoltseg = 0;
        let optionals = "";


        function _(id){
            return document.getElementById(id);
        }

        //*********************roofs & forms***********************/
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

           function getConnector(id){
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

         

    function storeMain(name, id, roofId){        
        let inputValue = document.getElementById(name).value;
        testArray[id] = inputValue;      
    }

///*****************************Optional page****************************************//////
    function getOptional(e, roofId) {
        e.preventDefault();
        console.log("Roof id: "+roofId);
        _("main-row").innerHTML = "";

        let optionals = ""

        optionals += '<div class="table-responsive">'+
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

    function optionalSumFunc(id){         
        let amount = _(id).value;
        optionalValues['id'+id]=id;
        optionalValues[id]= amount;      
        let anyag = (amount * parseInt(_("egysegar"+id).innerHTML));
        let dijEgyseg = (amount * parseInt(_("dijegysegre"+id).innerHTML));

        _("anyagSum"+id).value=anyag;
        _("sum"+id).value=dijEgyseg;  
        
    }

 /////////////***************************The summary page start here*********************************///////////////   
function getSummary(e,roofId){
    console.log("Roof id: "+roofId);
    e.preventDefault();
    _("main-row").innerHTML = "";
        
   
        optionals += '<div class="table-responsive">'+
    '<table class="table table-striped table-sm sum-table col-md-12"><thead><tr>'+
    '<th>Tétel szövege</th><th>Egység</th><th>Mennyiseg</th><th>Anyag egységár (Ft)</th><th>Díj egységre (Ft)</th><th>Anyag összesen (Ft)</th><th>Díj összesen (Ft)</th>'+
    '</tr></thead><tbody class="inner">';

    //fetch('http://localhost:8000/api/kalks')
    fetch('http://142.93.170.119/api/kalks')
        .then((res) => res.json())
        .then((data) => {                        
            data.data.forEach(function (optional) {                
                mennyiseg = ((optional.id == optionalValues['id'+optional.id])? parseInt(optionalValues[optional.id]) : 0);
                let something = '<tr><td>'+optional.title+'</td><td>'+optional.egyseg+'</td>'+
                                '<td id="'+optional.id+'">'+mennyiseg+'</td>'+
                                '<td id="anyag'+optional.id+'"></td>'+
                                '<td id="dij'+optional.id+'"></td>'+
                                '<td id="anyagSum'+optional.id+'"></td>'+
                                '<td id="dijSum'+optional.id+'"></td>'+
                                '</tr>';
                 $(".inner").append(something); 
                 calculator(optional.id, optional.egysegar, optional.dijegysegre,optional.opcionalis,roofId)
    })         
        })
        optionals += '</tbody><tr><td>Mindösszesen nettó: </td><td colspan="4"></td><td><span id="AnyagGTotal"></span></td><td><span id="DijBGTotal"></span></td></tr>'+
                        '<tr><td>Mindösszesen bruttó: </td><td colspan="4"></td><td><span id="BAnyagGTotal"></span></td><td><span id="BDijBGTotal" ></span></td></tr>'+
                           '</table></div>'; 
    _("main-row").innerHTML = optionals;
    console.log(optionalValues);
}


/**********************************************Calculator for the sum page********************************************/
function calculator(id, egysegar,dijegyseg,optional,roofId){
let M5 = 0;
let M4 = parseFloat(2 * testArray[2]).toFixed(2);//M4 =2*M2
let P8 = 0;

/****************Formulas****************/
   
if(roofId==3){
    P8 = Math.sqrt(testArray[5]*testArray[5]-Math.pow(((testArray[2]-testArray[6])/2),2));
    //P7 = (L2*M2-2*P8)
    let P7 = testArray[1]*testArray[2]-2*P8;
    //M8 = P2+R2/2
    let M8 = parseFloat(testArray[5])+(parseFloat(testArray[8]/2));
    //M6 = SQRT(M8*(M8-P2)*(M8-P2)*(M8-R2))
    let M6 = Math.sqrt(M8*(M8-testArray[5])*(M8-testArray[5])-(M8-testArray[8]));                
    //M5 = 2*(P7+M6)
     M5 = parseFloat( 2*(P7+M6)).toFixed(2);
     
     

    console.log("P8 = " +P8);
    console.log("P7 = " +P7);
    console.log("M8 = " +M8);    
    console.log("M6 = " +M6);
    console.log("M5 = " +M5);

    console.log("Roof id: "+roofId);
}

//***********************Calculator for optionals*******************************/
    if(optional==1){
        var egysegAr = optionalValues[id]*egysegar;
        var dijEgysegAr = optionalValues[id]*dijegyseg;
        _("anyag"+id).innerHTML = parseInt(egysegar);
        _("dij"+id).innerHTML = parseInt(dijegyseg);
        _("anyagSum"+id).innerHTML = parseFloat(egysegAr).toFixed(2);
        _("dijSum"+id).innerHTML = parseFloat(dijEgysegAr).toFixed(2);
        if(optionalValues[id]>0){
            anyagmozgatas = parseFloat(anyagmozgatas) + parseFloat(egysegar);
        }
        
    }
    
    if(optional!=1){

    ///szerkezet epites    
    if(id==13){
        let szerkezet = 0;
        switch(roofId) {
            case 2:
                // nyereg teteo
                szerkezet = parseFloat((testArray[2]*2)*testArray[1]).toFixed(2);
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
                szerkezet = ((testArray[2]*2)*testArray[1]).toFixed(2);
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
                szerkezet = parseFloat(parseFloat(testArray[3]).toFixed(2)).toFixed(2); 
                break;
            case 3:
                szerkezet =parseFloat(parseFloat(testArray[3]).toFixed(2)).toFixed(2);
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
                szerkezet = parseFloat(M4*(testArray[3]+1)*3).toFixed(2); //M4*(N2+1)*3
                break;
            case 3:
                szerkezet = parseFloat(M4*(testArray[3]+1)*3).toFixed(2);//=M4*(N2+1)*3
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
                szerkezet = parseFloat(testArray[2]); 
                break;
            case 3:
                szerkezet = parseFloat(4*parseFloat(testArray[5])+parseFloat(testArray[6])).toFixed(2);//=4*P2+Q2
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
                szerkezet = parseFloat(((testArray[2]*2)*testArray[1])).toFixed(2); 
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
                szerkezet = parseFloat((testArray[2]*2)*testArray[1]).toFixed(2); 
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
                szerkezet = parseFloat((testArray[2]*2)*testArray[1]).toFixed(2); 
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
                szerkezet = parseFloat(parseFloat((testArray[2]*2)*testArray[1])*1.1).toFixed(2); 
                break;
            case 3:
                szerkezet = parseFloat(M5*1.1).toFixed(2);
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
                szerkezet = parseFloat(testArray[2]*2).toFixed(2); 
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
                szerkezet = parseFloat(parseFloat(testArray[1]*4).toFixed(2)).toFixed(2); 
                break;
            case 3:
                szerkezet = parseFloat(4*(testArray[1]-P8)).toFixed(2); //=4*(L2-P8)
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
                szerkezet = parseFloat((testArray[2]*2)*testArray[1]).toFixed(2); 
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
                szerkezet = parseFloat((testArray[2]*2)*3); 
                break;
            case 3:
                szerkezet = parseFloat(testArray[2]*3).toFixed(2);
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
                szerkezet = parseFloat(parseFloat(testArray[2]*2)).toFixed(2); 
                break;
            case 3:
                szerkezet = parseFloat(testArray[6]).toFixed(2);
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
                szerkezet = parseFloat(parseFloat((testArray[2]*2)*testArray[1])/100).toFixed(2); 
                break;
            case 3:
                szerkezet = parseFloat(M5/100).toFixed(2);
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
                szerkezet = parseFloat(parseFloat((testArray[2]*2)*testArray[1])/25).toFixed(2); 
                break;
            case 3:
                szerkezet = parseFloat(M5/25).toFixed(2);
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
                szerkezet = parseFloat((parseFloat((testArray[2]*2)*testArray[1])/100)*6).toFixed(2); 
                break;
            case 3:
                szerkezet = parseFloat(M5/100*6).toFixed(2);
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
                szerkezet = parseFloat((testArray[2]*2)*parseFloat(testArray[1])).toFixed(2); 
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
                szerkezet = parseFloat((parseFloat((testArray[2]*2)*testArray[1])/10)*testArray[1]).toFixed(2); 
                break;
            case 3:
                szerkezet = parseFloat(M5/10*parseFloat(testArray[4])).toFixed(2);
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
                szerkezet = parseFloat(testArray[5]*4).toFixed(2); 
                break;
            default:
                // code block
        }
        egyseg(id,szerkezet,egysegar,dijegyseg)
    }

    }    
    
}

//**********************Calculator for non optionals***********************************///
function egyseg(id,egyseg,egysegar,dijegyseg){
    
    var sumEgysegAr = egyseg*egysegar;
    var dijEgysegAr = egyseg*dijegyseg;

    if(egyseg != 0){
    anyagmozgatas = parseFloat(anyagmozgatas) + parseFloat(egysegar);
    }

    egysegFullSum = egysegFullSum + sumEgysegAr;
    dijFulSum = dijFulSum + dijEgysegAr;
        

    _(id).innerHTML = egyseg;
    _("anyag"+id).innerHTML = parseInt(egysegar);
        _("dij"+id).innerHTML = parseInt(dijegyseg);

        _("anyagSum"+id).innerHTML = parseFloat(sumEgysegAr).toFixed(2);
        _("dijSum"+id).innerHTML = parseFloat(dijEgysegAr).toFixed(2);

        _("AnyagGTotal").innerHTML = parseFloat(egysegFullSum).toFixed(2);
        _("DijBGTotal").innerHTML = parseFloat(dijFulSum).toFixed(2);

        _("BAnyagGTotal").innerHTML = (egysegFullSum*1.25).toFixed(2);
        _("BDijBGTotal").innerHTML = (dijFulSum*1.25).toFixed(2);

        if(id > 12){
        _("11").innerHTML = parseFloat(anyagmozgatas*0.1).toFixed(2);
        _("12").innerHTML = parseFloat(anyagmozgatas*0.05).toFixed(2);
        }

}


/********************Original fuvarmazg calulator*****************/
function fuvarmozg(id){
    let beszerzes = parseFloat(_("egysegar11").innerHTML);
    let mozgatas = parseFloat(_("egysegar12").innerHTML); 
    
    if(tempArray.indexOf(id)<0){
        tempArray.push(id);
        beszerzes = beszerzes + (0.1 * parseFloat(_("egysegar"+id).innerHTML));
        mozgatas = mozgatas + (0.05 * parseFloat(_("egysegar"+id).innerHTML));
    }

    if(tempArray.indexOf(id)>-1 && _("mennyiseg"+id).value == 0){
        delete tempArray[tempArray.indexOf(id)];

        beszerzes = beszerzes - (0.1 * parseFloat(_("egysegar"+id).innerHTML));
        mozgatas = mozgatas - (0.05 * parseFloat(_("egysegar"+id).innerHTML));
    }
}
    </script>
    </body>
</html>
