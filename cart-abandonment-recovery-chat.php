<?php
/**
 * Plugin Name: Cart Abandonment Recovery via Chat
 * Plugin URI: cart-abandonment-recovery-chat
 * Description: Recover your lost revenue. Capture WhatsApp Numbers of users on the checkout page and send follow up emails if they don't complete the purchase.
 * Version: 1.0.1
 * Author: 9xworks
 * Author URI: 9xworks
 * WC requires at least: 3.0
 * WC tested up to: 4.2.0
 *
 * @package Cart-Abandonment-Recovery-Chat
 */

if( !defined( 'ABSPATH' ) ) {
    die;
  }


  defined ( 'ABSPATH' ) or die ( 'Forbidden' );


if( !function_exists( 'add_action' )) {
  echo "Forbidden";
  exit;
}



if ( in_array( 'woocommerce/woocommerce.php', get_option('active_plugins'))) {

    if ( ! class_exists('CARC_Popup')){
  
  class CARC_Popup{
  
            public function __construct()
            {
  add_action('init', array( $this, 'custom_post_type') );
            }
  
            function activate() {
  
              flush_rewrite_rules();
              carc_create_db();
              carc_create_db_template();
              carc_create_db_vars();
              carc_create_db_settings();
            }
  

            function deactivate() {
             flush_rewrite_rules();
            }
  
            function uninstall() {
  
            }
  
            
            function custom_post_type() {


              wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom_script.js', array( 'jquery' ));

                add_action( 'wp_footer', 'custom_popup_script' );
                function custom_popup_script() {
                    ?> 
                    
                    <?php global $wpdb;
                $table_name = $wpdb->prefix . "CARC_Settings";
                $meta_key = 'join_the_chat_number';
                $join_the_chat_number_value_show = $wpdb->get_var($wpdb->prepare("SELECT var_val FROM $table_name WHERE var_name = %s", $meta_key));
                ?>
                    
                    <html>
                    <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <style>
                    body {font-family: Arial, Helvetica, sans-serif;}
                    
                    /* The Modal (background) */
                    .modal {
                      display: none; /* Hidden by default */
                      position: fixed; /* Stay in place */
                      z-index: 1; /* Sit on top */
                      padding-top: 100px; /* Location of the box */
                      left: 0;
                      top: 0;
                      width: 100%; /* Full width */
                      height: 100%; /* Full height */
                      overflow: auto; /* Enable scroll if needed */
                      background-color: rgb(0,0,0); /* Fallback color */
                      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
                    }
                    
                    /* Modal Content */
                    .modal-content {
                      position: relative;
                      background-color: #fefefe;
                      margin: auto;
                      padding: 0;
                      border: 1px solid #888;
                      width: 40%;
                      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
                      -webkit-animation-name: animatetop;
                      -webkit-animation-duration: 0.4s;
                      animation-name: animatetop;
                      animation-duration: 0.4s
                    }
                    
                    /* Add Animation */
                    @-webkit-keyframes animatetop {
                      from {top:-300px; opacity:0} 
                      to {top:0; opacity:1}
                    }
                    
                    @keyframes animatetop {
                      from {top:-300px; opacity:0}
                      to {top:0; opacity:1}
                    }
                    
                    /* The Close Button */
                    .close {
                      color: white;
                      float: right;
                      font-size: 28px;
                      font-weight: bold;
                    }
                    
                    .close:hover,
                    .close:focus {
                      color: #000;
                      text-decoration: none;
                      cursor: pointer;
                    }
                    
                    .modal-header {
                      padding: 2px 16px;
                      background-color: #5cb85c;
                      color: white;
                    }
                    
                    .modal-body {padding: 2px 16px;}
                    
                    .modal-footer {
                      padding: 2px 16px;
                      background-color: #5cb85c;
                      color: white;
                    }
                    
                    .container {
                        width:100%;
                      display: flex;
                    }
                    
                    .bottom-right {
                      position: absolute;
                      bottom: 8px;
                      right: 10px;
                    }
                    
                    
                    .container-child-one {
                      width:55%;
                    }
                    
                    .container-child-two {
                    
                    position: relative;
                      width:45%;
                    }
                    
                    .input_background {
                    border-radius: 16px;
                    background-color: #ffffff;
                   }
                    
                  select, input:focus{
                  outline: none;
                  }

                /* The popup chat - hidden by default */
                 .chat-popup {
                 display: block;
                 position: fixed;
                 bottom: 30px;
                 z-index: 9;
                 right: 30px;
                 -webkit-animation: bummer 2s;
                 animation: bummer 2s;
                 -webkit-transform: scale(0,0); 
                 transform: scale(0,0);
                 -webkit-animation-fill-mode: forwards;
                 animation-fill-mode: forwards;
                 }


                 @-webkit-keyframes bummer {
                 100% {
                  -webkit-transform: scale(1,1); 
                  }
                  }

                   @keyframes bummer {
                   100% {
                   transform: scale(1,1); 
                  }
                  } 
                    </style>
                    </head>
                    <body>


                    <div id="join_chat" class="chat-popup" >
                    <?php printf(
       '<img src="%1$s" height="60px" width="60px" alt="join_chat"/>',
        plugins_url( '/assets/images/whatsapp.png', __FILE__ )
        ); ?>
                   <!-- <img src="/assets/images/whatsapp.png">-->
                    </div>
                    


                    <!-- Trigger/Open The Modal -->
                    
                    <!-- The Modal -->
                    <div id="myModal" class="modal">
                    
                      <!-- Modal content -->
                      <div class="modal-content">
                        <div class="modal-header">
                          <span class="close">&times;</span>
                          <h2></h2>
                        </div>
                        <div class="modal-body">
                        
                         
                    
                    <div class="container">
                        <div class="container-child-one">
                      <h1 style="text-align:left;">Receive updates on WhatsApp</h1>
                            <p style="padding-left:10px; padding-right:10px;"><ul style="text-align:left;">
                      <li>Order details</li>
                      <li>Delivery updates</li>
                      <li>Customer support</li>
                    </ul> </p>
                    
                        </div>
                    
                        <div class="container-child-two">
                        <?php printf(
       '<img style="padding: 10px;" src="%1$s" alt="cart-abandonment-recovery-chat" />',
        plugins_url( '/assets/images/background.png', __FILE__ )
        ); ?>
                        
                <form style="width:100%; position:absolute; bottom:2px; padding: 0px 20px 0px 20px;" action>
                <select id="countryCode" style="width:100px; border-radius:10px; background:#d5d5d5; margin-left:4px; margin-bottom:3px;" name="countryCode">
                <option id="selected" data-countryCode="IN" value="91" Selected>India(+91)</option>
                <option data-countryCode="DZ" value="213">Algeria (+213)</option>
                <option data-countryCode="AD" value="376">Andorra (+376)</option>
                <option data-countryCode="AO" value="244">Angola (+244)</option>
                <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
                <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
                <option data-countryCode="AR" value="54">Argentina (+54)</option>
                <option data-countryCode="AM" value="374">Armenia (+374)</option>
                <option data-countryCode="AW" value="297">Aruba (+297)</option>
                <option data-countryCode="AU" value="61">Australia (+61)</option>
                <option data-countryCode="AT" value="43">Austria (+43)</option>
                <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
                <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
                <option data-countryCode="BH" value="973">Bahrain (+973)</option>
                <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
                <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
                <option data-countryCode="BY" value="375">Belarus (+375)</option>
                <option data-countryCode="BE" value="32">Belgium (+32)</option>
                <option data-countryCode="BZ" value="501">Belize (+501)</option>
                <option data-countryCode="BJ" value="229">Benin (+229)</option>
                <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
                <option data-countryCode="BT" value="975">Bhutan (+975)</option>
                <option data-countryCode="BO" value="591">Bolivia (+591)</option>
                <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
                <option data-countryCode="BW" value="267">Botswana (+267)</option>
                <option data-countryCode="BR" value="55">Brazil (+55)</option>
                <option data-countryCode="BN" value="673">Brunei (+673)</option>
                <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
                <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
                <option data-countryCode="BI" value="257">Burundi (+257)</option>
                <option data-countryCode="KH" value="855">Cambodia (+855)</option>
                <option data-countryCode="CM" value="237">Cameroon (+237)</option>
                <option data-countryCode="CA" value="1">Canada (+1)</option>
                <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
                <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
                <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
                <option data-countryCode="CL" value="56">Chile (+56)</option>
                <option data-countryCode="CN" value="86">China (+86)</option>
                <option data-countryCode="CO" value="57">Colombia (+57)</option>
                <option data-countryCode="KM" value="269">Comoros (+269)</option>
                <option data-countryCode="CG" value="242">Congo (+242)</option>
                <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
                <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
                <option data-countryCode="HR" value="385">Croatia (+385)</option>
                <option data-countryCode="CU" value="53">Cuba (+53)</option>
                <option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
                <option data-countryCode="CY" value="357">Cyprus South (+357)</option>
                <option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
                <option data-countryCode="DK" value="45">Denmark (+45)</option>
                <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
                <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
                <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
                <option data-countryCode="EC" value="593">Ecuador (+593)</option>
                <option data-countryCode="EG" value="20">Egypt (+20)</option>
                <option data-countryCode="SV" value="503">El Salvador (+503)</option>
                <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
                <option data-countryCode="ER" value="291">Eritrea (+291)</option>
                <option data-countryCode="EE" value="372">Estonia (+372)</option>
                <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
                <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
                <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
                <option data-countryCode="FJ" value="679">Fiji (+679)</option>
                <option data-countryCode="FI" value="358">Finland (+358)</option>
                <option data-countryCode="FR" value="33">France (+33)</option>
                <option data-countryCode="GF" value="594">French Guiana (+594)</option>
                <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
                <option data-countryCode="GA" value="241">Gabon (+241)</option>
                <option data-countryCode="GM" value="220">Gambia (+220)</option>
                <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
                <option data-countryCode="DE" value="49">Germany (+49)</option>
                <option data-countryCode="GH" value="233">Ghana (+233)</option>
                <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
                <option data-countryCode="GR" value="30">Greece (+30)</option>
                <option data-countryCode="GL" value="299">Greenland (+299)</option>
                <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
                <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
                <option data-countryCode="GU" value="671">Guam (+671)</option>
                <option data-countryCode="GT" value="502">Guatemala (+502)</option>
                <option data-countryCode="GN" value="224">Guinea (+224)</option>
                <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
                <option data-countryCode="GY" value="592">Guyana (+592)</option>
                <option data-countryCode="HT" value="509">Haiti (+509)</option>
                <option data-countryCode="HN" value="504">Honduras (+504)</option>
                <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
                <option data-countryCode="HU" value="36">Hungary (+36)</option>
                <option data-countryCode="IS" value="354">Iceland (+354)</option>
                <option data-countryCode="IN" value="91">India (+91)</option>
                <option data-countryCode="ID" value="62">Indonesia (+62)</option>
                <option data-countryCode="IR" value="98">Iran (+98)</option>
                <option data-countryCode="IQ" value="964">Iraq (+964)</option>
                <option data-countryCode="IE" value="353">Ireland (+353)</option>
                <option data-countryCode="IL" value="972">Israel (+972)</option>
                <option data-countryCode="IT" value="39">Italy (+39)</option>
                <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
                <option data-countryCode="JP" value="81">Japan (+81)</option>
                <option data-countryCode="JO" value="962">Jordan (+962)</option>
                <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
                <option data-countryCode="KE" value="254">Kenya (+254)</option>
                <option data-countryCode="KI" value="686">Kiribati (+686)</option>
                <option data-countryCode="KP" value="850">Korea North (+850)</option>
                <option data-countryCode="KR" value="82">Korea South (+82)</option>
                <option data-countryCode="KW" value="965">Kuwait (+965)</option>
                <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
                <option data-countryCode="LA" value="856">Laos (+856)</option>
                <option data-countryCode="LV" value="371">Latvia (+371)</option>
                <option data-countryCode="LB" value="961">Lebanon (+961)</option>
                <option data-countryCode="LS" value="266">Lesotho (+266)</option>
                <option data-countryCode="LR" value="231">Liberia (+231)</option>
                <option data-countryCode="LY" value="218">Libya (+218)</option>
                <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
                <option data-countryCode="LT" value="370">Lithuania (+370)</option>
                <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
                <option data-countryCode="MO" value="853">Macao (+853)</option>
                <option data-countryCode="MK" value="389">Macedonia (+389)</option>
                <option data-countryCode="MG" value="261">Madagascar (+261)</option>
                <option data-countryCode="MW" value="265">Malawi (+265)</option>
                <option data-countryCode="MY" value="60">Malaysia (+60)</option>
                <option data-countryCode="MV" value="960">Maldives (+960)</option>
                <option data-countryCode="ML" value="223">Mali (+223)</option>
                <option data-countryCode="MT" value="356">Malta (+356)</option>
                <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
                <option data-countryCode="MQ" value="596">Martinique (+596)</option>
                <option data-countryCode="MR" value="222">Mauritania (+222)</option>
                <option data-countryCode="YT" value="269">Mayotte (+269)</option>
                <option data-countryCode="MX" value="52">Mexico (+52)</option>
                <option data-countryCode="FM" value="691">Micronesia (+691)</option>
                <option data-countryCode="MD" value="373">Moldova (+373)</option>
                <option data-countryCode="MC" value="377">Monaco (+377)</option>
                <option data-countryCode="MN" value="976">Mongolia (+976)</option>
                <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
                <option data-countryCode="MA" value="212">Morocco (+212)</option>
                <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
                <option data-countryCode="MN" value="95">Myanmar (+95)</option>
                <option data-countryCode="NA" value="264">Namibia (+264)</option>
                <option data-countryCode="NR" value="674">Nauru (+674)</option>
                <option data-countryCode="NP" value="977">Nepal (+977)</option>
                <option data-countryCode="NL" value="31">Netherlands (+31)</option>
                <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
                <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
                <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
                <option data-countryCode="NE" value="227">Niger (+227)</option>
                <option data-countryCode="NG" value="234">Nigeria (+234)</option>
                <option data-countryCode="NU" value="683">Niue (+683)</option>
                <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
                <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
                <option data-countryCode="NO" value="47">Norway (+47)</option>
                <option data-countryCode="OM" value="968">Oman (+968)</option>
                <option data-countryCode="PK" value="92">Pakistan (+92)</option>
                <option data-countryCode="PW" value="680">Palau (+680)</option>
                <option data-countryCode="PA" value="507">Panama (+507)</option>
                <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
                <option data-countryCode="PY" value="595">Paraguay (+595)</option>
                <option data-countryCode="PE" value="51">Peru (+51)</option>
                <option data-countryCode="PH" value="63">Philippines (+63)</option>
                <option data-countryCode="PL" value="48">Poland (+48)</option>
                <option data-countryCode="PT" value="351">Portugal (+351)</option>
                <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
                <option data-countryCode="QA" value="974">Qatar (+974)</option>
                <option data-countryCode="RE" value="262">Reunion (+262)</option>
                <option data-countryCode="RO" value="40">Romania (+40)</option>
                <option data-countryCode="RU" value="7">Russia (+7)</option>
                <option data-countryCode="RW" value="250">Rwanda (+250)</option>
                <option data-countryCode="SM" value="378">San Marino (+378)</option>
                <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
                <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
                <option data-countryCode="SN" value="221">Senegal (+221)</option>
                <option data-countryCode="CS" value="381">Serbia (+381)</option>
                <option data-countryCode="SC" value="248">Seychelles (+248)</option>
                <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
                <option data-countryCode="SG" value="65">Singapore (+65)</option>
                <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
                <option data-countryCode="SI" value="386">Slovenia (+386)</option>
                <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
                <option data-countryCode="SO" value="252">Somalia (+252)</option>
                <option data-countryCode="ZA" value="27">South Africa (+27)</option>
                <option data-countryCode="ES" value="34">Spain (+34)</option>
                <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
                <option data-countryCode="SH" value="290">St. Helena (+290)</option>
                <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
                <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
                <option data-countryCode="SD" value="249">Sudan (+249)</option>
                <option data-countryCode="SR" value="597">Suriname (+597)</option>
                <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
                <option data-countryCode="SE" value="46">Sweden (+46)</option>
                <option data-countryCode="CH" value="41">Switzerland (+41)</option>
                <option data-countryCode="SI" value="963">Syria (+963)</option>
                <option data-countryCode="TW" value="886">Taiwan (+886)</option>
                <option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
                <option data-countryCode="TH" value="66">Thailand (+66)</option>
                <option data-countryCode="TG" value="228">Togo (+228)</option>
                <option data-countryCode="TO" value="676">Tonga (+676)</option>
                <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
                <option data-countryCode="TN" value="216">Tunisia (+216)</option>
                <option data-countryCode="TR" value="90">Turkey (+90)</option>
                <option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
                <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
                <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
                <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
                <option data-countryCode="UG" value="256">Uganda (+256)</option>
                <option data-countryCode="GB" value="44">UK (+44)</option> -->
                <option data-countryCode="UA" value="380">Ukraine (+380)</option>
                <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
                <option data-countryCode="UY" value="598">Uruguay (+598)</option>
                <option data-countryCode="US" value="1">USA (+1)</option>
                <option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
                <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
                <option data-countryCode="VA" value="379">Vatican City (+379)</option>
                <option data-countryCode="VE" value="58">Venezuela (+58)</option>
                <option data-countryCode="VN" value="84">Vietnam (+84)</option>
                <option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
                <option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
                <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
                <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
                <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
                <option data-countryCode="ZM" value="260">Zambia (+260)</option>
                <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
                </select>

                      <input id="number" class="input_background" style="background-color: #ffffff; width:100%; margin-bottom:5px;" type="text" id="number" name="number" value=""><br>
                      <input id="action" style="width:100%; background-color: #5cb85c; border-radius:15px;" type="button" value="CONFIRM">
                      <div id="response"></div>
                    </form> 
                      
                      </div>
                    
                    
                        </div>
                      
                      
                    </div>
                      
                      
                        <div class="modal-footer">
                          <h3>Shopping made more simple</h3>
                        </div>
                      </div>
                    
                    </div>

                    <script>

                    var nm = "<?php echo $join_the_chat_number_value_show ?>"
                    nm = nm.replace("+","");
                    console.log(nm);

                   function open_chat() {
                        if(detectMob()){
                        window.open("https://wa.me/"+nm+"?text=", "_blank");
                        } else {
                        window.open("https://web.whatsapp.com/send?phone="+nm+"&text=", "https://web.whatsapp.com");
                        }
                        }
                       // "+ $nm +"
                       //+ $text
                        
                        
                    function detectMob() {
                    return ( ( window.innerWidth <= 800 ) && ( window.innerHeight <= 600 ) );
                    }






                   document.getElementById("join_chat").addEventListener("click", open_chat);






                    // Get the modal
                    var numberCaptured = false;
                    var modal = document.getElementById("myModal");
                    
                    // Get the button that opens the modal
                    var btn = document.getElementById("myBtn");
                    
                    // Get the <span> element that closes the modal
                    var span = document.getElementsByClassName("close")[0];
                    
                    // When the user clicks the button, open the modal 
                    //btn.onclick = 
                    function openModal() {
                      modal.style.display = "block";
                    }
                    
                   var prod_id = "";

                    function add_abandonment() {
                  
                      //add_cart();
                    
                      jQuery( function($){
                      var number = $("#number").val();
                      var countryCode = document.getElementById("countryCode").value;
                      number = countryCode + number;
                    
                    $.ajax({
                       type: "post",
                       data: {ajax: 1,number: number, id: prod_id},
                       success: function(response){
                        console.log("oh"+response)
                        modal.style.display = "none";
                        
                       }
                      });
                      })
                    }
                    
                    function add_cart1() {
                    
                    
                  
                    }
                  
                  
                    // When the user clicks on <span> (x), close the modal
                    span.onclick = function() {
                      modal.style.display = "none";
                    }
                    
                    // When the user clicks anywhere outside of the modal, close it
                    window.onclick = function(event) {
                      if (event.target == modal) {
                        modal.style.display = "none";
                      }
                    }
                    </script>
                    
                    </body>
                    </html>
                  
                    <script type="text/javascript">




                   









                    jQuery( function($){
                        // The Ajax function

                        
                      
                        $(document.body).on('added_to_cart', function(a, b, c, d ) {

                            
                         prod_id   = d.data('product_id');
                          
                           if(!numberCaptured) {
                             numberCaptured = true;
                             modal.style.display = "block";
                             document.getElementById("action").addEventListener("click", add_abandonment);

                           } else {
                            add_abandonment();
                           }

                        });


                    });
                    </script>
                    <?php
                }


function m_custom_redirect( $product_id ) {

    // add your check if certain product should trigger the redirect
    if ( $product_id == 11 ) {

        // custom redirect url
        $custom_redirect_url = get_permalink(11);

        $data = array(
            'error'       => true,
            'product_url' => $custom_redirect_url
        );

        wp_send_json( $data );

        exit;

    }

}
           
  
  add_action('admin_menu', 'register_my_custom_submenu_page');
  
  function register_my_custom_submenu_page() {
      add_submenu_page( 'woocommerce', 'WA Abandonment', 'WA Abandonment', 'manage_options', 'my-custom-submenu-page', 'my_custom_submenu_page_callback' ); 
  }
  
  function my_custom_submenu_page_callback() {
  
global $wpdb;

  $table_name = $wpdb->prefix . "CARC_Abandonment";
  $result = $wpdb->get_results( "SELECT * FROM $table_name " );


  $table_name = $wpdb->prefix . "CARC_Variables";

  $meta_key = 'admin_name';
  $admin_name = $wpdb->get_var($wpdb->prepare("SELECT var_val FROM $table_name WHERE var_name = %s",$meta_key));


  $meta_key = 'store_name';
  $store_name = $wpdb->get_var($wpdb->prepare("SELECT var_val FROM $table_name WHERE var_name = %s",$meta_key));


  $meta_key = 'template_name';
  $template_name = $wpdb->get_var($wpdb->prepare("SELECT var_val FROM $table_name WHERE var_name = %s",$meta_key));


  $table_name = $wpdb->prefix . "CARC_Template";
  $templates = $wpdb->get_results( "SELECT * FROM $table_name " );

  $meta_key = $template_name;
  $text_message = $wpdb->get_var($wpdb->prepare("SELECT temp_text FROM $table_name WHERE temp_name = %s", $meta_key));

  $text_message = str_replace("{{admin_name}}", $admin_name, $text_message);
  $text_message = str_replace("{{store_name}}", $store_name, $text_message);

  $table_name = $wpdb->prefix . "CARC_Settings";
  $meta_key = 'join_the_chat_number';
  $join_the_chat_number_value = $wpdb->get_var($wpdb->prepare("SELECT var_val FROM $table_name WHERE var_name = %s", $meta_key));
  
  $meta_key = 'country_code';
  $country_code = $wpdb->get_var($wpdb->prepare("SELECT var_val FROM $table_name WHERE var_name = %s", $meta_key));
  $join_the_chat_number_value = str_replace($country_code,"", $join_the_chat_number_value);
//echo $join_the_chat_number_value;
 echo '<h1>Welcome to Cart Abandonment Recovery via Chat</h1>';

echo '<html><head><style>

.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    width: 80%;
  }
  
  /* Style the buttons inside the tab */
  .tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
  }
  
  /* Change background color of buttons on hover */
  .tab button:hover {
    background-color: #ddd;
  }
  
  /* Create an active/current tablink class 
  .tab button.active {
    background-color: #ccc;
  }*/
  
  /* Style the tab content */
  .tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
  }


table {
font-family: arial, sans-serif;
border-collapse: collapse;
width: 80%;

}

td, th {
border: 1px solid #dddddd;
text-align: left;
padding: 8px;
}

tr:nth-child(even) {
background-color: #dddddd;
}

#follow_up {
    display: none;
    }

#join_the_chat {
    display: none;
    }

    .vars {
background-color: #ccc;
margin-right: 4px;
padding-top: 4px;
padding-bottom: 4px;
padding-left: 4px;
padding-right: 4px;
border: 1px solid #dddddd;
    }

</style></head><body>';






echo '

<div class="tab">
  <button class="active"  id="defaultOpen">Reports</button>
  <button class="tablinks" id="follow_tab">Follow-up Messages</button>
  <button class="tablinks" id="join_the_chat_tab">Chat Button</button>
</div>
<br>


<div id="report">';
echo '<h2>Selected template message</h2>';
echo '<textarea id="selected_template" rows="4" cols="50">'. $text_message .'</textarea>';
  echo '<table border="1"> <tbody> <tr>
  <th>ProductId</th>
  <th>Number</th>
  <th>Time</th>
  <th>Product link</th>
  <th>Status</th>
  <th>Action</th>
 </tr>';
 
  foreach ( $result as $row )   {
   echo '<tr><td>'. $row->product_id .' </td> <td>'. $row->nm .' </td> <td>'. $row->time .' </td>
   
   <td>'. $row->link .' </td> <td>'. $row->status .'</td> <td><button class="send_message">Send</button></td> </tr>';
   
  }
  echo "</tbody>";
  echo '</table></div>';


  echo '<div id="follow_up">
  <h2>Variables</h2>
  <table border="1"> <tbody> 
  <tr><th>admin_name</th><td><input id="admin_input" type="text" value="'. $admin_name .'" placeholder="Customize"></td><td><button onclick="add_admin_value()">Update</button></td></tr>
  <tr><th>store_name</th><td><input id="store_input" type="text" value="'. $store_name .'" placeholder="Customize"></td><td><button onclick="add_store_value()">Update</button></td></tr>
  <tr><th>template</th><td><input id="template_input" type="text" value="'. $template_name .'" placeholder="Customize"></td><td><button onclick="add_template_value()">Update</button></td></tr>
  </tbody></table>';

echo '

<h2>Templates</h2>';

echo '<table border="1"> <tbody> <tr>
  <th>Name</th>
  <th>Value</th>
  <th>Action</th>
 </tr>';

foreach ( $templates as $row )   {
  echo '<tr><td>'. $row->temp_name .' </td> <td><input type="text" value="'. $row->temp_text .'"</td>
  <td><button class="update_template">Update</button></td> </tr>';
  
 }

 echo "</tbody></table> <br><br>";
  
echo '
<p><button id="admin_name_click" class="vars">admin_name</button> <button id="store_name_click" class="vars">store_name</button> <button id="product_link_click" class="vars">product_link</button></p>
<input id="temp_name" placeholder="Template Name" type="text">
<br><br>
<textarea id="temp_text" name="w3review" rows="4" cols="50"></textarea>
<br>
<button onclick="add_template()">Add New</button>
</div>';

echo '<div id="join_the_chat">';

echo '

<h2>Set your chat number</h2>
<select id="countryCode" style="width:100px; border-radius:10px; background-color:#d5d5d5; margin-left:4px; margin-bottom:3px;" name="countryCode">
                <option id="selected" data-countryCode="IN" value="91" Selected>India(+91)</option>
                <option data-countryCode="DZ" value="213">Algeria (+213)</option>
                <option data-countryCode="AD" value="376">Andorra (+376)</option>
                <option data-countryCode="AO" value="244">Angola (+244)</option>
                <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
                <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
                <option data-countryCode="AR" value="54">Argentina (+54)</option>
                <option data-countryCode="AM" value="374">Armenia (+374)</option>
                <option data-countryCode="AW" value="297">Aruba (+297)</option>
                <option data-countryCode="AU" value="61">Australia (+61)</option>
                <option data-countryCode="AT" value="43">Austria (+43)</option>
                <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
                <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
                <option data-countryCode="BH" value="973">Bahrain (+973)</option>
                <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
                <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
                <option data-countryCode="BY" value="375">Belarus (+375)</option>
                <option data-countryCode="BE" value="32">Belgium (+32)</option>
                <option data-countryCode="BZ" value="501">Belize (+501)</option>
                <option data-countryCode="BJ" value="229">Benin (+229)</option>
                <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
                <option data-countryCode="BT" value="975">Bhutan (+975)</option>
                <option data-countryCode="BO" value="591">Bolivia (+591)</option>
                <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
                <option data-countryCode="BW" value="267">Botswana (+267)</option>
                <option data-countryCode="BR" value="55">Brazil (+55)</option>
                <option data-countryCode="BN" value="673">Brunei (+673)</option>
                <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
                <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
                <option data-countryCode="BI" value="257">Burundi (+257)</option>
                <option data-countryCode="KH" value="855">Cambodia (+855)</option>
                <option data-countryCode="CM" value="237">Cameroon (+237)</option>
                <option data-countryCode="CA" value="1">Canada (+1)</option>
                <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
                <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
                <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
                <option data-countryCode="CL" value="56">Chile (+56)</option>
                <option data-countryCode="CN" value="86">China (+86)</option>
                <option data-countryCode="CO" value="57">Colombia (+57)</option>
                <option data-countryCode="KM" value="269">Comoros (+269)</option>
                <option data-countryCode="CG" value="242">Congo (+242)</option>
                <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
                <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
                <option data-countryCode="HR" value="385">Croatia (+385)</option>
                <option data-countryCode="CU" value="53">Cuba (+53)</option>
                <option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
                <option data-countryCode="CY" value="357">Cyprus South (+357)</option>
                <option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
                <option data-countryCode="DK" value="45">Denmark (+45)</option>
                <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
                <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
                <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
                <option data-countryCode="EC" value="593">Ecuador (+593)</option>
                <option data-countryCode="EG" value="20">Egypt (+20)</option>
                <option data-countryCode="SV" value="503">El Salvador (+503)</option>
                <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
                <option data-countryCode="ER" value="291">Eritrea (+291)</option>
                <option data-countryCode="EE" value="372">Estonia (+372)</option>
                <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
                <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
                <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
                <option data-countryCode="FJ" value="679">Fiji (+679)</option>
                <option data-countryCode="FI" value="358">Finland (+358)</option>
                <option data-countryCode="FR" value="33">France (+33)</option>
                <option data-countryCode="GF" value="594">French Guiana (+594)</option>
                <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
                <option data-countryCode="GA" value="241">Gabon (+241)</option>
                <option data-countryCode="GM" value="220">Gambia (+220)</option>
                <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
                <option data-countryCode="DE" value="49">Germany (+49)</option>
                <option data-countryCode="GH" value="233">Ghana (+233)</option>
                <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
                <option data-countryCode="GR" value="30">Greece (+30)</option>
                <option data-countryCode="GL" value="299">Greenland (+299)</option>
                <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
                <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
                <option data-countryCode="GU" value="671">Guam (+671)</option>
                <option data-countryCode="GT" value="502">Guatemala (+502)</option>
                <option data-countryCode="GN" value="224">Guinea (+224)</option>
                <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
                <option data-countryCode="GY" value="592">Guyana (+592)</option>
                <option data-countryCode="HT" value="509">Haiti (+509)</option>
                <option data-countryCode="HN" value="504">Honduras (+504)</option>
                <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
                <option data-countryCode="HU" value="36">Hungary (+36)</option>
                <option data-countryCode="IS" value="354">Iceland (+354)</option>
                <option data-countryCode="IN" value="91">India (+91)</option>
                <option data-countryCode="ID" value="62">Indonesia (+62)</option>
                <option data-countryCode="IR" value="98">Iran (+98)</option>
                <option data-countryCode="IQ" value="964">Iraq (+964)</option>
                <option data-countryCode="IE" value="353">Ireland (+353)</option>
                <option data-countryCode="IL" value="972">Israel (+972)</option>
                <option data-countryCode="IT" value="39">Italy (+39)</option>
                <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
                <option data-countryCode="JP" value="81">Japan (+81)</option>
                <option data-countryCode="JO" value="962">Jordan (+962)</option>
                <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
                <option data-countryCode="KE" value="254">Kenya (+254)</option>
                <option data-countryCode="KI" value="686">Kiribati (+686)</option>
                <option data-countryCode="KP" value="850">Korea North (+850)</option>
                <option data-countryCode="KR" value="82">Korea South (+82)</option>
                <option data-countryCode="KW" value="965">Kuwait (+965)</option>
                <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
                <option data-countryCode="LA" value="856">Laos (+856)</option>
                <option data-countryCode="LV" value="371">Latvia (+371)</option>
                <option data-countryCode="LB" value="961">Lebanon (+961)</option>
                <option data-countryCode="LS" value="266">Lesotho (+266)</option>
                <option data-countryCode="LR" value="231">Liberia (+231)</option>
                <option data-countryCode="LY" value="218">Libya (+218)</option>
                <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
                <option data-countryCode="LT" value="370">Lithuania (+370)</option>
                <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
                <option data-countryCode="MO" value="853">Macao (+853)</option>
                <option data-countryCode="MK" value="389">Macedonia (+389)</option>
                <option data-countryCode="MG" value="261">Madagascar (+261)</option>
                <option data-countryCode="MW" value="265">Malawi (+265)</option>
                <option data-countryCode="MY" value="60">Malaysia (+60)</option>
                <option data-countryCode="MV" value="960">Maldives (+960)</option>
                <option data-countryCode="ML" value="223">Mali (+223)</option>
                <option data-countryCode="MT" value="356">Malta (+356)</option>
                <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
                <option data-countryCode="MQ" value="596">Martinique (+596)</option>
                <option data-countryCode="MR" value="222">Mauritania (+222)</option>
                <option data-countryCode="YT" value="269">Mayotte (+269)</option>
                <option data-countryCode="MX" value="52">Mexico (+52)</option>
                <option data-countryCode="FM" value="691">Micronesia (+691)</option>
                <option data-countryCode="MD" value="373">Moldova (+373)</option>
                <option data-countryCode="MC" value="377">Monaco (+377)</option>
                <option data-countryCode="MN" value="976">Mongolia (+976)</option>
                <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
                <option data-countryCode="MA" value="212">Morocco (+212)</option>
                <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
                <option data-countryCode="MN" value="95">Myanmar (+95)</option>
                <option data-countryCode="NA" value="264">Namibia (+264)</option>
                <option data-countryCode="NR" value="674">Nauru (+674)</option>
                <option data-countryCode="NP" value="977">Nepal (+977)</option>
                <option data-countryCode="NL" value="31">Netherlands (+31)</option>
                <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
                <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
                <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
                <option data-countryCode="NE" value="227">Niger (+227)</option>
                <option data-countryCode="NG" value="234">Nigeria (+234)</option>
                <option data-countryCode="NU" value="683">Niue (+683)</option>
                <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
                <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
                <option data-countryCode="NO" value="47">Norway (+47)</option>
                <option data-countryCode="OM" value="968">Oman (+968)</option>
                <option data-countryCode="PK" value="92">Pakistan (+92)</option>
                <option data-countryCode="PW" value="680">Palau (+680)</option>
                <option data-countryCode="PA" value="507">Panama (+507)</option>
                <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
                <option data-countryCode="PY" value="595">Paraguay (+595)</option>
                <option data-countryCode="PE" value="51">Peru (+51)</option>
                <option data-countryCode="PH" value="63">Philippines (+63)</option>
                <option data-countryCode="PL" value="48">Poland (+48)</option>
                <option data-countryCode="PT" value="351">Portugal (+351)</option>
                <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
                <option data-countryCode="QA" value="974">Qatar (+974)</option>
                <option data-countryCode="RE" value="262">Reunion (+262)</option>
                <option data-countryCode="RO" value="40">Romania (+40)</option>
                <option data-countryCode="RU" value="7">Russia (+7)</option>
                <option data-countryCode="RW" value="250">Rwanda (+250)</option>
                <option data-countryCode="SM" value="378">San Marino (+378)</option>
                <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
                <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
                <option data-countryCode="SN" value="221">Senegal (+221)</option>
                <option data-countryCode="CS" value="381">Serbia (+381)</option>
                <option data-countryCode="SC" value="248">Seychelles (+248)</option>
                <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
                <option data-countryCode="SG" value="65">Singapore (+65)</option>
                <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
                <option data-countryCode="SI" value="386">Slovenia (+386)</option>
                <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
                <option data-countryCode="SO" value="252">Somalia (+252)</option>
                <option data-countryCode="ZA" value="27">South Africa (+27)</option>
                <option data-countryCode="ES" value="34">Spain (+34)</option>
                <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
                <option data-countryCode="SH" value="290">St. Helena (+290)</option>
                <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
                <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
                <option data-countryCode="SD" value="249">Sudan (+249)</option>
                <option data-countryCode="SR" value="597">Suriname (+597)</option>
                <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
                <option data-countryCode="SE" value="46">Sweden (+46)</option>
                <option data-countryCode="CH" value="41">Switzerland (+41)</option>
                <option data-countryCode="SI" value="963">Syria (+963)</option>
                <option data-countryCode="TW" value="886">Taiwan (+886)</option>
                <option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
                <option data-countryCode="TH" value="66">Thailand (+66)</option>
                <option data-countryCode="TG" value="228">Togo (+228)</option>
                <option data-countryCode="TO" value="676">Tonga (+676)</option>
                <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
                <option data-countryCode="TN" value="216">Tunisia (+216)</option>
                <option data-countryCode="TR" value="90">Turkey (+90)</option>
                <option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
                <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
                <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
                <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
                <option data-countryCode="UG" value="256">Uganda (+256)</option>
                <option data-countryCode="GB" value="44">UK (+44)</option> -->
                <option data-countryCode="UA" value="380">Ukraine (+380)</option>
                <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
                <option data-countryCode="UY" value="598">Uruguay (+598)</option>
                <option data-countryCode="US" value="1">USA (+1)</option>
                <option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
                <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
                <option data-countryCode="VA" value="379">Vatican City (+379)</option>
                <option data-countryCode="VE" value="58">Venezuela (+58)</option>
                <option data-countryCode="VN" value="84">Vietnam (+84)</option>
                <option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
                <option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
                <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
                <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
                <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
                <option data-countryCode="ZM" value="260">Zambia (+260)</option>
                <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
                </select>
<input id="join_the_chat_number" placeholder="Number" value="'. $join_the_chat_number_value .'" type="text">
<br><br>
<!--<textarea id="temp_text" name="w3review" rows="4" cols="50"></textarea>
<br>-->
<button onclick="add_join_the_chat_number()">Update</button>
</div>';

  echo "</body>";

  wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom_script.js', array( 'jquery' ));


  echo '<script type="text/javascript">

  document.getElementById("countryCode").value = '. $country_code .'

  function add_template() {
  let temp_name = document.getElementById("temp_name").value;
  let temp_text = document.getElementById("temp_text").value;
  jQuery.ajax({
     type: "post",
     data: {template: 1,temp_name: temp_name, temp_text: temp_text},
     success: function(response){
        alert("Successfull updated!! Please refresh the page to see changes.");
     }
    });

  }



  function add_admin_value() {
    let admin_input = document.getElementById("admin_input").value;
    jQuery.ajax({
       type: "post",
       data: {update_vars: 1,var_name: "admin_name", var_val: admin_input},
       success: function(response){
        alert("Successfull updated!! Please refresh the page to see changes.");
       }
      });
  
    }



  function add_join_the_chat_number() {
    let join_the_chat_number = document.getElementById("join_the_chat_number").value;
    let countryCode = document.getElementById("countryCode").value;
    join_the_chat_number = "+" + countryCode + join_the_chat_number;
    countryCode = "+" + countryCode;
    jQuery.ajax({
       type: "post",
       data: {join_the_chat_number: join_the_chat_number, cc: countryCode},
       success: function(response){
        alert("Successfull updated!! Please refresh the page to see changes.");
       }
      });
  
    }


    function add_store_value() {
      let store_input = document.getElementById("store_input").value;
      jQuery.ajax({
         type: "post",
         data: {update_vars: 1,var_name: "store_name", var_val: store_input},
         success: function(response){
            alert("Successfull updated!! Please refresh the page to see changes.");
         }
        });
    
      }


      function add_template_value() {
        let template_input = document.getElementById("template_input").value;
        jQuery.ajax({
           type: "post",
           data: {update_vars: 1,var_name: "template_name", var_val: template_input},
           success: function(response){
            alert("Successfull updated!! Please refresh the page to see changes.");
           }
          });
      
        }
    
  

  document.getElementById("defaultOpen").style.backgroundColor = "#ccc";

  document.getElementById("defaultOpen").addEventListener("click", default_open);
  function default_open() {
    document.getElementById("follow_up").style.display = "none";
    document.getElementById("join_the_chat").style.display = "none";
    document.getElementById("report").style.display = "block";
    document.getElementById("join_the_chat_tab").style.backgroundColor = "";
    document.getElementById("follow_tab").style.backgroundColor = "";
    document.getElementById("defaultOpen").style.backgroundColor = "#ccc";

  }

  document.getElementById("follow_tab").addEventListener("click", follow_open);
  
  function follow_open() {
    document.getElementById("report").style.display = "none";
    document.getElementById("join_the_chat").style.display = "none";
    document.getElementById("follow_up").style.display = "block";
    document.getElementById("defaultOpen").style.backgroundColor = "";
    document.getElementById("join_the_chat_tab").style.backgroundColor = "";
    document.getElementById("follow_tab").style.backgroundColor = "#ccc";
  }

  document.getElementById("join_the_chat_tab").addEventListener("click", join_the_chat_open);

  function join_the_chat_open() {
    document.getElementById("report").style.display = "none";
    document.getElementById("follow_up").style.display = "none";
    document.getElementById("join_the_chat").style.display = "block";
    document.getElementById("defaultOpen").style.backgroundColor = "";
    document.getElementById("follow_tab").style.backgroundColor = "";
    document.getElementById("join_the_chat_tab").style.backgroundColor = "#ccc";
  }




  document.getElementById("admin_name_click").addEventListener("click", add_name);
  document.getElementById("store_name_click").addEventListener("click", add_store);
  document.getElementById("product_link_click").addEventListener("click", add_link);

function add_name() {
  document.getElementById("temp_text").value = document.getElementById("temp_text").value + "{{admin_name}}";
}

function add_store() {
  console.log(document.getElementById("temp_text").value);
  document.getElementById("temp_text").value = document.getElementById("temp_text").value + "{{store_name}}";
}

function add_link() {
  
  document.getElementById("temp_text").value = document.getElementById("temp_text").value + "{{product_link}}";
}


';


  echo 'jQuery(function($) {

  //console.log(text);
  $(".send_message").click(function() {
    var $row = $(this).closest("tr"),       
    $tds = $row.find("td");  


    $nm = $tds[1].innerText;
    $link = $tds[3].innerText;
    var $text = document.getElementById("selected_template").value;
    console.log($text);
    $text = $text.replace("{{product_link}}",$link);

   $text = encodeURI($text);
   
    console.log("ggggppp"+ $text);
    console.log($nm +"  "+$link);  

    if(detectMob()){
        window.open("https://wa.me/"+ $nm +"?text="+ $text, "_blank");
        } else {
          window.open("https://web.whatsapp.com/send?phone="+ $nm +"&text="+ $text, "https://web.whatsapp.com");
        }

/*$.each($tds, function() {              
    console.log($(this).text());   
});*/

});

});
  
function detectMob() {
    return ( ( window.innerWidth <= 800 ) && ( window.innerHeight <= 600 ) );
  }
  </script>';
  
  echo "</html>"; 

  }
            }

  
  
  }
  
  }


  
  if(class_exists("CARC_Popup")) {
  $CARC_Popup = new CARC_Popup();
  }
  
 
  
  
  
  
  //activation
  
  register_activation_hook(__FILE__, array( $CARC_Popup, 'activate') );
  
  //deactivation
  
  register_deactivation_hook(__FILE__, array( $CARC_Popup, 'deactivate') );
  
  //uninstall
  

  function carc_get_product_price($product_id) {

    $product = wc_get_product($product_id);
    return $product->get_price();

  }
  
  // Handle AJAX request (start)
  if( isset($_POST['ajax']) && isset($_POST['number']) ){

    $custom_redirect_url = get_permalink(sanitize_key($_POST['id']));
  
echo $custom_redirect_url;
    global $wpdb;
    $table_name = $wpdb->prefix . 'CARC_Abandonment';
    
$product_id_value = sanitize_key($_POST['id']);

$product_number = sanitize_text_field($_POST['number']);
$product_status = "Abandoned";



$wpdb->insert( 
$table_name, 
array( 
'time' => current_time( 'mysql' ), 
'product_id' => $product_id_value, 
'nm' => $product_number,
'link'=> $custom_redirect_url,
'status' => $product_status,
) 
);
   exit;
  }






  if( isset($_POST['template']) && isset($_POST['temp_name']) ){
  
  
      global $wpdb;
      $table_name = $wpdb->prefix . 'CARC_Template';
      
      $temp_name = sanitize_text_field($_POST['temp_name']);
      $temp_text = sanitize_text_field($_POST['temp_text']);
  
  $wpdb->insert( 
  $table_name, 
  array( 
  'temp_name' => $temp_name, 
  'temp_text' => $temp_text, 
  ) 
  );
     exit;

    }
  


    if (isset($_POST['update_vars']) && isset($_POST['var_name'])) {

      global $wpdb;
      $table_name = $wpdb->prefix . 'CARC_Variables';

      $var_name = sanitize_text_field($_POST['var_name']);
      $var_val = sanitize_text_field($_POST['var_val']);
      $data = ['var_val' => $var_val]; // NULL value.
      $where = ['var_name' => $var_name];
      $wpdb->update($table_name, $data, $where);
      exit;
  }


  if (isset($_POST['join_the_chat_number'])) {

    global $wpdb;
    $table_name = $wpdb->prefix . 'CARC_Settings';

    $var_name = sanitize_text_field("country_code");
    $var_val = sanitize_text_field($_POST['cc']);
    $data = ['var_val' => $var_val]; // NULL value.
    $where = ['var_name' => $var_name];
    $wpdb->update($table_name, $data, $where);

    $var_name = sanitize_text_field("join_the_chat_number");
    $var_val = sanitize_text_field($_POST['join_the_chat_number']);
    $data = ['var_val' => $var_val]; // NULL value.
    $where = ['var_name' => $var_name];
    $wpdb->update($table_name, $data, $where);

    exit;
}



  
  function carc_create_db() {
  
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'CARC_Abandonment';
  
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      nm mediumtext NOT NULL,
      product_id text NOT NULL,
      revenue text NOT NULL,
      link text NOT NULL,
      status text NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";
  
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
  }



  function carc_create_db_template() {
  
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'CARC_Template';
  
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      temp_name mediumtext NOT NULL,
      temp_text text NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";
  
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    $wpdb->insert(
      $table_name,
      array(
          'temp_name' => 'Default_Template',
          'temp_text' => "Hi, I can see you added {{product_link}} to cart but couldn't complete checkout. Should I help you with that?",
      )
    );
  }

  function carc_create_db_vars() {
  
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'CARC_Variables';
  
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      var_name text NOT NULL,
      var_val text NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";
  
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    $wpdb->insert(
      $table_name,
      array(
          'var_name' => 'template_name',
          'var_val' => 'Default_Template',
      )
    );
  
    $wpdb->insert(
      $table_name,
      array(
          'var_name' => 'admin_name',
          'var_val' => '',
      )
  );
  $wpdb->insert(
    $table_name,
    array(
        'var_name' => 'store_name',
        'var_val' => '',
    )
);


  }

  function carc_create_db_settings() {
  
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'CARC_Settings';

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      var_name text NOT NULL,
      var_val text NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";
  
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );

    $wpdb->insert(
      $table_name,
      array(
          'var_name' => 'join_the_chat_number',
          'var_val' => "",
      )
    );

    $wpdb->insert(
        $table_name,
        array(
            'var_name' => 'country_code',
            'var_val' => "91",
        )
      );
  }

  }
  

