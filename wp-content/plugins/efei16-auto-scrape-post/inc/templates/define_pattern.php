<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>


 <div class="container">
        <form action='' method='POST' id='define-pattern-form'>

            <div><span><b>URL :</b></span> </div>
            <input type="text" id="define_url" style="width:70%" />
             <div><span><b>Define title :</b></span> </div>
            <input type="text" id="define_title" style="width:70%" />
            <input type="button" id="choose_title" name="choose_title" value="<?php esc_attr_e( 'Choose Title' ); ?>" />
             <div><span><b>Define first content :</b></span> </div>
            <input type="text" id="define_first_content" style="width:70%" />
            <input type="button" id="choose_first_content" name="choose_first_content" value="<?php esc_attr_e( 'Choose First Content' ); ?>" />
             <div><span><b>Define last content :</b></span> </div>
            <input type="text" id="define_last_content" style="width:70%" />
            <input type="button" id="choose_last_content" name="choose_last_content" value="<?php esc_attr_e( 'Choose Last Content' ); ?>" />


            <br />
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
