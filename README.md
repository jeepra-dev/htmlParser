# HtmlParser V1.0.1 Released
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

# HtmParser V2.0
<p>In comming...New features</p>
<ul>
  <li>add parent param when search</li>
</ul>
