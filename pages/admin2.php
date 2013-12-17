<script type="text/javascript" src="assets/js/tabbed.layout.js"></script>
<script type="text/javascript">
tabs = function(options) {
    
    var defaults = {  
        selector: '.tabs',
        selectedClass: 'selected'
    };  
    
    if(typeof options == 'string') defaults.selector = options;
    var options = $.extend(defaults, options); 

    return $(options.selector).each(function(){
                                
        var obj = this;	
        var targets = Array();

        function show(i){
            $.each(targets,function(index,value){
                $(value).hide();
            })
            $(targets[i]).fadeIn('fast');
            $(obj).children().removeClass(options.selectedClass);
            selected = $(obj).children().get(i);
            $(selected).addClass(options.selectedClass);
        };

        $('a',this).each(function(i){	
            targets.push($(this).attr('href'));
            $(this).click(function(e){
                e.preventDefault();
                show(i);
            });
        });
        
        show(0);

    });			
}
// initialize the function
tabs('nav ul');
</script>
<style type="text/css">
nav li{
    list-style:none;
    float:left;
    height:7%;
    line-height:24px;
    -moz-box-shadow:0 0 3px #888;
    -webkit-box-shadow:0 0 3px #888;
    box-shadow:0 0 3px #888;
    margin:0 2px;
    width:9%;
    overflow:hidden;
    position:relative;
    background:-webkit-gradient(linear, left top, left bottom, from(#ccc), to(#aaa));
    background:-moz-linear-gradient(top,  #ccc,  #aaa);
    }
nav li.selected{
  background:#FFF;
  color: #000;
}
nav li a, nav li a:visited, nav li a:hover{
  list-style:none;
  display:block;
  position:absolute;
  top:0;
  left:-2px;
  height:8%;
  line-height:24px;
  width: 10%; 
  text-align:center;
  color:#333; 
  font-size:11px;
  text-shadow:#e8e8e8 0 1px 0;
  -moz-box-shadow:inset 0 1px 1px #888;
  -webkit-box-shadow:inset 0 1px 1px #888;
  box-shadow:inset 0 1px 1px #888;
  } 
</style>
</head>
<header>
<h1>Admin</h1>
</header>
<nav> 
    <ul>
        <li><a href="#tab1">Coins</a></li>
        <li><a href="#tab2">Users</a></li>
        <li><a href="#tab3">Violations</a></li>
        <li><a href="#tab4">Database</a></li>
		<li><a href="#tab5">Stats</a></li>
		<li><a href="#tab6">Operations</a></li> 
		<li><a href="#tab7">Api</a></li>
    </ul>
</nav>

<section class="tab" id="tab1">
1
</section>

<section class="tab" id="tab2">
2
</section>

<section class="tab" id="tab3">
3
</section>

<section class="tab" id="tab4">
4
</section>

<section class="tab" id="tab5">
5
</section>

<section class="tab" id="tab6">
6
</section>

<section class="tab" id="tab7">
7
</section>