<script type="text/javascript">
	(function(){
        var t,i,e,n=window,o=document,a=arguments,s="script",r=["config","track","identify","visit","push","call","trackForm","trackClick"],c=function(){var t,i=this;for(i._e=[],t=0;r.length>t;t++)(function(t){i[t]=function(){return i._e.push([t].concat(Array.prototype.slice.call(arguments,0))),i}})(r[t])};for(n._w=n._w||{},t=0;a.length>t;t++)n._w[a[t]]=n[a[t]]=n[a[t]]||new c;i=o.createElement(s),i.async=1,i.src="//static.woopra.com/js/w.js",e=o.getElementsByTagName(s)[0],e.parentNode.insertBefore(i,e)
	})("woopra");
 
	// configure tracker
	woopra.config({
		domain: '{{ Request::getHost() }}',
	    ping_interval: 12000
	});

	// Identify customer
	woopra.identify({
	    email: '{{ Auth::user()->correo_electronico }}',
	    name: '{{ Auth::user()->nombre_usuario }}',
	    avatar: '{{ Auth::user()->imagen_usuario }}',
	    // gender: '{{ Auth::user()->genero_usuario }}'
	});

	// track pageview
	woopra.track();
</script>
