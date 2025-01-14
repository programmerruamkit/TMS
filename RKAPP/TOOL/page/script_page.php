<script>
function conf_send_data(selection){
    var r;
    if(selection == 'update'){
        r = confirm("คุณต้องการ แก้ไข ข้อมูล ใช่หรือไม่?");
    }else if(selection == 'del'){
        r = confirm("คุณต้องการ ลบ ข้อมูล ใช่หรือไม่?");
    }else{
        r = confirm("คุณต้องการ บันทึก ข้อมูล ใช่หรือไม่?");
    }
    if (r == true){
        return true;
    }else{
        return false;
    }
}

function conf_logout(){
    var r = confirm("ต้องการออกจากระบบ \n ใช่ หรือ ไม่");
    if (r == true){return true;}
    else{return false;}
}

function display_change(display, type, val, page){
    var xhttp = new XMLHttpRequest();
    pages = "";
    if(val != ''){
        pages = page + "?data=" + val + "&type=" + type;
        xhttp.open("GET", pages, false);
        xhttp.send();
        document.getElementById(display).innerHTML = xhttp.responseText;
    }
}

function search_data(display, selection, type, name, page){
    var xhttp = new XMLHttpRequest();
    pages = "";
    if(selection == 'select'){
        
    }else{
        if(type == ''){ type = '%' }else{ type = '%'+type+'%' }
        if(name == ''){ name = '%' }else{ name = '%'+name+'%' }
    }
    
    if(pages = page + "?name=" + name + "&type=" + type + "&selection=" + selection){
        xhttp.open("GET", pages, false);
        xhttp.send();
        document.getElementById(display).innerHTML = xhttp.responseText;
    }
}

function to_upper_str(id, data){
    document.getElementById(id).value = data.toUpperCase();
}

function set_ekey(tkey){
    document.getElementById("ecode").value = "RK-"+tkey;
}

function set_okey(tkey, date){
    document.getElementById("ocode").value = "O-"+tkey+"-"+date+"-";
}
</script>