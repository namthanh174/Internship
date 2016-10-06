<fieldset id="list_categories">
                <ul class="categorylist">
                <?php
                foreach ($post_categories as $category) {
                     if($category->category_parent == 0){
                    ?>
                   
                    <li> 
                        <label><input type='checkbox' class='type' id="<?php echo $category->cat_ID; ?>" /><?php echo $category->cat_name; ?></label>
                        
                        <ul class="childcategory">
                            <?php
                                 $arg_demo = array("hide_empty" => 0,
                                    "type" => "post",
                                    "orderby" => "name",
                                    "order" => "DESC",
                                    'parent' => $category->cat_ID
                                );

                                $category_childs = get_categories($arg_demo);
                                foreach($category_childs as $child){
                               
                                    
                            ?>

                            <li>
                                <label>
                                    <input type='checkbox' class='type' id="<?php echo $child->cat_ID; ?>" />
                                    <?php echo $child->cat_name; ?>
                                </label>
                            </li>
                            <?php } ?>
                        </ul>


                    </li>
               
                   
                   
                <?php  }} ?>
                </ul>


            <div id="category-adder" class="wp-hidden-children">
                <a id="category-add-toggle" href="#category-add" class="hide-if-no-js taxonomy-add-new">
                    + Add New Category              </a>
                <p id="category-add" class="category-add wp-hidden-child">
                    <label class="screen-reader-text" for="newcategory">Add New Category</label>
                    <input type="text" name="newcategory" id="newcategory" class="form-required" value="New Category Name" aria-required="true">
                    <label class="screen-reader-text" for="newcategory_parent">
                        Parent Category:                    </label>
                <select name="newcategory_parent" id="newcategory_parent" class="postform">
                    <option value="-1">— Parent Category —</option>


                    <?php 
                        foreach ($post_categories as $category) {
                            
                    ?>

                    <option class="level-0" value="<?php echo $category->cat_ID; ?>"><?php echo $category->cat_name; ?></option>
                    

                    <?php } ?>
                    <!-- <option class="level-0" value="3">Movies</option>
                    <option class="level-1" value="7">&nbsp;&nbsp;&nbsp;Socials</option>
                    <option class="level-0" value="2">News</option>
                    <option class="level-1" value="6">&nbsp;&nbsp;&nbsp;Agriculture</option>
                    <option class="level-1" value="5">&nbsp;&nbsp;&nbsp;Health</option>
                    <option class="level-1" value="4">&nbsp;&nbsp;&nbsp;Tech</option>
                    <option class="level-0" value="1">Uncategorized</option> -->
                </select>
                    <input type="button" id="category-add-submit"  class="button category-add-submit" value="Add New Category">
                   
                </p>
            </div>




            </fieldset>