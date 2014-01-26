function isValidChar(char){

    var txt = char;
    var found = false;
    var validChars = "0123456789"; //List of valid characters

    for(j=0;j<txt.length;j++){ //Will look through the value of text
        var c = txt.charAt(j);
        found = false;
        for(x=0;x<validChars.length;x++){
            if(c==validChars.charAt(x)){
                found=true;
                break;
            }
        }
        if(!found){
            //If invalid character is found remove it and return the valid character(s).
            document.getElementById('txtFld').value = char.substring(0, char.length -1);
            break;
        }
    }
}// JavaScript Document