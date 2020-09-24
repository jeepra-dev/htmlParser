# HtmlParser V1.0.1 Released
<h2>Hello Evrybody</h2>
<p>The advantage with this parser is that it does not consume a lot of ram or cpu.</p>

<p>We took a search by letter approach, instead of storing the whole file in a variable.</p>
<p>This source code allow to parse your file and extract the tag you want.</p>

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
  SeekTagByData::search([$key => $value,......]): Array;
</pre>

# HtmlParser V2.0
<p>In comming...New features</p>
<ul>
  <li>add parent param when search</li>
</ul>
