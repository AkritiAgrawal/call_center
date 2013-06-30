<script src="jquery.js"></script>
	<script src="dateSelectBoxes.js"></script>
	<script type="text/javascript">// <![CDATA[
	$().ready(function () { 
		$().dateSelectBoxes($('#monthdropdown'),$('#daydropdown'),$('#yeardropdown'));
	//	$().dateSelectBoxes($('#birthMonth2'),$('#birthDay2'),$('#birthYear2'),true);
	});
	// ]]&gt;</script>

<script type="text/javascript">

function validate()
{
	var pwd = document.cust.pwd;
	if(isEmpty(pwd))
	{
		alert("Password cannot be empty");
		pwd.focus();
		return false;
	}
	if(isLengthSufficient(pwd,6)==false)
	{
		alert("Password should be atleast 6 chars long");
		pwd.focus();
		return false;
	}
	var cpwd = document.cust.Cpwd.value;
	if(cpwd!=pwd.value)
	{
		alert("Password and confirm password not same");
		pwd.focus();
		return false;
	}

	var mobile = document.cust.mobileNo;
	if(isEmpty(mobile)==false)
	{
		if(isNumber(mobile)==false)
		{
			alert("Mobile number can contain only numbers");
			mobile.focus();
			return false;
		}
		if(isMobile(mobile.value)==false)
		{
			alert("Mobile Number should contain 10 digits only");
			mobile.focus();
			return false;
		}
	}
	var state = document.cust.state;
	if(isEmpty(state))
	{
		alert("State cannot be empty");
		state.focus();
		return false;
	}
	if(!isAlphabet(state))
	{
		alert("State can be alphabets only");
		state.focus();
		return false;
	}
	var city = document.cust.city;
	if(isEmpty(city))
	{
		alert("City cannot be empty");
		city.focus();
		return false;
	}
	if(!isAlphabet(city))
	{
		alert("City can be alphabets only");
		state.focus();
		return false;
	}
	return true;
}

function isEmpty(str)
{
	var str1 = str.value;
	if(str1.length==0)
	{
		return true;
	}
	return false;
}

function isAlphabet(str)
{
	var alphaExp = /^[a-zA-Z]+$/;
	if(str.value.match(alphaExp)){
		//alert(str.value);
		return true;
	}
	return false;
}

function isLengthSufficient(str,len)
{
	var x = str.value;
	if(x.length<len)
	{	
		return false;
	}
	return true;
}


function isNumber(str)
{
	if(isNaN(str.value)==true)
	{
		return false;
	}
	return true;
}

function isMobile(str)
{
	if(str.length==10)
	{	
		return true;
	}
	return false;
}
</script>

</head>

<body>
<form name="cust" action="index.php?sec=AddEngg" method="POST" onsubmit="return validate()">
<br />
<br />
<h3 style="left:100px;  position:relative;">
	Engineer Registration 
</h3>
<br />
<br />
<br />
<br /><table>
<input type="hidden" value="<?php echo '$_POST[userId]' ?>"/>
<tr>
	<td> Password :</td>
	<td> <input type="password" name="pwd" /> </td>
</tr>
<tr>
	<td> Confirm Password :</td>
	<td> <input type="password" name="Cpwd" /> </td>
</tr>
<tr>
	<td> Mobile Number :</td>
	<td> <input type="text" name="mobileNo" /> </td>
</tr>
<tr>
	<td>Date of Birth :</td>
	<td colspan="3">
		<select id="yeardropdown" name="yeardropdown">
			<option value="1950"> 1950</option>
			<option value="1951"> 1951</option>
			<option value="1952"> 1952</option>
			<option value="1953"> 1953</option>
			<option value="1954"> 1954</option>
			<option value="1955"> 1955</option>
			<option value="1956"> 1956</option>
			<option value="1957"> 1957</option>
			<option value="1958"> 1958</option>
			<option value="1959"> 1959</option>
			<option value="1960"> 1960</option>
			<option value="1961"> 1961</option>
			<option value="1962"> 1962</option>
			<option value="1963"> 1963</option>
			<option value="1964"> 1964</option>
			<option value="1965"> 1965</option>
			<option value="1966"> 1966</option>
			<option value="1967"> 1967</option>
			<option value="1968"> 1968</option>
			<option value="1969"> 1969</option>
			<option value="1970"> 1970</option>
			<option value="1971"> 1971</option>
			<option value="1972"> 1972</option>
			<option value="1973"> 1973</option>
			<option value="1974"> 1974</option>
			<option value="1975"> 1975</option>
			<option value="1976"> 1976</option>
			<option value="1977"> 1977</option>
			<option value="1978"> 1978</option>
			<option value="1979"> 1979</option>
			<option value="1980"> 1980</option>
			<option value="1981"> 1981</option>
			<option value="1982"> 1982</option>
			<option value="1983"> 1983</option>
			<option value="1984"> 1984</option>
			<option value="1985"> 1985</option>
			<option value="1986"> 1986</option>
			<option value="1987"> 1987</option>
			<option value="1988"> 1988</option>
			<option value="1989"> 1989</option>
			<option value="1990"> 1990</option>
			<option value="1991"> 1991</option>
			<option value="1992"> 1992</option>
			<option value="1993"> 1993</option>
			<option value="1994"> 1994</option>
			<option value="1995"> 1995</option>
			<option value="1996"> 1996</option>
			<option value="1997"> 1997</option>
			<option value="1998"> 1998</option>
			<option value="1999"> 1999</option>
			<option value="2000"> 2000</option>
			<option value="2001"> 2001</option>
			<option value="2002"> 2002</option>
			<option value="2003"> 2003</option>
			<option value="2004"> 2004</option>
			<option value="2005"> 2005</option>
			<option value="2006"> 2006</option>
			<option value="2007"> 2007</option>
			<option value="2008"> 2008</option>
			<option value="2009"> 2009</option>
			<option value="2010"> 2010</option>
			<option value="2011"> 2011</option>
			<option value="2012"> 2012</option>
			<option value="2013"> 2013</option>
		</select>
		<select id="monthdropdown" name="monthdropdown">
			<option value="1"> Jan</option>
			<option value="2"> Feb</option>
			<option value="3"> March</option>
			<option value="4"> April</option>
			<option value="5"> May</option>
			<option value="6"> June</option>
			<option value="7"> July</option>
			<option value="8"> Aug</option>
			<option value="9"> Sep</option>
			<option value="10"> Oct</option>
			<option value="11"> Nov</option>
			<option value="12"> Dec</option>
		</select> 
		<select id="daydropdown" name="daydropdown">
			<option value="1"> 1</option>
			<option value="2"> 2</option>
			<option value="3"> 3</option>
			<option value="4"> 4</option>
			<option value="5"> 5</option>
			<option value="6"> 6</option>
			<option value="7"> 7</option>
			<option value="8"> 8</option>
			<option value="9"> 9</option>
			<option value="10"> 10</option>
			<option value="11"> 11</option>
			<option value="12"> 12</option>
			<option value="13"> 13</option>
			<option value="14"> 14</option>
			<option value="15"> 15</option>
			<option value="16"> 16</option>
			<option value="17"> 17</option>
			<option value="18"> 18</option>
			<option value="19"> 19</option>
			<option value="20"> 20</option>
			<option value="21"> 21</option>
			<option value="22"> 22</option>
			<option value="23"> 23</option>
			<option value="24"> 24</option>
			<option value="25"> 25</option>
			<option value="26"> 26</option>
			<option value="27"> 27</option>
			<option value="28"> 28</option>
			<option value="29"> 29</option>
			<option value="30"> 30</option>
			<option value="31"> 31</option>
		</select> 
		
	</td>
		
</tr>	
<tr>
	<td> Gender : </td>
	<td colspan="2"> <input type="radio" name="gender" value="male" checked>Male </input>
					<input type="radio" name="gender" value="female">Female </input>
	</td>
</tr>
<tr>
	<td>I live in :</td>
	<td> Country : </td>
	<td> 
	<select name="country">
<?php
		$con=mysqli_connect("localhost","root","","call_center");
		// Check connection
		if (mysqli_connect_errno())
		  {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  }

		$result = mysqli_query($con,"SELECT * FROM country");

		while($row = mysqli_fetch_array($result))
		  { ?>
		 <option value = "<?php echo $row['Country_Code'] ?>"> <?php echo $row['Country_Name']; ?>
		  <?php
		  }

		mysqli_close($con);
?>
				
		</select>
</tr>	
<tr>
	<td> &nbsp; </td>
	<td> State</td>
	<td><input type="text" name="state"></td>
</tr>
<tr>
	<td> &nbsp; </td>
	<td> City</td>
	<td><input type="text" name="city"></td>
</tr>
<tr>
	<td><input type="submit" name="SubAddEngg" value="Submit" /></td>
	<td><input type="reset" name="reset" value="Cancel"</td>
	
</tr>
</form>