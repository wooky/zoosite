function load()
{
	var uri = "/" + window.location.pathname.substr(1);
	var children = document.getElementById('topsidemenu').getElementsByTagName('li');
	for(var i = 0; i < children.length; i++)
	{
		if(uri == children[i].getElementsByTagName('a')[0].getAttribute("href"))
		{
			children[i].getElementsByTagName('a')[0].className = "active";
			return;
		}
	}
}

function loadTwitter()
{
	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
}
