# xmlParser
<h2>Hello Evrybody</h2>
<p>This source code allow to parse your file and extract them.</p>
<h4>1. Include files</h4>
<pre>
  require 'TagFunc.php';
  require 'SeekTagByData.php';
</pre>

<h4>2. init object</h4>
<pre>
  $parser = new TagFunc($filename:string, $tag:string);
  $SeekTagByData = new SeekTagByData($parser:TagFunc);
</pre>

<h4>2. Search</h4>
<pre>
  $SeekTagByData->search([$key => $value,......]): Array;
</pre>
