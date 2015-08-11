<?php 
          ini_set("display_errors","On");
          error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
          require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
          require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
          $db = new DB(HOST,USER,PASSWORD,DATABASE);
          $db->connect();
          if(isset($_POST['submit'])) {
          $post_msg = "";
          if($_POST['firstname'] == ""){
          $post_msg .= "First name";
          }
          else{
          $sql = "INSERT INTO forms.contact
          (form_id, firstname, middlename, lastname, nickname, email, role, gender, street_address, street_address_2, city, state, country, postal_code, phone, dob, high_school, high_school_city, high_school_country, anticipated_grad_year, academic_interests, extra_curricular, ethnicity, reference, mail_list, `call`, comment, date_submitted) 
          VALUES (form_id, 'firstname', 'middlename', 'lastname', 'nickname', 'email', 'role', 'gender', 'street_address', 'street_address_2', 'city', 'state', 'country', 'postal_code', 'phone', 'dob', high_school, high_school_city, high_school_country, anticipated_grad_year, 'academic_interests', 'extra_curricular', 'ethnicity', 'reference', 'mail_list', 'call', 'comment', 'date_submitted');
          ";
          }
          }
          ?>
          <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
          <html xmlns="http://www.w3.org/1999/xhtml">
          <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <title>Untitled Document</title>
          <style>
          body{
          font-family:"Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
          font-size:12px;
          }
          p, h1, form, button{border:0; margin:0; padding:0;}
          .spacer{clear:both; height:1px;}
          /* ----------- My Form ----------- */
          .myform{
          margin:0 auto;
          width:530px;
          padding:6px;
          }
          /* ----------- stylized ----------- */
          #stylized{
          border:solid 1px #b7ddf2;
/*          background:#ebf4fb; */
          }
          #stylized h1 {
          font-size:14px;
          font-weight:bold;
          margin-bottom:8px;
          }
          #stylized p{
          font-size:11px;
          color:#666666;
          margin-bottom:20px;
          border-bottom:solid 1px #b7ddf2;
          padding-bottom:10px;
          }
          #stylized label{
          display:block;
          text-align:right;
          width:140px;
		  padding-top: 5px;
          float:left;
          }
	#stylized label.labelwide{
		width: 340px;
		text-align:left;
		padding: 0;
		margin: 0;
	}
	#stylized label.labelmed{
		text-align:right; 
		width: 180px;
		padding: 0;
		margin: 0;
	}
          #stylized .small{
          color:#666666;
          display:block;
          font-size:11px;
          font-weight:normal;
          text-align:right;
          width:140px;
          }
          #stylized input{
          float:left;
          font-size:11px;
          padding:4px 2px;
          border:solid 1px #aacfe4;
          width:200px;
          margin:2px 0 20px 10px;
          }
          #stylized select{
          float:left;
          font-size:12px;
          padding:4px 2px;
          border:solid 1px #aacfe4;
          width:206px;
          margin:2px 0 20px 10px;
          }
		   #stylized input.radio{
			  width: 10px;
			  border: 0;
			  margin-left: 5px;
			  margin-right: 5px;
		  }
          #stylized button{
          clear:both;
          margin-left:150px;
          width:125px;
          height:31px;
          background:#666666 url(img/button.png) no-repeat;
          text-align:center;
          line-height:31px;
          color:#FFFFFF;
          font-size:11px;
          font-weight:bold;
          }
          .required {
          color:#FF0000;
          font-size:14px;
          padding: 0 5px;
          }
          </style>
          </head>
          <body>
          <div id="stylized" class="myform">
          <form id="form" name="form" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>">
          <p><strong>Your Information</strong> ( * = required field) </p>
<div style="clear:both">
          <label for="fname">Student First Name
          <!-- <span class="small">Add your name</span> -->
          </label>
          <input type="text" name="fname" id="fname" /><span class="required">*</span>
          </div>
		<div style="clear:both">
          <label for="mname">Student Middle Name
          </label>
          <input type="text" name="mname" id="mname" />
		</div>

        <div style="clear:both">
          <label for="lname">Student Last Name
          </label>
          <input type="text" name="lname" id="lname" /><span class="required">*</span>
        </div>
        
        <div style="clear:both">
          <label for="nickname">Usually Called
          </label>
          <input type="text" name="nickname" id="nickname" />
		</div>
        <div style="clear: both">
          <label for="gender">Gender
          </label>
	      <div style="margin: 0 0 0 150px;">
              <div style="float:left">
              <input class="radio" type="radio" name="gender" id="gender" value="m" />Male </div>
              <div style="padding: 0 0 0 10px; float:left">
              <input class="radio" type="radio" name="gender" id="gender" value="f" />Female</div>
          </div>
        <div class="spacer"></div>
        <div style="clear:both">
          <label for="street_address">Street Address
          </label>
          <input type="text" name="street_address" id="street_address" /><span class="required">*</span>
        </div>
		<div style="clear:both">
		  <label for="city">City
          </label>
          <input type="text" name="city" id="city" /><span class="required">*</span>
        </div>
        <div style="clear:both">
          <label for="state">State/Province
          </label>
          <select name="state" id="state" />
              <option>--- please select ---</option>
              <option>AA</option>
              <option>AE</option>
              <option>AL</option>
              <option>AK</option>
              <option>AP</option>
              <option>AR</option>
              <option>AS</option>
              <option>AZ</option>
              <option>CA</option>
              <option>CO</option>
              <option>CT</option>
              <option>DC</option>
              <option>DE</option>
              <option>FL</option>
              <option>FM</option>
              <option>GA</option>
              <option>GU</option>
              <option>HI</option>
              <option>ID</option>
              <option>IL</option>
              <option>IN</option>
              <option>IA</option>
              <option>KS</option>
              <option>KY</option>
              <option>LA</option>
              <option>ME</option>
              <option>MD</option>
              <option>MA</option>
              <option>MH</option>
              <option>MI</option>
              <option>MN</option>
              <option>MP</option>
              <option>MS</option>
              <option>MO</option>
              <option>MT</option>
              <option>NE</option>
              <option>NV</option>
              <option>NH</option>
              <option>NJ</option>
              <option>NM</option>
              <option>NY</option>
              <option>NC</option>
              <option>ND</option>
              <option>OH</option>
              <option>OK</option>
              <option>OR</option>
              <option>PA</option>
              <option>PR</option>
              <option>PW</option>
              <option>RI</option>
              <option>SC</option>
              <option>SD</option>
              <option>TN</option>
              <option>TX</option>
              <option>UT</option>
              <option>VI</option>
              <option>VT</option>
              <option>VA</option>
              <option>WA</option>
              <option>WV</option>
              <option>WI</option>
              <option>WY</option>
              <option>AB</option>
              <option>BC</option>
              <option>MB</option>
              <option>NB</option>
              <option>NL</option>
              <option>NT</option>
              <option>NS</option>
              <option>NU</option>
              <option>ON</option>
              <option>PE</option>
              <option>QC</option>
              <option>SK</option>
              <option>YT</option>
              <option>not applicable</option>
          </select>
          <span class="required">*</span>
		</div>
        <div style="clear:both">
          <label for="zip">Zip/Postal Code
          </label>
          <input type="text" name="zip" id="zip" /><span class="required">*</span>
		</div>
        <div style="clear:both">
          <label for="country">Country
          </label>
          <input type="text" name="country" id="country" />
		</div>
        <div style="clear:both">
          <label for="email">Student E-mail
          </label>
          <input type="email" name="email" id="email" style="margin:2px 0 4px 10px" />
          <div style="clear:both; padding: 0 0 0 150px; font-size:10px">We won't ask you to type it twice (we know you hate that), but we do ask that you enter your email address carefully, as it is our primary mode of contact.</div>
		</div>
        <div style="clear:both">
          <label for="dob_month">Month</label>
          <select name="dob_month" id="dob_month" />
          	<option>---Please Select---</option>
          	<option>01</option>
          	<option>02</option>
          	<option>03</option>
          	<option>04</option>
          	<option>05</option>
          	<option>06</option>
          	<option>07</option>
          	<option>08</option>
          	<option>09</option>
          	<option>10</option>
          	<option>11</option>
          	<option>12</option>
          </select>
        </div>
        <div style="clear:both">
          <label for="dob_day">Day</label>
          <select name="dob_day" id="dob_day" />
          	<option>---Please Select---</option>
          	<option>01</option>
          	<option>02</option>
          	<option>03</option>
          	<option>04</option>
          	<option>05</option>
          	<option>06</option>
          	<option>07</option>
          	<option>08</option>
          	<option>09</option>
          	<option>10</option>
          	<option>11</option>
          	<option>12</option>
          	<option>13</option>
          	<option>14</option>
          	<option>15</option>
          	<option>16</option>
          	<option>17</option>
          	<option>18</option>
          	<option>19</option>
          	<option>20</option>
          	<option>21</option>
          	<option>22</option>
          	<option>23</option>
          	<option>24</option>
          	<option>25</option>
          	<option>26</option>
          	<option>27</option>
          	<option>28</option>
          	<option>29</option>
          	<option>30</option>
          	<option>31</option>
          </select>          
        </div>
        <div style="clear:both">
          <label for="dob_year">Year</label>
          <select name="dob_year" id="dob_year" />
          	<option>1980</option>
          	<option>1981</option>
          	<option>1982</option>
          	<option>1983</option>
          	<option>1984</option>
          	<option>1985</option>
          	<option>1986</option>
          	<option>1987</option>
          	<option>1988</option>
          	<option>1989</option>
          	<option>1990</option>
          	<option>1991</option>
          	<option>1992</option>
          	<option>1993</option>
          	<option>1994</option>
          	<option>1995</option>
          	<option>1996</option>
          	<option>1997</option>
          	<option>1998</option>
          	<option>1999</option>
          	<option>2000</option>
          </select>
        </div>
        <div style="clear:both">
          <label for="high_school">High School
          </label>
          <input type="text" name="high_school" id="high_school" />
		</div>        
        <div style="clear:both">
          <label for="high_school_city">High School City/Town</label>
          <input type="text" name="high_school_city" id="high_school_city" />
		</div>        
        <div style="clear:both">
          <label for="high_school_state">High School State/Province
          </label>
          <select name="high_school_state" id="high_school_state" />
              <option>--- please select ---</option>
              <option>AA</option>
              <option>AE</option>
              <option>AL</option>
              <option>AK</option>
              <option>AP</option>
              <option>AR</option>
              <option>AS</option>
              <option>AZ</option>
              <option>CA</option>
              <option>CO</option>
              <option>CT</option>
              <option>DC</option>
              <option>DE</option>
              <option>FL</option>
              <option>FM</option>
              <option>GA</option>
              <option>GU</option>
              <option>HI</option>
              <option>ID</option>
              <option>IL</option>
              <option>IN</option>
              <option>IA</option>
              <option>KS</option>
              <option>KY</option>
              <option>LA</option>
              <option>ME</option>
              <option>MD</option>
              <option>MA</option>
              <option>MH</option>
              <option>MI</option>
              <option>MN</option>
              <option>MP</option>
              <option>MS</option>
              <option>MO</option>
              <option>MT</option>
              <option>NE</option>
              <option>NV</option>
              <option>NH</option>
              <option>NJ</option>
              <option>NM</option>
              <option>NY</option>
              <option>NC</option>
              <option>ND</option>
              <option>OH</option>
              <option>OK</option>
              <option>OR</option>
              <option>PA</option>
              <option>PR</option>
              <option>PW</option>
              <option>RI</option>
              <option>SC</option>
              <option>SD</option>
              <option>TN</option>
              <option>TX</option>
              <option>UT</option>
              <option>VI</option>
              <option>VT</option>
              <option>VA</option>
              <option>WA</option>
              <option>WV</option>
              <option>WI</option>
              <option>WY</option>
              <option>AB</option>
              <option>BC</option>
              <option>MB</option>
              <option>NB</option>
              <option>NL</option>
              <option>NT</option>
              <option>NS</option>
              <option>NU</option>
              <option>ON</option>
              <option>PE</option>
              <option>QC</option>
              <option>SK</option>
              <option>YT</option>
              <option>not applicable</option>
          </select>
          <span class="required">*</span>
		</div>

        <div style="clear:both">
          <label for="high_school_country">High School Country</label>
          <input type="text" name="high_school_country" id="high_school_country" />
		</div>        
        <div style="clear:both">
          <label for="anticipated_grad_year">Anticipated Year of Graduation</label>
          <input type="text" name="anticipated_grad_year" id="anticipated_grad_year" />
		</div>        
        <div style="clear:both; padding: 0 0 10px 0; ">
          <label for="academic_interests">Academic Interests</label>
          <textarea style="width: 350px; height: 80px; margin: 0 0 0 10px;" name="academic_interests" id="academic_interests" /></textarea>
		</div>
        <div style="clear:both; padding: 0 0 10px 0; ">
          <label for="extra_interests">Extra Curricular Interests</label>
          <textarea style="width: 350px; height: 80px; margin: 0 0 0 10px;" name="extra_interests" id="extra_interests" /></textarea>
		</div>
        <div style="clear:both; width:500px; text-align:center">
        	Ethnic Background (Optional) <em>Please check all that apply</em>
		</div>
        <div style="clear:both; margin-left: 150px ">
			<div style="clear:both;">
            	<div style="clear:none; float:left;" >
                <input class="radio" type="checkbox" name="ethnicity_af" id="ethnicity_af" value="Yes" /></div>
                <div style="clear:right; float:left; width: 150px;" >
            	<label for="ethnicity_af" class="labelwide">African American, Black</label>            	
                </div>
            </div>
			<div style="clear:both;">
            	<div style="clear:none; float:left;" >
                	<input class="radio" style="margin-bottom: 0;" type="checkbox" name="ethnicity_ai" id="ethnicity_ai" value="Yes" />
				</div>
                <div style="clear:none; float:left" >
	                <label for="ethnicity_ai" class="labelwide">American Indian, Alaska Native</label>
                </div>
            </div>
			<div style="clear:both;">
            	<div style="clear:none; float:left" >
					<div style="clear:none; float:left" >
    	                <label for="ethnicity_ai_tribe" style="margin:0"><em>tribal affiliation:</em></label></div>
	            	<div style="clear:none; float:left" >
        	            <input style="width: 90px; margin: 2px" type="text" name="ethnicity_ai_tribe" id="ethnicity_ai_tribe" /></div>
                </div>
            </div>
			<div style="clear:both;">
            	<div style="clear:none; float:left" >
					<div style="clear:none; float:left" >
    	                <label for="ethnicity_ai_enrolled" style="margin:0"><em>enrolled:</em></label></div>
	            	<div style="clear:none; float:left" >
        	            <input style="width: 90px; margin: 2px" type="text" name="ethnicity_ai_enrolled" id="ethnicity_ai_enrolled" /></div>
                </div>
            </div>
			<div style="clear:both;">
            	<div style="clear:none; float:left;" >
                	<input class="radio" type="checkbox" name="ethnicity_as" id="ethnicity_as" value="Yes" />
				</div>
                <div style="clear:none; float:left" >
	                <label for="ethnicity_as" class="labelwide">Asian American</label>
                </div>
            </div>
		</div>

          <button type="submit" name="submit" id="submit">Sign-up</button>
          <div class="spacer"></div>
          </form>
      </div>
</body>
</html>