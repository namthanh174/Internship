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
            <input type="text" id="define_url" style="width:90%">
             <div><span><b>Define title :</b></span> </div>
            <input type="text" id="define_title" style="width:90%">
            <input type="button" id="choose_title" name="choose_title" value="<?php esc_attr_e( 'Choose Titile' ); ?>" />
             <div><span><b>Define first content :</b></span> </div>
            <input type="text" id="define_first_content" style="width:90%">
             <div><span><b>Define last content :</b></span> </div>
            <input type="text" id="define_last_content" style="width:90%">


            <br />
            <input class="button-primary" type="submit" id="define_submit" name="define_submit" value="<?php esc_attr_e( 'Submit' ); ?>" />

        </form>
     
        <div class="wrapper">
            <div class="popup">
                <iframe src="" style="width:90%;height: 500px;">
                    <p>Your browser does not support iframes.</p>
                </iframe>
                <a href="#" class="close">X</a>

            </div>
        </div>
 </div>