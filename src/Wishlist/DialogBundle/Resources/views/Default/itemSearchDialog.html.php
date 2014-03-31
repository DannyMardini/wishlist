<div id='itemSearchDialog' title='Item Search'>
    
<input type="hidden" id="itemId" />    
<div class="dropdown">
    <select id="search-vendor" class="form-control">
      <option></option>
      <option value="1">Amazon</option>
      <option value="2">Best Buy</option>      
    </select>    
</div>
<br />
<div class="well">       
    <input id="item-search-keywords" type='text' placeholder='Type search item name' />
    <button id="item-search-submit" type="button" for="item-search-keywords" class="btn btn-default">
        <span class="ui-icon ui-icon-search"></span>
    </button>
</div>
<span id='resultsArea' class='message'></span>
<h4 id="otherItem"><small>Can't find what you want? <a class="btn btn-default btn-sm" role="button">Create New Item</a></small></h4>
</div>