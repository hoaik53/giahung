var yourdomain = "http://www.altotraffico.net/pagerank";
var request_url = "";
if (window.checkpagerank_url == "" || window.checkpagerank_url == "%domainname%") 
{
	alert("http://www.altotraffico.net/seotool");
}
else
{
	request_url += "?url=" + escape(checkpagerank_url);
	document.write('<iframe id="fr" src="'+ yourdomain + '/get.alexapr.php'+request_url+'" frameborder="0" marginheight="0" marginwidth="0" width="105" height="80" scrolling="no"></iframe>');
}