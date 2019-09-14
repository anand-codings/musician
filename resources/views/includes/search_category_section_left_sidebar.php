<?php 
if(isset($cat_id) && ($cat_id != ''))
{
$cat='';
$cat = \App\Category::find($cat_id,['id']) ; 
}
?>

<?php if ($type == 'group') { ?>  
    <ul class="nav nav-tabs search_tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#category-solo" role="tab">Solo</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#category-ensemble" role="tab">Ensemble</a>
        </li>
    </ul>
    <div class="toggle_body">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="category-solo" role="tabpanel" aria-labelledby="home-tab">
                <div class="search_box">
                    <select name="cat" required="" id="search_category_type" multiple="multiple" class="selct2_select_categories" style="width: 100%">
                   <option></option>
                     <?php
                    foreach (categories('group', 'solo') as $key => $value) {
                  ?>
                  <?php if(isset($cat->id) && ($cat->id != '')) 
                    { ?>
                    <option name="specilaization[]"  value="<?= $value['title'] ?>"
                     <?= ( $cat->id == $value['id'] ? 'selected="selected"' : '') ?>
                     data_id="<?= $value['id'] ?>"><?= $value['title'] ?>
                    </option>
                    
                <?php }
                
                else 
                    { ?>
                  
                    <option name="specilaization[]"  value="<?= $value['title'] ?>"
                    data_id="<?= $value['id'] ?>"><?= $value['title'] ?>
                    </option>
                
                <?php } ?>
                 <!-- END ELSE --->
                <?php
                    }
                ?>
                    <!-- END FOREACH --->
                </select>
               </div>
            </div>
            <div class="tab-pane fade" id="category-ensemble" role="tabpanel" aria-labelledby="profile-tab">
                <div class="search_box">
                    <select name="cat" required="" id="search_category_type" multiple="multiple" class="selct2_select_categories" style="width: 100%">
                   <option></option>
                     <?php
                    foreach (categories('group', 'ensemble') as $key => $value) {
                  ?>
                  <?php if(isset($cat->id) && ($cat->id != '')) 
                    { ?>
                    <option name="specilaization[]"  value="<?= $value['title'] ?>"
                     <?= ( $cat->id == $value['id'] ? 'selected="selected"' : '') ?>
                     data_id="<?= $value['id'] ?>"><?= $value['title'] ?>
                    </option>
                <?php }
                
                else 
                    { ?>
                    <option name="specilaization[]"  value="<?= $value['title'] ?>"
                    data_id="<?= $value['id'] ?>"><?= $value['title'] ?>
                    </option>
                
                <?php } ?>
                 <!-- END ELSE --->
                <?php
                    }
                ?>
                    <!-- END FOREACH --->
                </select>
               </div>
            </div>
        </div>

    </div>
<?php } else if ($type == 'musician') { ?>
    <div class="toggle_body">
        
        <div class="search_box">
            <select name="cat" required="" id="search_category_type" multiple="multiple" class="selct2_select_categories" style="width: 100%">
                <option></option>
                <?php
                  foreach (categories('musician') as $key => $value) {
                ?>
                <?php if(isset($cat->id) && ($cat->id != '')) 
                    { ?>
                    <option name="specilaization[]"  value="<?= $value['title'] ?>"
                     <?= ( $cat->id == $value['id'] ? 'selected="selected"' : '') ?>
                     data_id="<?= $value['id'] ?>"><?= $value['title'] ?>
                    </option>
                <?php }
                
                else 
                    { ?>
                    <option name="specilaization[]"  value="<?= $value['title'] ?>"
                    data_id="<?= $value['id'] ?>"><?= $value['title'] ?>
                    </option>
                
                <?php } ?>
                 <!-- END ELSE --->
                <?php
                    }
                ?>
                    <!-- END FOREACH --->
            </select>
          </div>
        
    </div>
<?php } else if ($type == 'studio') { ?>
    <div class="toggle_body">
       
          <div class="search_box">
              <select name="cat" required="" id="search_category_type" multiple="multiple" class="selct2_select_categories" style="width: 100%">
                <option></option>
                <?php
                  foreach (categories('studio') as $key => $value) {
                ?>
                <?php if(isset($cat->id) && ($cat->id != '')) 
                    { ?>
                    <option name="specilaization[]"  value="<?= $value['title'] ?>"
                     <?= ( $cat->id == $value['id'] ? 'selected="selected"' : '') ?>
                     data_id="<?= $value['id'] ?>"><?= $value['title'] ?>
                    </option>
                <?php }
                
                else 
                    { ?>
                    <option name="specilaization[]"  value="<?= $value['title'] ?>"
                    data_id="<?= $value['id'] ?>"><?= $value['title'] ?>
                    </option>
                
                <?php } ?>
                 <!-- END ELSE --->
                <?php
                    }
                ?>
                    <!-- END FOREACH --->
            </select>
          </div>
    </div>
<?php } else if ($type == 'accompanist') { ?>
    <div class="toggle_body">
        <div class="search_box">
            <select name="cat" required="" id="search_category_type" multiple="multiple" class="selct2_select_categories" style="width: 100%">
                <option></option>
                <?php
                  foreach (categories('accompanist') as $key => $value) {
                ?>
                <?php if(isset($cat->id) && ($cat->id != '')) 
                    { ?>
                    <option name="specilaization[]"  value="<?= $value['title'] ?>"
                     <?= ( $cat->id == $value['id'] ? 'selected="selected"' : '') ?>
                     data_id="<?= $value['id'] ?>"><?= $value['title'] ?>
                    </option>
                <?php }
                
                else 
                    { ?>
                    <option name="specilaization[]"  value="<?= $value['title'] ?>"
                    data_id="<?= $value['id'] ?>"><?= $value['title'] ?>
                    </option>
                
                <?php } ?>
                 <!-- END ELSE --->
                <?php
                    }
                ?>
                    <!-- END FOREACH --->
            </select>
          </div>
    </div>
<?php } ?>

        <script>
            $('.selct2_select_categories').select2({
                placeholder: "Select Categories",
                allowClear: true,
                disabled: false,
                width: 'resolve'
            });
        </script>