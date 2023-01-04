<style>
pre[class*="language-"] {
	position:relative;
	overflow: auto;
	padding:1rem 0 1rem 1rem;
	border-radius:10px;
}

button{
	position:absolute;
	top:5px;
	right:5px;
	background-color: #555555; /* Green */
	border: none;
	color: white;
	padding: 5px 32px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 16px;
}
button:hover{
	cursor:pointer;
	background-color:#bcbabb;
}
main {
	display: grid;
	max-width: auto;
	margin: 0px auto;
}
h1{
	font-size:1.3rem;
}
</style>
<link rel="stylesheet" href="https://prismjs.com/themes/prism-tomorrow.css">
<link rel="stylesheet" href="https://prismjs.com/plugins/line-numbers/prism-line-numbers.css">
<script>

// check all code blocks if have needed css classes if not then add
// select all pre tag element on the page  
var blockElments = document.querySelectorAll('pre');

// Loop the tag element list and add classes
for (var i = 0; i < blockElments.length; i++) {
  
  if (!blockElments[i].className.includes("language")) { 
    // id the element's class name doesn't contain language setting then add language-xml to it
    blockElments[i].className += ' language-xml';
  }
  if (!blockElments[i].className.includes("line-numbers")) { 
    // id the element's class name doesn't contain line-numbers then add to it
    blockElments[i].className += ' line-numbers';
  } 
 
}	

function addCopyButtons(clipboard) {

	    document.querySelectorAll('pre > code').forEach(function (codeBlock) {
	        var button = document.createElement('button');
	        button.className = 'copy-code-button';
	        button.type = 'button';
	        button.innerText = '<?= l(112); ?>';

	        button.addEventListener('click', function () {
	            clipboard.writeText(codeBlock.innerText).then(function () {
	                /* Chrome doesn't seem to blur automatically,
	                   leaving the button in a focused state. */
	                button.blur();

	                button.innerText = '<?= l(113); ?>';
                  
	                setTimeout(function () {
	                    button.innerText = '<?= l(112); ?>';
	                }, 2000);
	            }, function (error) {
	                button.innerText = 'Error';
	            });
	        });

	        var pre = codeBlock.parentNode;
	        if (pre.parentNode.classList.contains('highlight')) {
	            var highlight = pre.parentNode;
	            highlight.parentNode.insertBefore(button, highlight);
	        } else {
	            pre.parentNode.insertBefore(button, pre);
	        }
	    });
	}
	
	window.onload = (event) => {
	  addCopyButtons(clipboard);
	};
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/2.7.0/clipboard-polyfill.promise.js"></script>
<script src="https://prismjs.com/prism.js"></script>
<script language="javascript" type="text/javascript">
function PassEncrypt() {
	document.getElementById("disp").style.display = 'block';
	var password = document.getElementById("hashing").value;
	$('#result_hash').load('../system/plugins/ajax/encrypt.php?password=' + password);
}
function Copy() {
	var range = document.createRange();
	range.selectNode(document.getElementById("result_hash"));
	window.getSelection().removeAllRanges(); // clear current selection
	window.getSelection().addRange(range); // to select text
	document.execCommand("copy");
	window.getSelection().removeAllRanges();// to deselect
}
</script>