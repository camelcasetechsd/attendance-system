
window.onload = clearCurrentLink;
function clearCurrentLink(){
    var a = $(".users-list a");
    for(var i=0; i<a.length; i++)
        if (a[i].href == window.location.href.split("#")[0] && a[i].href !="http://attendance.local/users" )
            removeNode(a[i]);
}

function removeNode(n){
    if (n.hasChildNodes())
        for (var i=0; i<n.childNodes.length; i++)
          n.parentNode.insertBefore(n.childNodes[i].cloneNode(true),n);
        n.parentNode.removeChild(n);
}
