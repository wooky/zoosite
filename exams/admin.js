function editTxt(elem,txt)
{
        var w = window.prompt("Enter a description for the " + elem.toUpperCase() + " course:",(txt ? txt : ""));
        if(w != null)
                window.location.href = "rename.php?elem=" + elem + "&txt=" + w;
}

function deleteExam(fname)
{
	if(confirm("Are you sure you want to delete the '" + parseFilename(fname).split("\n").join(" ") + "' exam?") == true)
		window.location.href = "delete.php?fname=" + fname;
}
