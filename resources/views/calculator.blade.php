<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        
        <link rel="stylesheet" href="{{ URL::asset('css/main.css') }}" />
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
        .hide{
            display: hidden;
        }    
    </style>
    </head>
    <body>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="#">Navbar</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>
                  
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                          <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="/roofcalculator">Roof calculator</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#">Articles</a>
                        </li>             
                        <li class="nav-item">
                          <a class="nav-link" href="#">Contact Us</a>
                        </li>                                  
                      </ul>                      
                    </div>
                  </nav>
        <div class="container-fluid">            
                <div class="row col col-md-12 main-row mb-5" id="main-row">
                        <div class="col col-md-8 flex-container mb-5" id="main">
                                
                        </div>
                        <div class="col col-md-4 flex-container" id="main-side">
                                <div class="row">
                                        <div class="col-sm-6 form-side" id="form-side">
                                                                      
                                                          
                                        </div>                                        
                                      </div>
                        </div>
                </div>
                
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        
        <footer class="pt-4 my-md-5 pt-md-5 border-top mt-5" style="margin-top:90vh;">
                <div class="row">
                  <div class="col-12 col-md">
                    <img class="mb-2" src="/docs/4.3/assets/brand/bootstrap-solid.svg" alt="" width="24" height="24">
                    <small class="d-block mb-3 text-muted">&copy; 2017-2019</small>
                  </div>
                  <div class="col-6 col-md">
                    <h5>Features</h5>
                    <ul class="list-unstyled text-small">
                      <li><a class="text-muted" href="#">Cool stuff</a></li>
                      <li><a class="text-muted" href="#">Random feature</a></li>
                      <li><a class="text-muted" href="#">Team feature</a></li>
                      <li><a class="text-muted" href="#">Stuff for developers</a></li>
                      <li><a class="text-muted" href="#">Another one</a></li>
                      <li><a class="text-muted" href="#">Last time</a></li>
                    </ul>
                  </div>
                  <div class="col-6 col-md">
                    <h5>Resources</h5>
                    <ul class="list-unstyled text-small">
                      <li><a class="text-muted" href="#">Resource</a></li>
                      <li><a class="text-muted" href="#">Resource name</a></li>
                      <li><a class="text-muted" href="#">Another resource</a></li>
                      <li><a class="text-muted" href="#">Final resource</a></li>
                    </ul>
                  </div>
                  <div class="col-6 col-md">
                    <h5>About</h5>
                    <ul class="list-unstyled text-small">
                      <li><a class="text-muted" href="#">Team</a></li>
                      <li><a class="text-muted" href="#">Locations</a></li>
                      <li><a class="text-muted" href="#">Privacy</a></li>
                      <li><a class="text-muted" href="#">Terms</a></li>
                    </ul>
                  </div>
                </div>
              </footer>           
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
let orderId = 0;
let eamilfield = "";
//the toggle calculated fields
let addToFinalToggle = [];
let finalOptionals = [15,16,19,21,22,23,24,25,26,27,28,32,33,36,37,38,39];


//**********************Calculator for none optionals***********************************///
function egyseg(id,egyseg,egysegar,dijegyseg){
    var sumEgysegAr = egyseg*egysegar;
    var dijEgysegAr = egyseg*dijegyseg;
    

    //The final amount
    if(!finalOptionals.includes(id,0)){
        egysegFullSum = egysegFullSum + sumEgysegAr;
        dijFulSum = dijFulSum + dijEgysegAr;
    }

    console.log('egyseg value:'+egyseg);

    _(id).innerHTML = egyseg;
    _("anyag"+id).innerHTML = parseInt(egysegar);
    _("dij"+id).innerHTML = parseInt(dijegyseg);

    _("anyagSum"+id).innerHTML = parseInt(sumEgysegAr);
    _("dijSum"+id).innerHTML = parseInt(dijEgysegAr);

    _("AnyagGTotal").innerHTML = parseInt(egysegFullSum);
    _("DijBGTotal").innerHTML = parseInt(dijFulSum);

    //The anyagbeszerzes & fuvarkoltseg
    if(parseInt(egyseg) > 0 && !finalOptionals.includes(id,0)){
     anyagmozgatas = parseInt(egysegFullSum);
    }

    _("BAnyagGTotal").innerHTML = parseInt(egysegFullSum*1.25);
    _("BDijBGTotal").innerHTML = parseInt(dijFulSum*1.25);


    if(id > 12){
        _("11").innerHTML = parseInt(anyagmozgatas*0.1);
        _("12").innerHTML = parseInt(anyagmozgatas*0.05);        
    }   
    if(egyseg==0){
        _("sum_row_"+id).className = " hide";
    }
    
}

function _(id){
    return document.getElementById(id);    
}

//*********************roofs & forms***********************/
function getRoofs() {
    let toappend = "";
    fetch('http://142.93.170.119/api/roofs')
    //fetch('http://localhost:8000/api/roofs')    
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
    console.log(id);
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
    //to make sure the filds are in
    let countFields = 0;
    _("form-side").innerHTML = " ";
    formfields = " ";
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
                        formfields += `<div class="form-group"><label for="${field.fieldName}">${field.fieldName}</label>`+
                            `<input id="${field.fieldName}" type="text" name="${field.fieldName}" class="form-control" onblur="storeMain('${field.fieldName}','${field.id}')"></div>`;                                                                                                                                                                      
                    }
                })
                formfields += '<button class="btn btn-primary" onclick="getOptional(event,'+imgId+')">Elküld</button></form></p></div></div>';
               
                if(formfields.length<300){
                    getForm(id,imgId)
                }else{
                    _("form-side").innerHTML = formfields;
                }
        })
}    

function storeMain(name, id, roofId){        
    if(!minusFieldValidation(name)){
        alert("The field value has to be bigger than 0!")
    }else{ 
    let inputValue = document.getElementById(name).value;
    testArray[id] = inputValue;   
    }     

    }

    ///*****************************Optional page****************************************//////
    function getOptional(e, roofId) {

        /***Generate random job id**/
        orderId = Math.floor(Math.random() * (199896 - roofId) + roofId);        
    e.preventDefault();
    _("main-row").innerHTML = "";

    let optionals = "";

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
                        optionals += `<tr id="row_${optional.id}"><td>${optional.title}</td><td>`+
                        `<input type="text" class="form-control" id="${optional.id}" placeholder="0" onkeyup="optionalSumFunc(${optional.id})"></td>`+
                        `<td>${optional.egyseg}</td><td id="egysegar${optional.id}">${optional.egysegar}</td><td id="dijegysegre${optional.id}">${optional.dijegysegre}</td>`+
                        `<td><input type="text" class="form-control" id="anyagSum${optional.id}" placeholder="0" disabled></td>`+
                        `<td><input type="text" class="form-control" id="sum${optional.id}" placeholder="0" disabled></td></tr>`;                        
                    }
        })
                    
        optionals += '</tbody></table><button class="btn btn-success btn-lg" onclick="getSummary(event,'+roofId+')">Tovabb</button></div>';
        _("main-row").innerHTML = optionals;
            })   
}

function minusFieldValidation(id){
    if(_(id).value<0){
        _(id).value = "";
        _(id).style = "border: none;border: 1px solid red";
        return false;
    }
    else{
        _(id).style = "border: 1px solid #ddd";
        return true;
    }
}

/**This is for the optionals page**/
function optionalSumFunc(id){ 
    if(!minusFieldValidation(id)){
        alert("The field value has to be bigger than 0!")
    }else{
        let amount = _(id).value;
            optionalValues['id'+id]=id;
            optionalValues[id] = amount; 
            let anyag = (amount * parseInt(_("egysegar"+id).innerHTML));
            let dijEgyseg = (amount * parseInt(_("dijegysegre"+id).innerHTML));

            _("anyagSum"+id).value=parseInt(anyag);
            _("sum"+id).value=parseInt(dijEgyseg);
    }

}


/////////////***************************The summary page start here*********************************///////////////   
function getSummary(e,roofId){   
    _("main-row").innerHTML = "";

    optionals += '<div class="table-responsive">'+
    '<table class="table table-striped table-sm sum-table col-md-12" id="main_table"><thead><tr>'+
    '<th>Tétel szövege</th><th>Klick ha keri</th><th>Egység</th><th>Mennyiseg</th><th>Anyag egységár (Ft)</th><th>Díj egységre (Ft)</th><th>Anyag összesen (Ft)</th><th>Díj összesen (Ft)</th>'+
    '</tr></thead><tbody class="inner">';

    //fetch('http://localhost:8000/api/kalks')
   fetch('http://142.93.170.119/api/kalks')
    .then((res) => res.json())
    .then((data) => {                        
        data.data.forEach(function (optional) {        
        //get the optional values    
        mennyiseg = ((optional.id == optionalValues['id'+optional.id])? parseInt(optionalValues[optional.id]) : 0);
        if(mennyiseg !=0||(optional.opcionalis != 1)){    
            let something = '<tr id="sum_row_'+optional.id+'"><td>'+optional.title+'</td>'+
                '<td>'+
                    ((finalOptionals.includes(optional.id,0))? '<button class="btn btn-outline-dark btn-sm" data-toggle="button" onclick="addToFinal('+optional.id+',event)" id="addToFinal_'+optional.id+'">+</button>':'')+
                '</td>'+
                '<td>'+optional.egyseg+'</td>'+
                '<td id="'+optional.id+'"  class="egysegVal">'+mennyiseg+'</td>'+
                '<td id="anyag'+optional.id+'"></td>'+
                '<td id="dij'+optional.id+'"></td>'+
                '<td id="anyagSum'+optional.id+'"></td>'+
                '<td id="dijSum'+optional.id+'"></td>'+
                '</tr>';
                    $(".inner").append(something);                     
                    calculator(optional.id, optional.egysegar, optional.dijegysegre,optional.opcionalis,roofId)
        }
    })         
    })
    //***Total value at the end***//
    optionals += `</tbody><tr><td>Mindösszesen nettó: </td><td colspan="5"></td><td><span id="AnyagGTotal"></span></td><td><span id="DijBGTotal"></span></td></tr>`+
                    `<tr><td>Mindösszesen bruttó: </td><td colspan="5"></td><td><span id="BAnyagGTotal"></span></td><td><span id="BDijBGTotal" ></span></td></tr>`+
                        `</table></div><div id="emaildiv" class="email">`+
                            `<form id="emailform" name="emailform" method="POST" action="{{ action('HomeController@sendOrder') }}" accept-charset="UTF-8">`+
                                `{{ csrf_field() }}`+
                                `<input type="hidden" class="form-control" id="orderId_form" name="orderId">`+
                                `<lable for="email">Email</lable>`+
                                `<input type="text" class="form-control" id="emailfield" placeholder="eamil@freemail.hu" name="email" onblur="validation()">`+
                            `</form>`+
                                `<div class="row">`+
                                `<button class="btn btn-secondary btn-block" onclick="storeOrder(event)" id="kuld">Elkuld</button></div>`; 
    _("main-row").innerHTML = optionals;
    _("orderId_form").value = orderId;

}

/*email validation*/  

function validation(){
    let email = _('emailfield').value;      
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(re.test(String(email).toLowerCase())==false){
        alert("Invalid email address!");
    }
}

/***handle the toogle fields**/
function addToFinal(id,event){
    event.preventDefault();
    event.preventDefault();
    
    sumEgysegAr = parseFloat(_("anyagSum"+id).innerHTML);
    dijEgysegAr = parseFloat(_("dijSum"+id).innerHTML);
    egyseges = parseFloat(_('anyag'+id).innerHTML);    

    //toggle the optional calculated fields
    if(!addToFinalToggle.includes(id)){
        addToFinalToggle.push(id);
        egysegFullSum = egysegFullSum + sumEgysegAr;
        dijFulSum = dijFulSum + dijEgysegAr;        
    }else{
    //remove element from the array
    addToFinalToggle = addToFinalToggle.filter(function(item) { 
        return item !== id
    })
    egysegFullSum = egysegFullSum - sumEgysegAr;
    dijFulSum = dijFulSum - dijEgysegAr; 
    }    
    

    //net total
    _("AnyagGTotal").innerHTML = parseInt(egysegFullSum);
    _("DijBGTotal").innerHTML = parseInt(dijFulSum);

    _("11").innerHTML = parseInt(parseFloat(egysegFullSum).toFixed(2)*0.1);
    _("12").innerHTML = parseInt(parseFloat(egysegFullSum).toFixed(2)*0.05);

    //brut total
    _("BAnyagGTotal").innerHTML = parseInt(egysegFullSum*1.25);
    _("BDijBGTotal").innerHTML = parseInt(dijFulSum*1.25);

}



function storeOrder(event){
    event.preventDefault();
    var orders = [];

    var item = {};
        $(".egysegVal").each(function() {
            if(this.innerHTML != '0' && !finalOptionals.includes(parseInt(this.id),0)) {
                item = {
                    'orderId' : orderId,
                    'productId' : this.id.toString(),
                    'mennyiseg' : document.getElementById(this.id).innerHTML
                    }
                orders.push(item);
            }

            if(addToFinalToggle.includes(parseInt(this.id),0)){
                item = {
                    'orderId' : orderId,
                    'productId' : this.id.toString(),
                    'mennyiseg' : document.getElementById(this.id).innerHTML
                    }
                orders.push(item);
            }
        });
        //console.log(orders);
    
   //fetch('http://localhost:8000/api/order', {
   fetch('http://142.93.170.119/api/order',{    
       method:'POST',
       headers:{
           'Accept': 'application/json, text/plain, */*',
           'Content-type': 'application/json'
       },
       body:JSON.stringify(orders)
   })
   .then((res)=>res.json())
   .then((data) => console.log(data))
   .then(function(){       
       $("#emailform" ).submit();
  })   
   _("main_table").className=" hide";

}


</script>
<script type="text/javascript" src="{{ URL::asset('js/formulas.js') }}"></script>
</body>
</html>