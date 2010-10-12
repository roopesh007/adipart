
function isNotEmpty(elem) {
    var str = elem.value;
    var re = /.+/;
    if(!str.match(re)) {
        $.notifyBar({ cls: "error", html: "Error, Information on "+elem.name+" field is missing." });
        badField(elem);
        return false;
    } else {
        return true;
    }
}


function isValidUser(user) {

  var uname = user.value;
  var regexpstr = /(^[a-z.]+$)/;
  if (uname.search(regexpstr) == -1) {
    $.notifyBar({ cls: "error", html: randomErrors()+", Information for "+user.name+" is incorrect, do not include special characters", delay:4000 });
    return false;
  }
  else {
   uname = uname.replace(/[.]+/g,'');
   document.data.username.value=uname;
   return true;
  }
}


function checkForm() {

  document.data.button.disabled=true;
  resetForms(document.data.username);  
  if (isNotEmpty(document.data.username) && isValidUser(document.data.username)) {
    return true;
  }
  else 
    return false;

}



function mail(elem){
    var mydomain = "@mydomain.com";
    var texto = elem.value;
    var mailres = true;            
    var cadena = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890@._-";
    
    var arroba = texto.indexOf("@",0);
    if ((texto.lastIndexOf("@")) != arroba) arroba = -1;
    
    var punto = texto.lastIndexOf(".");
                
     for (var contador = 0 ; contador < texto.length ; contador++){
        if (cadena.indexOf(texto.substr(contador, 1),0) == -1){
            mailres = false;
            break;
     }
    }

    if ((arroba > 1) && (arroba + 1 < punto) && (punto + 1 < (texto.length)) && (mailres == true) && (texto.indexOf("..",0) == -1)) {
      domain=texto.substr(arroba,texto.length);
      if (domain==mydomain){
        $.notifyBar({ cls: "custom", html: randomErrors()+", your email can't be "+mydomain+", please try again.", delay: 5000 });
        badField(elem);
        mailres=false;
      } 
      else 
      mailres=true;
    }
    else {
     mailres = false;
     $.notifyBar({ cls: "error", html: randomErrors()+", Incorrect email format!", delay: 3500 });
     badField(elem);

    }      
    return mailres;
}


function isNotEmpty(elem) {
    var str = elem.value;
    var re = /.+/;
    if(!str.match(re)) {
        $.notifyBar({ cls: "error", html: randomErrors()+", Information on "+elem.name+" field is missing.", delay: 3500 });
        badField(elem);
        return false;
    } else {
      if (elem.name == "username")
        if  (isValidUser(elem))
          return true;
        else
          return false;
      else
        return true;
    }
}

function isValidUser(user) {

  var uname = user.value;
  var regexpstr = /(^[a-z.]+$)/;
  if (uname.search(regexpstr) == -1) {
    $.notifyBar({ cls: "error", html: randomErrors()+", Information for "+user.name+" is incorrect, please review ", delay:4000 });
    badField(user);
    return false;
  }
  else {
   uname = uname.replace(/[.]+/g,'');
   document.data.username.value=uname;
   return true;
  }
}




function checkmails(text1, text2) {

  if (text1.value==text2.value) {
    return true;
  }
  else {
    $.notifyBar({ cls: "error", html: randomErrors()+", Email does not match!", delay: 3500 });
    badField(text1);
    badField(text2);
    return false;
  }
}

function checkForm() {


  document.data.boton.disabled=true;
  resetForms(data.email);  
  resetForms(data.confirmemail);  
  resetForms(data.username);  
  resetForms(data.password);  
  if (mail(document.data.email) && mail(document.data.confirmemail) && isNotEmpty(document.data.username) && isNotEmpty(document.data.password) && checkmails(data.email, data.confirmemail) ) {
    return true;
  }
  else 
    return false;
  

}


function checkgenForm() {


  document.data.button.disabled=true;
  resetForms(data.username);
  if (isNotEmpty(document.data.username)) {
    return true;
  }
  else
    return false;


}



function randomErrors (){

  var phrasenumber = Math.floor(Math.random()*10);
  switch (phrasenumber) {
    case 0: return "Opps!"; break;
    case 1: return "Error!"; break;
    case 2: return "Ouch!"; break;
    case 3: return "Mmmm!"; break;
    case 4: return "Damn!"; break;
    case 5: return "WTF!"; break;
    case 6: return "OMG!"; break;
    case 7: return "Doh!"; break;
    case 8: return "Shhh!"; break;
    case 9: return "Ostiaaa!"; break;
    case 10: return "Argh!"; break;
    default: return "Me cago en..."; break;
  }

}


