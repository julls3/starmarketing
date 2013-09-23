var baseURL = window.location.protocol + '//' + window.location.hostname + '/';
$(document).ready(function(){
    //создание проекта 
    $('#bcreate').click(function(event){
        //event.preventDefault();
        var pname = $('#pname').val();
        var ganame = $('#ganame').val();
        var urlname = $('#urlname').val();
        if(ganame && pname && urlname){
            //отправка формы аяксом
            var data = {
                pname:pname,
                ganame:ganame,
                urlname:urlname
            };
            $.ajax({
                url:'/index.php/api/pr_create/',
                data:data,
                type:'POST',
                success:function(response){
                    window.location.href =  '/index.php/projects/view/'+response;
                }
            });
        }else{
           if(!pname){
            $('#pname').css({
                border:'2px solid red'
            }).attr('placeholder','Заполните название проекта');
            }
            if(!ganame){
              $('#ganame').css({
                    border:'2px solid red'
              }).attr('placeholder','Укажите название GA аккаунта');
            }
            if(!urlname){
              $('#urlname').css({
                    border:'2px solid red'
              }).attr('placeholder','Укажите ссылку на сайт');
             } 
        }
        
    });
    
    
    /*
     * Делегирование проекта пользователям
     */
    
    $('#adduser').click(function(e){
        e.preventDefault();
        $('#users').dialog({
            modal:true,
            width:'900px',
            title:'Пользователи, привязанные к проекту',
            buttons:{
                'Сохранить':function(){
                    var project = $('#users').data('project');
                    var selected = '';
                    $('#users input[type=checkbox]').each(function(){
                       if($(this).attr('checked')){
                           selected += $(this).val()+';'
                       } 
                    });
                    if(selected){
                        var data = {
                            project:project,
                            users:selected
                        };
                        $.ajax({
                            type:'POST',
                            url:'/index.php/api/delegate_users/',
                            data:data,
                            success:function(response){
                                location.reload();
                            }
                        });
                    }
                },
                'Отмена':function(){
                   $(this).dialog('close');
                }
            }
        });
    });
    
    
    /***************************************************************************
     *     Делегирование услуг 
     * ************************************************************************/
    
    $('#addservices').click(function(e){
        e.preventDefault();
        var project = $('#users').data('project');
        var selected = '';
        $('#services').dialog({
            modal:true,
            width:'40%',
            title:'Управление услугами',
            buttons:{
                'Сохранить':function(){
                    $('#services input[type=checkbox]').each(function(){
                        if($(this).attr('checked')){
                            selected+= $(this).val()+';'+$('#'+$(this).val()).val()+'--';
                        }
                    });
                    if(!selected){
                        return false;
                    }
                    var data = {
                        project:project,
                        selected:selected
                    };
                    console.log(data);
                    $.ajax({
                        type:'POST',
                        data:data,
                        url:'/index.php/api/deligate_services/',
                        success:function(response){
                            
                            location.reload();
                        },
                        error:function(response){
                           console.log(response);
                        }
                    });
                },
                'Отмена':function(){
                    $(this).dialog('close');
                }
            }
        });
    });
    
    
    
    /***************************************************************************
     *             Добавление ключевых слов
     * */
    $('#addseokw').click(function(e){
        e.preventDefault();
        var project = $('#users').data('project');
        $('#addkw').dialog({
            modal:true,
            width:'900px',
            title:'SEO: Добавление ключевого слова',
            buttons:{
                'Добавить':function(){
                    var se= 0;
                    if($('#gseu').attr('checked')){
                        se += 1;
                    }
                    if($('#gser').attr('checked')){
                        se += 2;
                    }
                    if($('#yse').attr('checked')){
                        se += 4;
                    }
                    ////////////////////////////////////////////////////////////
                    //            Маска поисковых систем 
                    ////////////////////////////////////////////////////////////
                    //             google.com.ua = 1
                    //             google.ru  = 2
                    //             googleua + googleru = 3
                    //             yandex = 4
                    //             yandex + googleua = 5
                    //             yandex + googleru = 6
                    //             all = 7
                    ////////////////////////////////////////////////////////////
                    console.log('Поисковая маска :');
                    console.log(se);
                    var keywords = $('#kwname').val(); //Список ключевых слов
                    var target =  $('#tops').val(); // цель (топ 10 , 20 ...)
                    var regions='';
                    $('#regions input[type=checkbox]').each(function(){
                       if($(this).attr('checked')){
                           regions+=$(this).val()+';';
                       } 
                    });
                    if(keywords && se && target && regions){
                       var data = {
                           project:project,
                           se:se,
                           keyword:keywords,
                           target:target,
                           regions:regions
                       };
                       $.ajax({
                           type:'POST',
                           url:'/index.php/api/add_kws',
                           data:data,
                           success:function(response){
                               location.reload();
                           },
                           error:function(response){
                             console.log('Ошибка отправки запроса : scripts.js  : ');
                             console.log(response);
                           }
                       });   
                    }else{
                        if(!keywords){
                            $('#kwname').css({
                                border:'1px solid red'
                            });
                        }
                        if(!regions){
                            alert('Выберите регион');
                        }
                        if(!se){
                            alert('Выберите поисковую систему');
                        }
                       
                    }
                },
                'Отмена':function(){
                   $(this).dialog('close');
                }
            }        
        });
    });
    
    //подрашиваю ключевые слова при выводе
    $('#seokws div:even').css({
        background:'rgba(224, 224, 224, 0.86)'
    });
    
    
    
    
    //отмечаю все ключевые слова чекбоксом
    $('#allkws').change(function(){
        if($(this).attr('checked')){
           $('.kword input[type=checkbox]').attr('checked',true); 
        }else{
            $('.kword input[type=checkbox]').attr('checked',false);
        }
    });
    
    
    
    // удаление ключевых слов
    $('#deletekws').click(function(e){
        e.preventDefault();
        var project = $('#users').data('project');
        var selected = '';
        $('#seokws input[type=checkbox]').each(function(){
            if($(this).attr('checked')){
                selected += $(this).val()+';';
            }
        });
        var data={
                selected:selected,
                project:project
        };
        console.log('Отправка запроса на удаление, scripts.js , Data:');
        console.log(data);
        if(selected){
            $.ajax({
                type:'POST',
                url:'/index.php/api/delete_kws',
                data:data,
                success:function(response){
                    location.reload();
                },
                error:function(response){
                  console.log('Ошибка при отправке формы :');
                  console.log(response);
                }
            });
        }
    });
    
    
    
});

