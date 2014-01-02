function parseFilename(fname)
{
	//Verify that this is a valid PDF file
	fname = fname.trim();
	if(fname.slice(-4) != ".pdf")
		return false;

	var n = fname.substr(0,fname.length-4).split("_");
	var result = n[0].toUpperCase();

	//Get year and session
	if(n[1].length == 5)
	{
		switch(n[1][4])
		{
			case 'f': result += "\nfall"; break;
			case 'w': result += "\nwinter"; break;
			case 'p': result += "\nspring"; break;
			case 's': result += "\nsummer"; break;
		}
	}
	result += "\n" + n[1].substr(0,4);

	//Get assessment type and number
	switch(n[2][0])
	{
		case 'q': result += "\nquiz"; break;
		case 't': result += "\ntest"; break;
		case 'm': result += "\nmidterm"; break;
		case 'x': result += "\nfinal exam"; break;
	}
	if(n[2].length > 1)
		result += " " + n[2].substr(1);

	//Get extra parameters
	for(i=3; i < n.length; i++)
	{
		switch(n[i])
		{
			case 'solutions': result += ",\nSOLUTIONS"; break;
			case 'mconly': result += ",\nmultiple choice only"; break;
			case 'wronly': result += ",\nwritten only"; break;
			case 'scan': result += ",\nscan"; break;
			case 'unofficial': result += ",\nunofficial"; break;
			case 'partial': result += ",\npartial/incomplete"; break;
		}
	}

	return result;
}

function fullParse(elem,link)
{
	old = elem.innerHTML;
	elem.innerHTML = '<a' + (link ? ' href="get.php?f=' + old + '"' : '') + '>' + parseFilename(old) + '</a>';
}
