function editTxt(elem,txt)
{
	w = window.prompt("Enter a description for the " + elem.toUpperCase() + " course:",(txt ? txt : ""));
	if(w != null)
		window.location.href = "rename.php?elem=" + elem + "&txt=" + w;
}

function deleteExam(fname)
{
	f = parseFilename(fname);
	if(!f || confirm("Are you sure you want to delete the file '" + f.split("\n").join(" ") + "'?") == true)
		window.location.href = "fileman.php?act=delete&fname=" + fname;
}

function moveExam(fname)
{
	w = window.prompt("Rename the filename " + fname + " (don't forget the .pdf at the end!)", fname);
	if(w != null)
		window.location.href = "fileman.php?act=move&fname=" + fname + "&dest=" + w;
}