<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        {{-- <script type="text/javascript" src="{{ URL::asset('js/formulas.js') }}"></script> --}}
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
    roofId = id;
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
        //fetch('http://localhost:8000/api/kalks')
        fetch('http://142.93.170.119/api/kalks')
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

    //fetch('http://localhost:8000/api/kalks')
    fetch('http://142.93.170.119/api/kalks')
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







/**********************************************Calculator for the sum page********************************************/

function calculator(id, egysegar,dijegyseg,optional,roofId){
    let M5 = 0;
    let M4 = parseFloat(2 * testArray[2]).toFixed(2);//M4 =2*M2
    let P8 = 0;
    let N2 = 0;
    let P2 = 0;
    let U2 = 0;
    let M2 = 0;
    let R2 = 0;
    let O2 = 0;
    let M8 = 0;
    let M6 = 0;
    let M7 = 0;
    let P7 = 0;
    let X2 = 0;
    let T2 = 0;
    let W2 = 0;
    let S2 = 0;
    let Q2 = 0;
    let O8 = 0;
    let O9 = 0;
    let O10 = 0;
    let O11 = 0;
    
    /****************Formulas****************/
       
    if(roofId==3){
        P8 = Math.sqrt(testArray[5]*testArray[5]-Math.pow(((testArray[2]-testArray[6])/2),2));
        //P7 = (L2*M2-2*P8)
        P7 = testArray[1]*testArray[2]-2*P8;
        //M8 = P2+R2/2
        M8 = parseFloat(testArray[5])+(parseFloat(testArray[8]/2));
        //M6 = SQRT(M8*(M8-P2)*(M8-P2)*(M8-R2))
        M6 = Math.sqrt(M8*(M8-testArray[5])*(M8-testArray[5])-(M8-testArray[8]));                
        //M5 = 2*(P7+M6)
        M5 = parseFloat( 2*(P7+M6)).toFixed(2);
    }
    
    if(roofId == 4){
        U2 = parseFloat(testArray[6]);
        M2 = parseFloat(testArray[2]);
        P2 = parseFloat(testArray[5]);
        R2 = parseFloat(testArray[9]);
        N2 = parseInt(testArray[3]);
        O2 = parseFloat(testArray[4]);
        M4 = 2*(M2+R2);
        //=P2 + R2/2
        M8 = P2 + R2/2;
        //=SQRT(M8*(M8-P2)*(M8-P2)*(M8-R2))
        M6 = Math.sqrt(M8*(M8-P2)*(M8-P2)*(M8-R2));
        //=((M2+U2)/(4*(M2-U2)))*SQRT((M2-U2)*(M2-U2)*(M2+U2)*(-M2+U2+(P2*2))
        M7 = ((M2+U2)/(4*(M2-U2)))*Math.sqrt((M2-U2)*(M2-U2)*(M2+U2)*(-M2+U2+(P2*2)));
        //=2*(M7+M6)
        M5 = 2*(M7+M6);
    }
    
    
    if(roofId == 5){
        M2 = parseFloat(testArray[2]);
        N2 = parseInt(testArray[3]);
        P2 = parseFloat(testArray[5]);
        M4 = parseFloat(testArray[2])*4;
        O2 = parseFloat(testArray[4]);
        //=P2+M2/2
        M8 = P2+M2/2;
        //=SQRT(M8*(M8-P2)*(M8-P2)*(M8-M2))
        M6 =Math.sqrt(M8*(M8-P2)*(M8-P2)*(M8-M2));
        //4*M6
        M5 =4*M6;
    }
    
    if(roofId == 6){
        L2 = parseFloat(testArray[1]);
        M2 = parseFloat(testArray[2]);
        O2 = parseFloat(testArray[4]);
        N2 = parseInt(testArray[3]);
        R2 = parseFloat(testArray[13]);
        M5 =L2*M2;
    }
    
    if(roofId == 7){
        L2 = parseFloat(testArray[1]);
        M2 = parseFloat(testArray[2]);
        N2 = parseInt(testArray[3]);
        O2 = parseFloat(testArray[4]);
        M4 = M2*2;
        M5 = L2*M2*2;
    }
    
    if(roofId == 8){
        
        L2 = parseFloat(testArray[1]);
        X2 = parseFloat(testArray[7]);
        M2 = parseFloat(testArray[2]);
        //=SQRT(pow(L2,2)+pow(X2-M2,2))
        T2 = Math.sqrt(Math.pow(L2,2)+Math.pow(X2-M2,2));
        U2 = parseFloat(testArray[6]);
        R2 = parseFloat(testArray[9]);
        V2 = parseFloat(testArray[10]);
        W2 = parseFloat(testArray[11]);
        M4 = parseFloat(M2+R2+V2+W2);
        N2 = parseInt(testArray[3]);
        O2 = parseFloat(testArray[4]);
        
        //=((x2+M2)/(4*(x2-M2)))*SQRT((x2+L2-M2+T2)*(x2-L2-M2+T2)*(x2+L2-M2-T2)*(-x2+L2+M2+T2))12
        M7 =((X2+M2)/(4*(X2-M2)))*Math.sqrt(((X2+L2-M2+T2)*(X2-L2-M2+T2)*(X2+L2-M2-T2)*(-X2+L2+M2+T2))<0 ? (((X2+L2-M2+T2)*(X2-L2-M2+T2)*(X2+L2-M2-T2)*(-X2+L2+M2+T2))*-1):((X2+L2-M2+T2)*(X2-L2-M2+T2)*(X2+L2-M2-T2)*(-X2+L2+M2+T2)));
        
        //=((U2+R2)/(4*(U2-R2)))*SQRT((U2+L2-R2+T2)*(U2-L2-R2+T2)*(U2+L2-R2-T2)*(-U2+L2+R2+T2))
        N7 = ((U2+R2)/(4*(U2-R2)))*Math.sqrt(((U2+L2-R2+T2)*(U2-L2-R2+T2)*(U2+L2-R2-T2)*(-U2+L2+R2+T2))<0? -1*((U2+L2-R2+T2)*(U2-L2-R2+T2)*(U2+L2-R2-T2)*(-U2+L2+R2+T2)):((U2+L2-R2+T2)*(U2-L2-R2+T2)*(U2+L2-R2-T2)*(-U2+L2+R2+T2)));
    
        //=((V2+U2)/(4*(V2-U2)))*SQRT((V2+L2-U2+T2)*(V2-L2-U2+T2)*(V2+L2-U2-T2)*(-V2+L2+U2+T2))
        O7 = ((V2+U2)/(4*(V2-U2)))*Math.sqrt((V2+L2-U2+T2)*(V2-L2-U2+T2)*(V2+L2-U2-T2)*(-V2+L2+U2+T2));
    
        //=((W2+X2)/(4*(W2-X2)))*SQRT((W2+L2-X2+T2)*(W2-L2-X2+T2)*(W2+L2-X2-T2)*(-W2+L2+X2+T2))
        P7=((W2+X2)/(4*(W2-X2)))*Math.sqrt((W2+L2-X2+T2)*(W2-L2-X2+T2)*(W2+L2-X2-T2)*(-W2+L2+X2+T2));
    
        //=SUM(M7+N7+O7+P7)
        M5 = (M7+N7+O7+P7);
    
        
    }
    
    if(roofId == 9){
        
        L2 = parseFloat(testArray[1]);
        X2 = parseFloat(testArray[7]);
        M2 = parseFloat(testArray[2]);
        U2 = parseFloat(testArray[6]);
        R2 = parseFloat(testArray[9]);
        N2 = parseInt(testArray[3]);
        V2 = parseFloat(testArray[10]);
        W2 = parseFloat(testArray[11]);
        O2 = parseFloat(testArray[4]);
        Y2 = parseFloat(testArray[16]);
        M4 = M2+R2+V2+W2;
        T2 = Math.sqrt(Math.pow(L2,2)+Math.pow(X2-M2,2));
        M7 = ((X2+M2)/(4*(X2-M2)))*Math.sqrt(((X2+L2-M2+T2)*(X2-L2-M2+T2)*(X2+L2-M2-T2)*(-X2+L2+M2+T2)) < 0 ? -1*((X2+L2-M2+T2)*(X2-L2-M2+T2)*(X2+L2-M2-T2)*(-X2+L2+M2+T2)):((X2+L2-M2+T2)*(X2-L2-M2+T2)*(X2+L2-M2-T2)*(-X2+L2+M2+T2)));
        N7 = ((U2+R2)/(4*(U2-R2)))*Math.sqrt(((U2+L2-R2+T2)*(U2-L2-R2+T2)*(U2+L2-R2-T2)*(-U2+L2+R2+T2)) < 0 ? -1*((U2+L2-R2+T2)*(U2-L2-R2+T2)*(U2+L2-R2-T2)*(-U2+L2+R2+T2)):((U2+L2-R2+T2)*(U2-L2-R2+T2)*(U2+L2-R2-T2)*(-U2+L2+R2+T2)));
        O7 = ((V2+U2)/(4*(V2-U2)))*Math.sqrt(((V2+L2-U2+T2)*(V2-L2-U2+T2)*(V2+L2-U2-T2)*(-V2+L2+U2+T2)) < 0 ? -1*((V2+L2-U2+T2)*(V2-L2-U2+T2)*(V2+L2-U2-T2)*(-V2+L2+U2+T2)):((V2+L2-U2+T2)*(V2-L2-U2+T2)*(V2+L2-U2-T2)*(-V2+L2+U2+T2)));
        P7 = ((W2+X2)/(4*(W2-X2)))*Math.sqrt(((W2+L2-X2+T2)*(W2-L2-X2+T2)*(W2+L2-X2-T2)*(-W2+L2+X2+T2)) < 0 ? -1*((W2+L2-X2+T2)*(W2-L2-X2+T2)*(W2+L2-X2-T2)*(-W2+L2+X2+T2)):((W2+L2-X2+T2)*(W2-L2-X2+T2)*(W2+L2-X2-T2)*(-W2+L2+X2+T2)));
        M5 = M7+N7+O7+P7;
    
    }
    
    //t alaku nyeregteto
    if(roofId == 12){
        P2 = parseFloat(testArray[9]);
        R2 = parseFloat(testArray[2]);
        Q2 = parseFloat(testArray[10]);
        L2 = parseFloat(testArray[1]);
        S2 = parseFloat(testArray[7]);
        U2 = parseFloat(testArray[11]);    
        M2 = parseFloat(testArray[2]);
        N2 = parseFloat(testArray[3])
        O8 = parseFloat(S2);
        O10 = parseFloat(U2);
        O11 = L2;
        M3 = parseFloat(M2+P2+Q2+U2*2);
        V4 = parseFloat((R2-(P2+Q2))/2);
        N8 = parseFloat(P2+V4);
        N9 = parseFloat(L2);
        N10 = parseFloat(P2);        
        T2 = parseFloat(Math.sqrt((Math.pow(V4,2)+Math.pow(L2,2)) < 0 ? -1*(Math.pow(V4,2)+Math.pow(L2,2)):(Math.pow(V4,2)+Math.pow(L2,2))));    
        O9 = T2;
        N11 = T2;    
        M8 = Q2 + V4;
        M9 = T2;
        M10 = Q2;
        M11 = L2;
        M6 = parseFloat(((M8+M10)/(4*(M8-M10)))*Math.sqrt((M8+M9-M10+M11)*(M8-M9-M10+M11)*(M8+M9-M10-M11)*(-M8+M9+M10+M11)));
        N6 = parseFloat(((N8+N10)/(4*(N8-N10)))*Math.sqrt((N8+N9-N10+N11)*(N8-N9-N10+N11)*(N8+N9-N10-N11)*(-N8+N9+N10+N11)));
        O6 = parseFloat(((O8+O10)/(4*(O8-O10)))*Math.sqrt(((O8+O9-O10+O11)*(O8-O9-O10+O11)*(O8+O9-O10-O11)*(-O8+O9+O10+O11)) < 0 ? -1*((O8+O9-O10+O11)*(O8-O9-O10+O11)*(O8+O9-O10-O11)*(-O8+O9+O10+O11)):((O8+O9-O10+O11)*(O8-O9-O10+O11)*(O8+O9-O10-O11)*(-O8+O9+O10+O11))));
        M4 = parseFloat(M6+N6+O6*2+M2*L2);
        console.log(Math.sqrt((O8+O9-O10+O11)*(O8-O9-O10+O11)*(O8+O9-O10-O11)*(-O8+O9+O10+O11)));
    
    }
    
    //this is complitly deifferent form the others as for the variable naming conventions
    if(roofId==13){
        O2 = parseFloat(testArray[13]);
        L2 = parseFloat(testArray[2]);
        N2 = parseFloat(testArray[18]); 
        P2 = parseInt(testArray[14]);
        M2 = parseInt(testArray[9]);   
        R2 = parseInt(testArray[3]); 
        S2 = parseInt(testArray[4]); 
        M3 = L2+M2;
    
        Q2 = Math.sqrt(Math.pow(O2-L2,2)+Math.pow(N2,2));
    
        console.log("q2"+Q2);
        M6 = ((O2+L2)/(4*(O2-L2)))*Math.sqrt(((O2+N2-L2+Q2)*(O2-N2-L2+Q2)*(O2+N2-L2-Q2)*(-O2+N2+L2+Q2)) < 0 ?-1*((O2+N2-L2+Q2)*(O2-N2-L2+Q2)*(O2+N2-L2-Q2)*(-O2+N2+L2+Q2)):((O2+N2-L2+Q2)*(O2-N2-L2+Q2)*(O2+N2-L2-Q2)*(-O2+N2+L2+Q2)));
        //=((N8+N10)/(4*(N8-N10)))*SQRT((N8+N9-N10+N11)*(N8-N9-N10+N11)*(N8+N9-N10-N11)*(-N8+N9+N10+N11))
        N6 = ((P2+M2)/(4*(P2-M2)))*Math.sqrt(((P2+N2-M2+Q2)*(P2-N2-M2+Q2)*(P2+N2-M2-Q2)*(-P2+N2+M2+Q2)) < 0 ? -1*((P2+N2-M2+Q2)*(P2-N2-M2+Q2)*(P2+N2-M2-Q2)*(-P2+N2+M2+Q2)) :((P2+N2-M2+Q2)*(P2-N2-M2+Q2)*(P2+N2-M2-Q2)*(-P2+N2+M2+Q2)));
        M4 = M6+N6;
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

            if(elkuld>0 && optionalValues[id]>0){
                storeOrder(id, optionalValues[id])
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
                case 4:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;  
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;  
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;    
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;    
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break; 
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;    
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M4;
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
                case 4:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;  
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;   
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M4;
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
                case 4:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break; 
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M2;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break; 
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M3;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M3;
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
                case 4:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;    
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M2;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M3;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M3;
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
                case 4:
                    szerkezet = parseInt(testArray[3]);
                    break;    
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = N2;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = N2;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = N2;
                    break; 
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = N2;
                    break;  
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = N2;
                    break; 
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = R2;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = R2;
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
                case 4:
                    szerkezet = (parseInt(testArray[3])+1)*3*M4;
                    break;   
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M4*(N2+1)*3;
                    break; 
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = (N2+1)*3*M2;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M4*(N2+1)*3;
                    break;    
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break; 
                case 9:
                    //kontyolt nyeregteto 
                    szerkezet = M4;
                    break;   
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M3*(N2+1)*3;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M3*(R2+1)*3;
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
                case 4:
                    szerkezet = 4*parseFloat(testArray[5])+parseFloat(testArray[6]);
                    break;    
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = 4*P2;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M5*0.1;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M2;
                    break;
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = U2+X2+T2;
                    break;
                case 9:
                    //kontyolt nyeregtetoR2+S2+T2
                    szerkezet = U2+X2+T2;
                    break; 
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = R2+S2+T2;
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
                case 4:
                    szerkezet = M5;
                    break;    
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;   
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break; 
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break; 
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
    
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M4;
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
                case 4:
                    szerkezet = M5;
                    break;    
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;    
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break; 
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M4;
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
                case 4:
                    szerkezet = M4;
                    break;
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M2;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;    
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;  
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M3;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M3;
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
                case 4:
                    szerkezet = M4;
                    break;
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M2;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;   
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break; 
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;     
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M3;
                    break;    
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M3;
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
                case 4:
                    szerkezet = M5*1.1;
                    break;
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M5*1.1;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M5*1.1;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M5*1.1;
                    break; 
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M5*1.1;
                    break;
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M5*1.1;
                    break; 
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M4*1.1;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M4*1.1;
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
                case 4:
                    szerkezet = M4;
                    break;
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M2;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;  
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;   
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M3;
                    break;    
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M3;
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
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = L2*2;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = L2*4;
                    break;
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = L2*4;
                    break;
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = L2*4;
                    break; 
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = L2*6;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = N2*2;
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
                case 4:
                    szerkezet = M5;
                    break;
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;   
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M5;
                    break;  
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M4;
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
                case 4:
                    szerkezet = M4*3;
                    break;
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M4*3;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M2*3;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M4*3;
                    break;   
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M4*3;
                    break; 
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M4*3;
                    break; 
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M3*3;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M3*3;
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
                case 4:
                    szerkezet = parseFloat(testArray[6]).toFixed(2);
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M2;
                    break;
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = (X2)+(U2);
                    break;
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = (X2)+(U2);
                    break;
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = R2+S2;
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
                case 4:
                    szerkezet = M5/100;
                    break;
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M5/100;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M5/100;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M5/100;
                    break;    
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M5/100;
                    break;  
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M5/100;
                    break;  
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M4/100;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M4/100;
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
                case 4:
                    szerkezet = M5/25;
                    break;
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M5/25;
                    break;   
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M5/25;
                    break; 
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M5/25;
                    break;
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M5/25;
                    break;
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M5/25;
                    break;
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M4/25;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M4/25;
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
                case 4:
                    szerkezet = M5/100*6;
                    break;
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M5/100*6;
                    break;    
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M5/100*6;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M5/100*6;
                    break;
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M5/100*6;
                    break;
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M5/100*6;
                    break;
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M4/100*6;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M4/100*6;
                    break;
                default:
                    // code block
            }
            egyseg(id,szerkezet,egysegar,dijegyseg)
        }
    
        // if(id==11){ //anyag fuvar ktg
        //     let szerkezet = 0; //to be filled
        //     egyseg(id,szerkezet,egysegar,dijegyseg)
        // }
    
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
                case 4:
                    szerkezet = M4;
                    break;
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;    
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M2;
                    break;
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;  
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M4;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M3;
                    break;
                default:
                    // code block
            }
            egyseg(id,szerkezet,egysegar,dijegyseg)
        }
    
        if(id==34){ //mobilvc
            let szerkezet = 1; //to be filled
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
                case 4:
                    szerkezet = M5/10*O2;
                    break;   
                case 5:
                    //kontyolt nyeregteto
                    szerkezet = M5/10*O2;
                    break;  
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M5/10*O2;
                    break;   
                case 7:
                    //kontyolt nyeregteto
                    szerkezet = M5/10*O2;;
                    break;
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = M5/10*O2;
                    break;
                case 9:
                    //kontyolt nyeregteto
                    szerkezet = M5/10*O2;
                    break;
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = M4/10*O2;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = M4/10*S2;
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
                case 4:
                    szerkezet = parseFloat(testArray[5])*4/1.5;
                    break;
                case 5:
                    szerkezet = P2*4/1.5;
                    break;
                case 6:
                    //kontyolt nyeregteto
                    szerkezet = M2;
                    break;    
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = O2+P2;
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
                case 4:
                    szerkezet = parseFloat(testArray[5])*4;
                    break;
                case 5:
                    szerkezet = P2*4;
                    break;
                case 8:
                    //kontyolt nyeregteto
                    szerkezet = U2+X2+T2;
                    break;    
                case 9:
                    szerkezet = U2+X2+T2+4*Y2;
                    break;
                default:
                    // code block
            }
            egyseg(id,szerkezet,egysegar,dijegyseg)
        }
    
        if(id==38){ //falszego lemez
            let szerkezet = 0;
            switch(roofId) {            
                case 6:
                    szerkezet = R2;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = O2+P2;
                    break;
                default:
                    // code block
            }
            egyseg(id,szerkezet,egysegar,dijegyseg)
        }
    
        if(id==39){ //Vápa Színazonos anyagból Kaliforniai
            let szerkezet = 0;
            switch(roofId) {            
                case 8:
                    szerkezet = T2;
                    break;
                case 9:
                    szerkezet = T2;
                    break;
                case 12:
                    //kontyolt nyeregteto
                    szerkezet = 2*T2;
                    break;
                case 13:
                    //kontyolt nyeregteto
                    szerkezet = Q2;
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
    url: 'http://142.93.170.119/api/order',  
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
