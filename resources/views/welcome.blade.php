<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script type="text/javascript" src="{{ URL::asset('js/formulas.js') }}"></script>
        <link rel="stylesheet" href="{{ URL::asset('css/main.css') }}" />
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
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
let roofId = 0;
let elkuld = 0;


function _(id){
    return document.getElementById(id);
}

//*********************roofs & forms***********************/
function getRoofs() {
    let toappend = "";
    fetch('http://localhost:8000/api/roofs')// http://142.93.170.119/api/roofs 
    //fetch('http://142.93.170.119/api/roofs')
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
    roofId = id;
    let fields = [];
    fetch('http://localhost:8000/api/FieldRoofConnector/'+id)
    //fetch('http://142.93.170.119/api/FieldRoofConnector/'+id)
        .then((res) => res.json())
        .then((data) => {
            data.data.forEach(function (field) {
                fields.push(field.fieldId);
        });                
            })
    getForm(fields,id);
}

function getForm(id,imgId) { 
    //to make sure the filds are in
    let countFields = 0;
    _("form-side").innerHTML = " ";
    formfields = " ";
    let img = _(imgId).innerHTML.replace(/ /g, '').toLowerCase();
    formfields +='<div class="card card-form" style="width: 18rem;">'+
            '<img src="../img/'+img+'calc.jpg" alt="" class="card-img-top">'+
            '<div class="card-body">'+
            '<p class="card-text"><form>';
    fetch('http://localhost:8000/api/fields')
    //fetch('http://142.93.170.119/api/fields')
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
    _("main-row").innerHTML = "";

    let optionals = "";

    optionals += '<div class="table-responsive">'+
            '<table class="table table-striped table-sm"><thead><tr>'+
            '<th>Tétel szövege</th><th>Mennyiseg</th><th>Egység</th>'+
            '<th>Anyag egységár (Ft)</th><th>Díj egységre (Ft)</th><th>Anyag összesen (Ft)</th><th>Díj összesen (Ft)</th></tr></thead><tbody>';
        fetch('http://localhost:8000/api/kalks')
        //fetch('http://142.93.170.119/api/kalks')
            .then((res) => res.json())
            .then((data) => {
                data.data.forEach(function (optional) {
                    if(optional.opcionalis == 1){
                        optionals += `<tr><td>${optional.title}</td><td>`+
                        `<input type="text" class="form-control" id="${optional.id}" placeholder="0" onkeyup="optionalSumFunc(${optional.id})"></td>`+
                        `<td>${optional.egyseg}</td><td id="egysegar${optional.id}">${optional.egysegar}</td><td id="dijegysegre${optional.id}">${optional.dijegysegre}</td>`+
                        `<td><input type="text" class="form-control" id="anyagSum${optional.id}" placeholder="0"></td>`+
                        `<td><input type="text" class="form-control" id="sum${optional.id}" placeholder="0"></td></tr>`;
                    }
        })
                    
        optionals += '</tbody></table><button class="btn btn-success btn-lg" onclick="getSummary(event,'+roofId+')">Tovabb</button></div>';
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
    console.log(optionalValues)
    e.preventDefault();
    _("main-row").innerHTML = "";


    optionals += '<div class="table-responsive">'+
    '<table class="table table-striped table-sm sum-table col-md-12" id="main_table"><thead><tr>'+
    '<th>Tétel szövege</th><th>Klick ha keri</th><th>Egység</th><th>Mennyiseg</th><th>Anyag egységár (Ft)</th><th>Díj egységre (Ft)</th><th>Anyag összesen (Ft)</th><th>Díj összesen (Ft)</th>'+
    '</tr></thead><tbody class="inner">';

    fetch('http://localhost:8000/api/kalks')
    //fetch('http://142.93.170.119/api/kalks')
    .then((res) => res.json())
    .then((data) => {                        
        data.data.forEach(function (optional) {
        
        //get the optional values                
        mennyiseg = ((optional.id == optionalValues['id'+optional.id])? parseInt(optionalValues[optional.id]) : 0);
            let something = '<tr><td>'+optional.title+'</td>'+
                            '<td>'+
                                ((finalOptionals.includes(optional.id,0))? '<button class="btn btn-outline-dark btn-sm" data-toggle="button" onclick="addToFinal('+optional.id+')" id="addToFinal_'+optional.id+'">+</button>':'')+
                            '</td>'+
                            '<td>'+optional.egyseg+'</td>'+
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
    optionals += '</tbody><tr><td>Mindösszesen nettó: </td><td colspan="5"></td><td><span id="AnyagGTotal"></span></td><td><span id="DijBGTotal"></span></td></tr>'+
                    '<tr><td>Mindösszesen bruttó: </td><td colspan="5"></td><td><span id="BAnyagGTotal"></span></td><td><span id="BDijBGTotal" ></span></td></tr>'+
                        '</table></div><div id="email" class="email"><lable for="email">Email</lable><input type="text" class="form-control" id="email" placeholder="eamil@freemail.hu"><div class="row"><button class="btn btn-secondary btn-block" onclick="createOrder(event,'+roofId+')">Elkuld</button></div>'; 
    _("main-row").innerHTML = optionals;

}

//on elkuld
function createOrder(event, roofId){
    elkuld = 1; 
    getSummary(event, roofId)
}


//the toggle calculated fields
let addToFinalToggle = [];
let finalOptionals = [15,16,19,21,22,23,24,25,26,27,28,32,33,36,37,38,39];
function addToFinal(id){
    sumEgysegAr = parseFloat(_("anyagSum"+id).innerHTML);
    dijEgysegAr = parseFloat(_("dijSum"+id).innerHTML);
    egyseg = parseFloat(_('anyag'+id).innerHTML);    

    //toggle the optional calculated fields
    if(!addToFinalToggle.includes(id)){
        addToFinalToggle.push(id);
        egysegFullSum = egysegFullSum + sumEgysegAr;
        dijFulSum = dijFulSum + dijEgysegAr;
        anyagmozgatas = parseFloat(anyagmozgatas) + egyseg;
    }else{
    //remove element from the array
    addToFinalToggle = addToFinalToggle.filter(function(item) { 
        return item !== id
    })
    egysegFullSum = egysegFullSum - sumEgysegAr;
    dijFulSum = dijFulSum - dijEgysegAr;
    anyagmozgatas = parseFloat(anyagmozgatas) - egyseg;
    }    

    //anyagbeszerzes/mozgatas
    _("11").innerHTML = parseFloat(anyagmozgatas*0.1).toFixed(2);
    _("12").innerHTML = parseFloat(anyagmozgatas*0.05).toFixed(2);

    //net total
    _("AnyagGTotal").innerHTML = parseFloat(egysegFullSum).toFixed(2);
    _("DijBGTotal").innerHTML = parseFloat(dijFulSum).toFixed(2);

    //brut total
    _("BAnyagGTotal").innerHTML = (egysegFullSum*1.25).toFixed(2);
    _("BDijBGTotal").innerHTML = (dijFulSum*1.25).toFixed(2);    


}


//**********************Calculator for non optionals***********************************///
function egyseg(id,egyseg,egysegar,dijegyseg){

    var sumEgysegAr = egyseg*egysegar;
    var dijEgysegAr = egyseg*dijegyseg;


    //The anyagbeszerzes & fuvarkoltseg
    if(parseInt(egyseg) > 0 && !finalOptionals.includes(id,0)){
    anyagmozgatas = parseFloat(anyagmozgatas) + parseFloat(egysegar);      

    }

    //The final amount
    if(!finalOptionals.includes(id,0)){
    egysegFullSum = egysegFullSum + sumEgysegAr;
    dijFulSum = dijFulSum + dijEgysegAr;
    }


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

    if(elkuld>0 && egyseg>0){
        storeOrder(parseInt(id), parseFloat(egyseg))
    }
}

function storeOrder(productId, egyseg){
    var order = new Object();  
    order.orderId = 111; 
    order.productId = productId;
    order.mennyiseg = egyseg;

    $.ajax({  
        url: 'http://localhost:8000/api/order',  
        type: 'POST',  
        dataType: 'json',  
        data: order,  
        success: console.log('success')  
        
    });
    _("main_table").className=" hide";
    _("email").className=" hide";
}
</script>
</body>
</html>
