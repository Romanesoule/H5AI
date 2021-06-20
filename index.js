$(document).ready(function () {
    
    $.ajax({
        type: "GET",
        url: "./cut_tree.php",
        
        success: function (response) {
            $(".arbre").html(response);
        }
    });
    
    $("#show_detail").click(function (e) { 
        e.preventDefault();

        $.ajax({
            type: "GET",
            url: "./tree.php",
            
            success: function (response) {
                $(".arbre").html(response);
            }
        });
        
    });

    $("#mask_detail").click(function (e) { 
        location.reload();
    });

    $.ajax({
        type: "GET",
        url: "search_files.php",
                
        success: function (data) {
            var tableau  = data.split("*");
            var newtab = [];
            tableau.forEach(function(item) {
                    newtab.push(item);
              });
            $( "#recherche" ).autocomplete({
                source: newtab
            });
        }
    });

    $(document).keyup(function(e) {
        if (e.keyCode === 13) {
            
            $.ajax({
                type: "POST",
                url: "display_file.php",
                data : { 
                    path_file : $("#recherche").val()  
                },
                success: function (data) {
                    $(".filelist").html(data);
                    $(".content").click(function (e) { 
                        e.preventDefault();
                        var file = $(this).attr("id");
                        $.ajax({
                            type: "POST",
                            url: "get_txt.php",
                            data: {
                                file : file
                            },
                            
                            success: function (response) {
                                $('.modal').html(response);
                                $('.modal').css('display','flex');
                            }
                        });
                    });
                }
            });

        } 
    });

    setTimeout(function(){ 
        var class_dossier = $('.dossier');
        var count = class_dossier.length;

        for(let i = 0; i < count; i++) { 

            class_dossier.eq(i).on("click" , function() {

                setTimeout(function(){ 
                    var class_fichier = $('.content');
                    var count2 = class_fichier.length;
                   
                    for(let i = 0; i < count2; i++) { 
                        
                        class_fichier.eq(i).on("click" , function() {
                        
                        var file = $(this).attr('id');
                
                        $.ajax({
                            type: "POST",
                            url: "get_txt.php",
                            data: {
                                file : file
                            },
                            
                            success: function (response) {
                                $('.modal').html(response);
                                $('.modal').css('display','flex');
                            }
                        });
                    })
                }
                }, 1000);
            var id_dossier = $(this).attr('id');

            recursive(id_dossier);
            
            function recursive(id_dossier) {

                $.ajax({
                    type: "POST",
                    url: "display.php",
                    data: {
                        id_dossier : id_dossier
                    },
                    
                    success: function (response) {
                
                        $(".filelist").html('<input type="button" value=" &#8592; " class="retour ombre" id="'+ id_dossier +'" >' +  response);
                    
                        $(".retour").click(function (e) { 
                            e.preventDefault();

                            var actual_dir = $(this).attr("id");

                            var id_dossier = actual_dir.substr(0,actual_dir.lastIndexOf("/"));
                            if (id_dossier != "") {
                                recursive(id_dossier);
                            } else {
                                alert('Vous êtes à la racine de votre dossier');
                                $(".retour").css("display" , "none");
                            }
                            
                                   
                        });

                        $(".color").click(function (e) { 
                            e.preventDefault();
                            $( ".target" ).change(function() {
                            });
                            $(this).css("color" , $(".target").val() );
                        });

                        const compare = function(ids, asc){
                            return function(row1, row2){
                            const tdValue = function(row, ids){
                                return row.children[ids].textContent;
                            }
                            const tri = function(v1, v2){
                                if (v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2)){
                                return v1 - v2;
                                }
                                else {
                                return v1.toString().localeCompare(v2);
                                }
                                return v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2);
                            };
                            return tri(tdValue(asc ? row1 : row2, ids), tdValue(asc ? row2 : row1, ids));
                            }
                        }
  
                        const tbody = document.querySelector('tbody');
                        const thx = document.querySelectorAll('th');
                        const trxb = tbody.querySelectorAll('tr');

                        thx.forEach(function(th){
                            th.addEventListener('click', function(){
                            let classe = Array.from(trxb).sort(compare(Array.from(thx).indexOf(th), this.asc = !this.asc));
                            classe.forEach(function(tr){
                                tbody.appendChild(tr)
                            });
                            })
                        });
                    }
                });
            }
            
        })
    }
    }, 1000);
      
    $('.popin-dismiss').on('click',function(){ 
        $('.modal').css('display','none');
    });

    $(window).click(function() {
        $('.modal').css('display','none');
    });
    $('.modal').click(function(event)
    {
        event.stopPropagation();
    });
  
    $(document).keyup(function(e) {
  
        if (e.keyCode === 27) {
            $('.modal').css('display','none');
        } 
    });

});