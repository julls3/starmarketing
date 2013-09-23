<?php
$seo = false;
if($dservices){
   foreach ($dservices as $dm){
       if($dm['service']->name == 'SEO'){
           $seo = true;
           break;
       }
   }
}
$this->menu=array(
	array(
            'label'=>'Прикрепленные пользователи',
            'url'=>array('#'),
            'linkOptions'=>array(
                'class'=>'add_user',
                'id'=>'adduser'
            ),
            'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('addSite')
            ),
        array(
            'label'=>'Прикрепленные услуги',
            'url'=>array('#'),
            'linkOptions'=>array(
               
                'id'=>'addservices'
            ),
            'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('addSite')
            ),
         array(
            'label'=>'SEO: Добавить ключевое слово',
            'url'=>array('#'),
            'linkOptions'=>array(

                'id'=>'addseokw'
            ),
            'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('addSite')&& $seo
            )
	
);
?>

<h2>Название проекта : <?php echo $project->name?></h2>
<p>Дата создания :<?php echo $project->created;?></p>
<div class="managers">
    <strong >За проектом закреплены : <?php echo count($deligations);?> пользователей, из которых : <?php echo count($dmanagers);?> менеджеров и <?php echo count($dmasters);?> специалистов</strong><br>
</div>
<?php if( $seo):?>
<div id="seokws" style="margin-top:30px;">
    
    <strong style="display:block;margin-bottom:15px;">SEO: Ключевые слова</strong>
    <?php if($dkws):?>
    <div class="kword" >
       <input type="checkbox" id="allkws" value="0" /> 
       <b style="color:darkblue;font-size:14px;">Ключевое слово</b>
       <span class="sengine" >
           <b style="color:#17AA28">[ЦЕЛЬ]</b> <b>Поисковая система</b>
           <b style="color:#069;">Регион</b>
        </span>
    </div>
      <?php foreach($dkws as $kw):?>
        <div class="kword" >
            <input type="checkbox" id="kw<?php echo $kw['kw']->id;?>" value="<?php echo $kw['kw']->id;?>" /> 
            <b><?php echo $kw['kw']->kw;?></b>
            <span class="sengine" >
          <?php 
                echo "<b class='target' >[TOP-".$kw['kw']->target."] </b>";
                if($kw['kw']->se == 1){
                    echo "<b>Google UA</b>";
                }
                if($kw['kw']->se == 2){
                    echo "<b>Google RU</b>";
                }
                if($kw['kw']->se == 3){
                    echo "<b>Google UA + RU</b>";
                }
                if($kw['kw']->se == 4){
                    echo "<b>Yandex</b>";
                }
                if($kw['kw']->se == 5){
                    echo "<b>Google UA + Yandex</b>";
                }
                if($kw['kw']->se == 6){
                    echo "<b>Google RU + Yandex</b>";
                }
                if($kw['kw']->se == 7){
                    echo "<b>Google UA + Google RU + Yandex</b>";
                }
                
            ?>
            </span><br />
            <span class="sregions">
                <?php foreach($kw['regions'] as $reg):?>
                <i> <?php echo $reg->name?> </i>,
                <?php endforeach;?>
            </span>
        </div>
      <?php endforeach;?>
    <div class="kword" >
        <b><a href="#" id="deletekws" >Удалить отмеченные</a></b>
        
    </div>
    <?php endif;?>
</div>
<?php endif;?>
<div id='users' data-project='<?php echo $project->id;?>' style='display:none;' >
    
    <form class='deligation'>
        <strong>Менеджеры</strong><br />
        <?php foreach ($mgrs as $mgr):?>
        <?php
          // проверка в списке делегированных пользователей на соответсвие с общим списком. Если пользователь уже делегирован, ставим галочку на чекбоксе 
           $checked = false;
           if($dmanagers){
               foreach ($dmanagers as $dm){
                   if($dm->id == $mgr->id){
                       $checked = true;
                       break;
                   }
               }
           }
           
        ?>
        <input type='checkbox' name='<?php echo $mgr->id?>' value='<?php echo $mgr->id?>' <?php echo ($checked)?'checked':'';?> />
        <label>
            <?php echo $mgr->name;?>
        </label><br/>
        <?php endforeach;?>  
    </form>
    
    
    <form class='deligation'>
        <strong>Специалисты</strong><br />
        <?php foreach ($masters as $master):?>
        <?php
          // проверка в списке делегированных пользователей на соответсвие с общим списком. Если пользователь уже делегирован, ставим галочку на чекбоксе 
           $checked = false;
           if($dmasters){
               foreach ($dmasters as $dm){
                   if($dm->id == $master->id){
                       $checked = true;
                       break;
                   }
               }
           }
        ?>
        <input type='checkbox' name='<?php echo $master->id?>' value='<?php echo $master->id?>' <?php echo ($checked)?'checked':'';?> />
        <label>
            <?php echo $master->name;?>
        </label><br/>
        <?php endforeach;?>  
    </form>
    
    
    <form class='deligation'>
        <strong>Клиенты</strong><br />
        <?php foreach ($users as $user):?>
         <?php
          // проверка в списке делегированных пользователей на соответсвие с общим списком. Если пользователь уже делегирован, ставим галочку на чекбоксе 
           $checked = false;
           if($dusers){
               foreach ($dusers as $dm){
                   if($dm->id == $user->id){
                       $checked = true;
                       break;
                   }
               }
           }
        ?>
        <input type='checkbox' name='<?php echo $user->id?>' value='<?php echo $user->id?>' <?php echo ($checked)?'checked':'';?> />
        <label>
            <?php echo $user->name;?>
        </label><br/>
        <?php endforeach;?>  
    </form>
</div>

<div id="services" style="display:none">
    <form class='deligation'>
        <strong>Услуги</strong><br />
        <?php foreach ($services as $service):?>
         <?php
          // проверка в списке делегированных пользователей на соответсвие с общим списком. Если пользователь уже делегирован, ставим галочку на чекбоксе 
           $checked = false;
           //бюджет
           $bg = '0.00';
           if($dservices){
               foreach ($dservices as $dm){
                   if($dm['service']->id == $service->id){
                       $checked = true;
                       $bg =$dm['budget'];
                       break;
                   }
               }
           }
        ?>
        <input type='checkbox' name='<?php echo $service->id?>' value='<?php echo $service->id?>' <?php echo ($checked)?'checked':'';?> />
        <label>
            <?php echo $service->name;?>
        </label>
        <input id="<?php echo $service->id?>" style="margin-left:10px;" type="text" size="5" data-service="<?php echo $service->id?>" value="<?php echo $bg?>" /> грн
        <br/>
        <?php endforeach;?>  
    </form>
</div>

<div id="addkw" style="display:none;" >
    <form>
        <fieldset>
            <label>Ключевые слова</label><br />
            <textarea id="kwname" cols="100" rows="10" placeholder="Каждое слово с новой строки"></textarea>
        </fieldset>
        <fieldset style="margin-top:10px;">
            <strong >Поисковая система</strong><br />
            <input type="checkbox" id="gseu" value="1" checked /> 
            <label>Google.com.ua</label><br />
            <input type="checkbox" id="gser" value="2" checked /> 
            <label>Google.ru</label><br />
            <input type="checkbox" id="yse" value="3"  /> 
            <label>Yandex</label><br />
        </fieldset>
        <fieldset style="margin-top:10px;">
            <strong >Предполагаемый результат</strong><br />
             <select id="tops" >
                 <option value="20">Топ 20</option>
                 <option value="10">Топ 10</option>
                 <option value="5">Топ 5</option>
                 <option value="3">Топ 3</option>
                 <option value="1">Топ 1</option>
             </select>
        </fieldset>
        <fieldset style="margin-top:10px;">
            <strong >Регион</strong><br />
             <div id="regions" >
                 <?php foreach($regions as $reg):?>
                
                 <input type="checkbox" value="<?php echo $reg->id;?>" />
                 <label><?php echo $reg->name;?></label>
                 <?php endforeach?>
             </div>
        </fieldset>
    </form>
</div>

