<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>


 <div class="container">
        <form action='' method='POST' id='define-pattern-form'>
            <table class="form-table">
            <tr>
                <th><h4><?php esc_attr_e( 'URL : ', 'wp_admin_style' ); ?></h4></th>
                <td><input type="text" id="define_url" style="width: 100%" /></td>
            </tr>
            <tr>
                <th><h4><?php esc_attr_e( 'Enter The Title : ', 'wp_admin_style' ); ?></h4></th>
                <td><input type="text" id="define_title" style="width: 100%" /></td>
            </tr>
            <tr>
                <th><h4><?php esc_attr_e( 'Enter The First Content: ', 'wp_admin_style' ); ?></h4></th>
                <td><input type="text" id="define_first_content" style="width: 100%"  /></td>
            </tr>
            <tr>
                <th><h4><?php esc_attr_e( 'Enter The Last Content', 'wp_admin_style' ); ?></h4></th>
                <td><input type="text" id="define_last_content" style="width: 100%" /></td>
            </tr>

            </table>
            <input class="button-primary" type="submit" id="define_submit" name="define_submit" value="<?php esc_attr_e( 'Submit' ); ?>" />

        </form>
     <!--<button id='hide_content' >Hide</button>-->
        <br />
        
        
       
 </div>

<div id="demoResult" style="display: none;"></div>
<br/>
<div class="popup_content">
    
</div>
<div class="title_popup">
    
</div>
<div class="first_content_popup">
    
</div>
<div class="last_content_popup">
    
</div>
<!--<div class="popup" data-popup="popup-1">
    <div class="popup-inner">
        <div class="content_popup"></div>
        <h2>Wow! This is Awesome! (Popup #1)</h2>
        <p>Donec in volutpat nisi. In quam lectus, aliquet rhoncus cursus a, congue et arcu. Vestibulum tincidunt neque id nisi pulvinar aliquam. Nulla luctus luctus ipsum at ultricies. Nullam nec velit dui. Nullam sem eros, pulvinar sed pellentesque ac, feugiat et turpis. Donec gravida ipsum cursus massa malesuada tincidunt. Nullam finibus nunc mauris, quis semper neque ultrices in. Ut ac risus eget eros imperdiet posuere nec eu lectus.</p>
        <p><a data-popup-close="popup-1" href="#">Close</a></p>
        <a class="popup-close" data-popup-close="popup-1" href="#">x</a>
    </div>
</div>-->
