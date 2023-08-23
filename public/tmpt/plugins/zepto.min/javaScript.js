$('#FormCdPrtcls').on('submit',function(event){
    event.preventDefault();
    var dados=$(this).serialize();
    $.ajax({
        url:'sistema/controller/nvPrtclSlct.php',
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function(response) {
            $('.nvPrtcl').empty(); 
            $.each(response,function(key,value) {
                $('.nvPrtcl').append(value.prtcl);
            });
        }
    });
});
$('#FormCdPrtcls').on('submit',function(event){
    event.preventDefault();
    var dados=$(this).serialize();
    $.ajax({
        url:'sistema/controller/nvPrtclSlct.php',
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function(response) {
            $('.envNvPrtcl').empty(); 
            $.each(response,function(key,value) {
                $('.envNvPrtcl').append("<input type='hidden'name='idprtcl' value='"+value.prtcl+"' disabled>");
            });
        }
    });
});

document.onreadystatechange = function () {
    if (document.readyState == "interactive") {
    var dados=10;
        $.ajax({
            url:'sistema/controller/bscPrtclSlct.php',
            type: 'post',
            dataType: 'json',
            data: dados,
            success: function(response) {
                $.each(response,function(key,value) {
                    console.log(response);
                    $('.link ').html("<ul class='nav nav-treeview'><li class='nav-item'><a href='"+value.id_pgns+"' class='nav-link active'><i class='far fa-circle nav-icon'></i><p>Buscar</p></a></li></ul>");
                }); 
            }
        });
    }
  }
